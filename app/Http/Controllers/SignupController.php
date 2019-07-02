<?php

namespace App\Http\Controllers;

use App\Signup;
use App\SiteCustomer;
use App\Store;
use App\Price;
use App\InvoicePayment;
use App\AuthorizeNetPaymentHistory;
use Illuminate\Http\Request;


//paypal lib
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
//paypal lib 

use GuzzleHttp\Client;

class SignupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Site ";
    private $sdc;
    private $_api_content;
    public function __construct(){ 

          $paypal_conf=\Config::get('paypal');
          $this->_api_content=new ApiContext(new OAuthTokenCredential(
              $paypal_conf['client_id'],
              $paypal_conf['secret']
          ));

          $this->_api_content->setConfig($paypal_conf['settings']);

          $this->sdc = new StaticDataController(); 

          $this->authorizenet = new AuthorizeNetPaymentController(); 
    }

    public function onlineorder(Request $request)
    {

        $invoice=Signup::select('signups.*',\DB::raw('(SELECT count(authorize_net_payment_histories.id) from authorize_net_payment_histories WHERE authorize_net_payment_histories.customer_id=signups.id) as cardpayment'),\DB::raw('(SELECT count(invoice_payments.id) from invoice_payments WHERE invoice_payments.customer_id=signups.id) as paypalpayment'))->get();
        //dd($invoice);
        return view('admin.apps.pages.order.signup',compact('invoice'));
    }

    public function initiateSingup(Request $request)
    {

        $accountST=0;
        $chkPaidAccount=Signup::where('email',$request->email)->where('payment_status','Paid')->count();
        $chkAccount=Signup::where('email',$request->email)->where('payment_status','Pending')->count();

        $checkServerTwo=$this->CheckUserRequestRequest($request->email);

        if($chkAccount>0)
        {
            Signup::where('email',$request->email)->where('payment_status','Pending')->delete();
        }
        elseif($chkPaidAccount==1)
        {
            $accountST=1;
        }
        elseif($checkServerTwo==1)
        {
            $accountST=1;
        }

        if($accountST==0)
        {
            $prInfo=Price::find($request->package);

            $tab=new Signup();
            $tab->name=$request->name;
            $tab->company_name=$request->company_name;
            $tab->phone=$request->phone;
            $tab->address=$request->address;
            $tab->email=$request->email;
            $tab->password=\Hash::make($request->password);
            $tab->package=$request->package;
            $tab->package_name=$prInfo->title;
            $tab->save();

            $accountST=$tab->id;
        }
        else
        {
            $accountST=1;
        }

        return response()->json($accountST);

        //dd($tab);
    }

    private function convertDateFromCard($dateStr='')
    {
        if(!empty($dateStr))
        {
            $dataSplit=explode("/", $dateStr);
            if(count($dataSplit)==2)
            {
                return "20".trim($dataSplit[1])."-".trim($dataSplit[0]);
            }
            
        }
    }

    public function refund(Request $request)
    {
        $id=$request->rid;
        if(!empty($request->rid))
        {
            $refId='ref' .time();
            $aNpH=AuthorizeNetPaymentHistory::find($id);
            //die($aNpH);
            $retData=$this->authorizenet->refundTransaction(
                $aNpH->transactionID,
                $aNpH->card_number,
                $aNpH->card_expire_date,
                $aNpH->paid_amount,
                $aNpH->refTransID);
            if($retData==1)
            {
                $aNpH->refund_status=2;
            }
            else
            {
                $aNpH->refund_status=1;
            }
            $aNpH->save();
            return $retData;
        }
        else
        {
            return 0;
        }
        
           
    }

    public function voidTransaction(Request $request)
    {
        $id=$request->rid;
        if(!empty($request->rid))
        {
            $refId='ref' .time();
            $aNpH=AuthorizeNetPaymentHistory::find($id);
            //die($aNpH);
            $retData=$this->authorizenet->voidTransactions($refId,$aNpH->transactionID);
            if($retData==1)
            {
                $aNpH->refund_status=2;
            }
            else
            {
                $aNpH->refund_status=1;
            }
            $aNpH->save();
            return $retData;
        }
        else
        {
            return 0;
        }
        
           
    }

    public function AuthorizenetCardPayment(Request $request,$invoiceid='')
    {

        $invoice_id=str_replace("SPX","", $invoiceid);

        $acInfo=Signup::find($invoice_id);       

        $packageInfo=Price::find($acInfo->package);  
        $packageId=$packageInfo->id;  
        $packageName=$packageInfo->title;  
        $packagePrice=$packageInfo->price;  


        $refId=$invoice_id;
        $cardNumber=trim(str_replace(" ","",$request->cardNumber)); 
        $expireDateStr=trim($request->cardExpire);
        $expireDate=$this->convertDateFromCard($expireDateStr);

        if(!$expireDate)
        {
           return response()->json(['status'=>0,'message'=>'Card Expire date invalid.']);
        }

        //dd($request->amountToPay);

        $retData=$this->authorizenet->captureCardPayment($refId,$cardNumber,$expireDate,$packagePrice);

        if($retData['status']==1)
        {

            $tab=new AuthorizeNetPaymentHistory;
            $tab->customer_id=$acInfo->id;
            $tab->customer_name=$acInfo->name;
            $tab->package_id=$packageId;
            $tab->package_name=$packageName;
            $tab->card_number=$cardNumber;
            $tab->card_holder_name=$request->cardHName;
            $tab->card_expire_date=$expireDate;
            $tab->card_cvc=$request->cardcvc;
            $tab->paid_amount=$packagePrice;
            $tab->refTransID=$retData['refTransID'];
            $tab->authCode=$retData['authCode'];
            $tab->transactionID=$retData['transactionID'];
            $tab->CardType=$retData['CardType'];
            $tab->transactionHash=$retData['transactionHash'];
            $tab->message=$retData['message'];
            $tab->save();

            $acInfoUp=Signup::find($invoice_id);   
            $acInfoUp->payment_status='Paid';   
            $acInfoUp->save(); 

            $invoiceCustomerSync=$this->genaratePaidRequest($acInfo);
            if($invoiceCustomerSync==1)
            {
                $acInfoUp=Signup::find($invoice_id);   
                $acInfoUp->sync_status='Done';   
                $acInfoUp->save(); 
                
                return response()->json(['status'=>1,'message'=>'Payment Complete &amp; Your Account has been created, Please login now & change your password on first time login. use this link for login app.simpleretailpos.com or click on login button.']);
            }
            else
            {
                return response()->json(['status'=>1,'message'=>'Payment Complete, You will get your access detail notified by email shortly.']);
            }  



        }
        else
        {
            return response()->json(['status'=>0,'message'=>'Transaction failed, Please try again.']);
        }
        
        //return response()->json($retData);
    }


    public function posPayPaypal($invoiceid='')
    {
            $invoice_id=str_replace("SPX","", $invoiceid);

            $acInfo=Signup::find($invoice_id);       

            $packageInfo=Price::find($acInfo->package);  
            $packageId=$packageInfo->id;  
            $packageName=$packageInfo->title;  
            $packagePrice=$packageInfo->price;  
            
            $payer = new Payer();
            $payer->setPaymentMethod("paypal");

            $item1 = new Item();
            $item1->setName('INVCUS - '.$invoice_id)
                    ->setCurrency('USD')
                    ->setQuantity(1)
                    ->setSku($packageId) // Similar to `item_number` in Classic API
                    ->setPrice($packagePrice);
            


            $itemList = new ItemList();
            $itemList->setItems(array($item1));   

            $details = new Details();
            $details->setSubtotal($packagePrice); 

            $amount = new Amount();
            $amount->setCurrency("USD")
                    ->setTotal($packagePrice)
                    ->setDetails($details);   
            
            $transaction = new Transaction();
            $transaction->setAmount($amount)
                ->setItemList($itemList)
                //->setDescription("Package Yearly");
                ->setInvoiceNumber(uniqid()); 

            //$baseUrl = url();
            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl(url('initiate/paypal/SPCX'.$invoice_id.'/success'))
                ->setCancelUrl(url('initiate/paypal/SPCX'.$invoice_id.'/cancel'));

            $payment = new Payment();
            $payment->setIntent("sale")
                    ->setPayer($payer)
                    ->setRedirectUrls($redirectUrls)
                    ->setTransactions(array($transaction));


            try {
                $payment->create($this->_api_content);
            } catch (\PayPal\Exception\PPConnectionException $ex) {

                dd($ex);
                if(\Config::get('app.debug'))
                {
                    \Session::put('error','Connection has timeout.!!!!, Please try again.');
                    return redirect('/');
                }
                else
                {
                    \Session::put('error','Something went wrong.!!!!, Please try again.');
                    return redirect('/');
                }
            }


            foreach($payment->getLinks() as $link){
                if($link->getRel()=='approval_url')
                {
                    $redirect_url=$link->getHref();
                    break;
                }
            }

            \Session::put('paypal_payment_id',$payment->getId());

            if(isset($redirect_url))
            {
                return redirect($redirect_url);
            }

            \Session::put('error','Unknown error occured, Please try again.!!!!!');
            return redirect('/');
    }

    //http://localhost/laravel/simpleretailfrontend/public/initiate/paypal/SPCX15/success?paymentId=PAYID-LSTZ3FY4LK68805TA391535D&token=EC-3HN45411US784693T&PayerID=6X54DU8ENHY58

    public function getPOSPaymentStatusPaypal(Request $request,$invoice_id=0,$status='fahad')
    {
        //dd($invoice_id);
        $payment_id=\Session::get('paypal_payment_id')?\Session::get('paypal_payment_id'):'';

        if(!empty($payment_id))
        {
            \Session::forget('paypal_payment_id');


            if(empty($request->PayerID) || empty($request->token))
            {
                \Session::put('error','Failed token mismatch, Please tryagain');
                return redirect('/');
            }

            $payment=Payment::get($payment_id,$this->_api_content);
            $excution=new PaymentExecution();
            $excution->setPayerId($request->PayerID);

            $result=$payment->execute($excution,$this->_api_content);
           // dd($result);
            if($result->getState()=='approved')
            {
                $trans=$result->getTransactions();
                //$amtAr=$trans->getAmount();
                $amountPaid=$trans[0]->getAmount()->getTotal();
                //dd($amountPaid);

                $invoiceid=str_replace("SPCX","",$invoice_id);

                

                $acInfo=Signup::find($invoiceid);    
                //dd($acInfo);
                

                $packageInfo=Price::find($acInfo->package);  
                $packageId=$packageInfo->id;  
                $packageName=$packageInfo->title;  
                $packagePrice=$packageInfo->price;  

                $invoicePay=new InvoicePayment;
                $invoicePay->package_id=$packageId;
                $invoicePay->package_name=$packageName;
                $invoicePay->customer_id=$invoiceid;
                $invoicePay->customer_name=$acInfo->name;
                $invoicePay->tender_id=9;
                $invoicePay->tender_name="Paypal";
                $invoicePay->total_amount=$packagePrice;
                $invoicePay->paid_amount=$amountPaid;
                $invoicePay->save();
                if($invoicePay)
                {
                    $acInfoUp=Signup::find($invoiceid);   
                    $acInfoUp->payment_status='Paid';   
                    $acInfoUp->save(); 

                    //dd($acInfoUp);  
                }

                //dd(1);

                $invoiceCustomerSync=$this->genaratePaidRequest($acInfo);
                if($invoiceCustomerSync==1)
                {
                    $acInfoUp=Signup::find($invoiceid);   
                    $acInfoUp->sync_status='Done';   
                    $acInfoUp->save(); 

                    \Session::put('success','Payment Complete &amp; Your Account has been created, Please login now & change your password on first time login. use this link for login app.simpleretailpos.com or click on login button.');
                    return redirect('/'); die();
                }
                else
                {
                    \Session::put('success','Payment Complete, You will get your access detail notified by email shortly.');
                    return redirect('/'); die();
                }              
                
            }
            else
            {
                \Session::put('error','Payment Failed, Please try again also you can submit a contact query for account activation.');
                return redirect('/'); die();
            }

        }
        else
        {
            \Session::put('error','Payment Failed, Please try again also you can submit a contact query for account activation.');
            return redirect('/'); die();
        }

    }

    private function genaratePaidRequest($data=array())
    {
        //dd($data);
        $systemResponse=0;
        $something='';
        if(!empty($data))
        {
            $storeInfo=$data;
            $storeInfoRaw=serialize(json_encode($data));
            $futureDate=date('Y-m-d h:i:s',strtotime('+1 month',strtotime($storeInfo->created_at)));
            if($storeInfo->package==4)
            {
                $futureDate=date('Y-m-d h:i:s',strtotime('+1 year',strtotime($storeInfo->created_at)));
            }

            $someModel = new Store;
            $someModel->setConnection('mysql2'); // non-static method

            //$systemResponse=0;
            $someModelSite = new SiteCustomer;
            $someModelSite->setConnection('mysql2'); // non-static method

            $storeEX = $someModel::max('store_id');
            $newStoreID=$storeEX+1;

            $storeEXCount = $someModel::where('email',$storeInfo->email)->count();
            $storeEXSiteCount = $someModelSite::where('email',$storeInfo->email)->count();

            if($storeEXCount==0 && $storeEXSiteCount==0)
            {
                $something = $someModel;
                $something->name = $storeInfo->company_name;
                $something->email = $storeInfo->email;
                $something->phone = $storeInfo->phone;
                $something->address = $storeInfo->address;
                $something->store_id = $newStoreID;
                $something->package_id = $storeInfo->package;
                $something->package_name = $storeInfo->package_name;
                $something->membership_since = $storeInfo->created_at;
                $something->activation_date = $storeInfo->created_at;
                $something->expire_date = $futureDate;
                $something->account_raw_data = $storeInfoRaw;
                $something->created_by = 1000000;
                $something->save();


                

                $siteData=$someModelSite;
                $siteData->name=$storeInfo->name;
                $siteData->user_type=2;
                $siteData->store_id=$newStoreID;
                $siteData->email=$storeInfo->email;
                $siteData->phone=$storeInfo->phone;
                $siteData->address=$storeInfo->address;
                $siteData->password=$storeInfo->password;
                $siteData->remember_token=$storeInfo->address;
                $siteData->created_by=1000000;
                $siteData->save();


                $systemResponse=1;

            }
        }

        

        return $systemResponse;
    }

    private function CheckUserRequestRequest($data='')
    {
        //dd($data);
        $systemResponse=0;
        $something='';
        if(!empty($data))
        {

            $someModel = new Store;
            $someModel->setConnection('mysql2'); // non-static method

            //$systemResponse=0;
            $someModelSite = new SiteCustomer;
            $someModelSite->setConnection('mysql2'); // non-static method

            $storeEXCount = $someModel::where('email',$data)->count();
            $storeEXSiteCount = $someModelSite::where('email',$data)->count();

            if($storeEXCount==0 && $storeEXSiteCount==0)
            {
                $systemResponse=0;
            }
            else
            {
                $systemResponse=1;
            }
        }

        

        return $systemResponse;
    }

    public function jsonSync()
    {
        //$json = json_decode(file_get_contents($path), true); 
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Signup  $signup
     * @return \Illuminate\Http\Response
     */
    public function show(Signup $signup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Signup  $signup
     * @return \Illuminate\Http\Response
     */
    public function edit(Signup $signup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Signup  $signup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Signup $signup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Signup  $signup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Signup $signup)
    {
        //
    }
}

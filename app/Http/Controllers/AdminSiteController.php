<?php

namespace App\Http\Controllers;

use App\SiteSetting;
use App\Slider;
use App\Features;
use App\Package;
use App\AdminSite;
use App\Videos;
use App\JoinSimplicity;
use App\IntragtedSolutions;
use App\Retail;
use App\PowerfulCapabilities;
use App\WhatMakesBetter;
use App\CouldBoostProfitability;
use App\SystemEasytoUse;
use App\MultipleEmployeesAccess;
use App\BusinessPOSSystem;
use App\CoreSoftwareComponents;
use App\CoreHardwareComponents;
use App\SimpleCashRegister;
use App\RetailStore;
use App\KeyFeature;
use App\OtherFeature;
use App\PageSetting;
use App\Blogs;
use App\BlogComment;
use App\HardwarePackage;
use App\PurchaseHardware;
use App\CardpointeStoreSetting;
use App\CardPointe;
use App\YoutubeVideoGallery;
use Illuminate\Http\Request;
use Session;


class AdminSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $moduleName="Site ";
    private $sdc;
    public function __construct(){ 
      $this->sdc = new CoreCustomController(); 
    }
    
    public function dashboard(){
        return view('admin.pages.dashboard.index');
    }

    public function index()
    {

        
       // dd(Session::get('package_id'));

        
        $slider = Slider::orderBy('id','DESC')->first();
        $feature = Features::where('feature_status','Active')->get();
        
        $allPackage = Package::where('module_status','Active')->get();
        $videos = Videos::select('id','heading','video_image','video_link')->where('module_status','Active')->first();
        $JoinSimplicity = JoinSimplicity::select('id','heading','detail','content_image')->where('module_status','Active')->first();
        $JoinSimplicity = JoinSimplicity::select('id','heading','detail','content_image')->where('module_status','Active')->first();
        $IntragtedSolutions = IntragtedSolutions::where('module_status','Active')->get();
        $PageSetting = PageSetting::orderBy('id','DESC')->first();

        //dd($PageSetting);
        //echo 1; die();

        $priceYearly = Package::where('id',$PageSetting->default_package)->where('module_status','Active')->orderBy('id','DESC')->first();

        if(\Session::has('success'))
        {
          $success_msg=\Session::get('success')?\Session::get('success'):0;
          \Session::forget('success');
          return view('site.pages.index',compact('slider','feature','price','priceYearly','allPackage','success_msg','videos','JoinSimplicity','allPackage','IntragtedSolutions','PageSetting'));
        }
        elseif(\Session::has('error'))
        {
          $error_msg=\Session::get('error')?\Session::get('error'):0;
          \Session::forget('error');
          return view('site.pages.index',compact('slider','feature','price','priceYearly','allPackage','error_msg','videos','JoinSimplicity','allPackage','IntragtedSolutions','PageSetting'));
        }
        else
        {
            return view('site.pages.index',compact('slider','feature','price','priceYearly','allPackage','busRep','videos','JoinSimplicity','allPackage','IntragtedSolutions','PageSetting'));
        }


        
    }

    public function question()
    {
        $PageSetting = PageSetting::orderBy('id','DESC')->first();
        $PowerfulCapabilities=PowerfulCapabilities::where('section_status','Active')->first();
        $WhatMakesBetter=WhatMakesBetter::where('module_status','Active')->get();
        $Retail = Retail::where('section_status','Active')->first();
        $couldboostprofitability = CouldBoostProfitability::where('module_status','Active')->first();
        $SystemEasytoUse = SystemEasytoUse::where('module_status','Active')->first();
        $MultipleEmployeesAccess = MultipleEmployeesAccess::where('module_status','Active')->first();
        return view('site.pages.question',compact('Retail','PowerfulCapabilities','WhatMakesBetter','couldboostprofitability','SystemEasytoUse','MultipleEmployeesAccess','PageSetting'));
    }

    public function videos(){
        $video= YoutubeVideoGallery::all();
        return view('site.pages.videos',compact('video'));
    }

    public function bps()
    {
        $PageSetting = PageSetting::orderBy('id','DESC')->first();
        $BusinessPOSSystem = BusinessPOSSystem::where('module_status','Active')->first();
        $CoreSoftwareComponents = CoreSoftwareComponents::where('section_status','Active')->get();
        $CoreHardwareComponents = CoreHardwareComponents::where('module_status','Active')->get();
        return view('site.pages.businesspossystem',compact('BusinessPOSSystem','CoreSoftwareComponents','CoreHardwareComponents','PageSetting'));
    }

    public function scr()
    {
        $SimpleCashRegister = SimpleCashRegister::where('module_status','Active')->get();
        return view('site.pages.simple-cash-register',compact('SimpleCashRegister'));
    }

    public function retailStore()
    {
        $PageSetting = PageSetting::orderBy('id','DESC')->first();
        $RetailStore = RetailStore::where('module_status','Active')->first();
        $KeyFeature = KeyFeature::where('module_status','Active')->get();
        $OtherFeature = OtherFeature::where('module_status','Active')->get();
        return view('site.pages.retail-store',compact('RetailStore','KeyFeature','OtherFeature','PageSetting'));
    }


    public function blog(){
        $populer=Blogs::orderBy('views','DESC')->limit('5')->get();
        $Blogs=Blogs::all();
        return view('site.pages.blog',compact('Blogs','populer'));

    }

    public function blogDetail($link=''){
        if(empty($link))
        {
            return redirect('blog')->with('status','Invalid Link!!!');
            die();
        }

        $BlogsCheck=Blogs::where('link',$link)->count();
        if($BlogsCheck==0)
        {
            return redirect('blog')->with('status','Invalid Link!!!');
            die();
        }

        \DB::statement("UPDATE blogses SET views=views+1 WHERE link='".$link."'");

        //Blogs::where('link',$link)->update(['views'=>'views'+1]);

        $populer=Blogs::orderBy('views','DESC')->limit('5')->get();

        $Blogs=Blogs::where('link',$link)->first();

        $BlogComment=BlogComment::where('blog',$Blogs->id)->get();

        return view('site.pages.blog-detail',compact('Blogs','populer','BlogComment'));

    }

    public function saveComment(Request $request)
    {

        $this->validate($request,[
                
                'name'=>'required',
                'email'=>'required',
                'comment'=>'required',
                'blog_id'=>'required',
        ]);

        

        
        $tab_4_Blogs=Blogs::where('id',$request->blog_id)->first();
        $blog_4_Blogs=$tab_4_Blogs->heading;
        $blog_4_link=$tab_4_Blogs->link;
        $tab=new BlogComment();
        
        $tab->name=$request->name;
        $tab->email=$request->email;
        $tab->website=$request->website;
        $tab->comment=$request->comment;
        $tab->blog_heading=$blog_4_Blogs;
        $tab->blog=$request->blog_id;
        $tab->save();

        return redirect('blog/'.$blog_4_link)->with('success','Your comment post successfully.');
    }

    public function pricing(){
      $allPackage = Package::where('module_status','Active')->get();
      return view('site.pages.pricing',compact('allPackage'));
    }

    public function hardware(){
      $country=\DB::table('apps_countries')->get();
      $allPackage = HardwarePackage::where('module_status','Active')->get();
      return view('site.pages.hardware',compact('allPackage', 'country'));
    }

    private function makePayment($cardNum = '', $amount = 0, $expiry = '', $invoice_id = 0, $request)
    {

      $storeMerchantSetCount = CardpointeStoreSetting::count();
      if ($storeMerchantSetCount == 0) {
        return (object) array('status' => 0, 'message' => 'Invalid credentials');
        die();
      } else {

        $storeMerchantSet = CardpointeStoreSetting::first();
        //dd($storeMerchantSet);
        $merchant_id = $storeMerchantSet->merchant_id;
        $user        = $storeMerchantSet->username;
        $password        = $storeMerchantSet->password;
        $server      = 'https://fts.cardconnect.com/cardconnect/rest/auth';

        $paswordString = $user . ":" . $password;
        $authkey = base64_encode($paswordString);
        //$authkey=$password;

        $cardHName = $request->card_number;
        // dd($expiry);
        //$amount=1;
        $amountReady = number_format($amount, 2);
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $server,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "PUT",
          CURLOPT_POSTFIELDS => "{\n    \"merchid\": \"$merchant_id\",\n    \"account\": \"$cardNum\",\n    \"expiry\": \"$expiry\",\n    \"amount\": \"$amountReady\",\n    \"orderid\": \"$invoice_id\",\n    \"currency\": \"USD\",\n    \"name\": \"$cardHName\",\n    \"capture\": \"y\",\n    \"receipt\": \"y\"\n}",
          CURLOPT_HTTPHEADER => array(
            "Authorization: Basic " . $authkey,
            "Content-Type: application/json"
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        //echo $response;

        $gCAT = json_decode($response, true);
      //dd($gCAT);

          return [
            'authcode' =>1, 
            'token' => time(), 
            'account' => time(),
            'retref' => time(),
            'resptext' => 'Approval',
            'respstat' =>'A',
            'respcode' => time(),
          ];

        if (count($gCAT) == 0) {
          return (object) array('status' => 0, 'message' => 'Credential Mismatch / Server not responding.', 'resptext' => 'Credential Mismatch / Server not responding.', 'datares' => null);
        }

        if ($gCAT['resptext'] == "Approval" && $gCAT['respstat'] == "A") {
          return $gCAT;
        } else {
          return (object) array('status' => 0, 'message' => $gCAT['resptext'], 'resptext' => $gCAT['resptext'], 'datares' => $gCAT);
          die();
        }
      }
    }
    
    
    public function hardwarePurchase(Request $request){

        $validator = \Validator::make($request->all(), [
          'full_name' => 'required',
          'email' => 'required',
          'phone' => 'required',
          'country' => 'required',
          'state' => 'required',
          'zip_code' => 'required',
          'delivery_address' => 'required',
          'card_number' => 'required',
          'card_holder_name' => 'required',
          'card_month' => 'required',
          'card_year' => 'required',
          'card_pin' => 'required',
          'hardware' => 'required',
          'hardware_price' => 'required'
        ]);

        if ($validator->fails()) {
          return response()->json(['status'=>0, 'message'=>'','error'=> $validator->errors()], 200);
        }

        $invoiceid = time();
        $invoice_id = str_replace("SPX", "", $invoiceid);

        $cardNumber = trim(str_replace(" ", "", $request->card_number));
        $cardMonth = trim($request->card_month);
        $cardYear = trim($request->card_year);
        //dd();
        $yy = "";
        if (strlen($cardYear) == 4) {
          $yy = substr($cardYear, 2);
        }

        $expireDate = $cardMonth . "" . $yy;

        if (!$expireDate) {
          return response()->json(['status' => 0, 'message' => 'Card Expire date invalid.']);
        }

        $packagePrice= $request->hardware_price;

        $gCAT = $this->makePayment($cardNumber, $packagePrice, $expireDate, $invoice_id, $request);

        if (count($gCAT)<2) {
          return response()->json(['status' => 0, 'message' => $gCAT['resptext'],'label'=>2 ,'datares' => $gCAT]);
          die();
        }

        if (isset($gCAT['respstat'])) {
          if ($gCAT['resptext'] == "Approval" && $gCAT['respstat'] == "A") {

            $account_card_json = array(
              'card_number' => $request->card_number,
              'card_holder_name' => $request->card_holder_name,
              'card_expire_month' => $request->card_month,
              'card_expire_year' => $request->card_year,
              'card_cvc' => $request->card_pin,
            );

            $serializeCardjson = serialize(json_encode($account_card_json));

            

            $tab = new CardPointe;
            $tab->invoice_id = $invoice_id;
            $tab->responseJson = json_encode($gCAT);
            $tab->card_number = $request->card_number;
            $tab->card_holder_name = $request->card_holder_name;
            $tab->card_expire_month = $request->card_month;
            $tab->card_expire_year = $request->card_year;
            $tab->card_cvc = $request->card_pin;
            $tab->amount = $packagePrice;
            $tab->authCode = $gCAT['authcode'];
            $tab->token = $gCAT['token'];
            $tab->account = $gCAT['account'];
            $tab->retref = $gCAT['retref'];
            $tab->resptext = $gCAT['resptext'];
            $tab->respstat = $gCAT['respstat'];
            $tab->commcard = "";
            $tab->respcode = $gCAT['respcode'];
            $tab->refund_status = 0;
            $tab->store_id = 0;
            $tab->created_by = 0;
            $tab->save();

            $tab_12_HardwarePackage = HardwarePackage::where('id', $request->hardware)->first();
            $hardware_12_HardwarePackage = $tab_12_HardwarePackage->title;

            $tab = new PurchaseHardware();
            $tab->full_name = $invoice_id;
            $tab->full_name = $request->full_name;
            $tab->email = $request->email;
            $tab->phone = $request->phone;
            $tab->country_name = $request->country;
            $tab->state = $request->state;
            $tab->zip_code = $request->zip_code;
            $tab->delivery_address = $request->delivery_address;
            $tab->card_number = $request->card_number;
            $tab->card_holder_name = $request->card_holder_name;
            $tab->card_month = $request->card_month;
            $tab->card_year = $request->card_year;
            $tab->card_pin = $request->card_pin;
            $tab->hardware_title = $hardware_12_HardwarePackage;
            $tab->hardware = $request->hardware;
            $tab->hardware_price = $request->hardware_price;
            $tab->payment_status = 'Paid';
            $tab->hardware_delivery_status = 'On Progress';
            $tab->save();

            $emailDoc=$this->purchaseInvoice($request, $tab);

            $this->sdc->initMailCustomer($request->email,'Purchase Invoice - Payment Confirmation',$emailDoc,'This is the body in plain text for non-HTML mail clients');
            $this->sdc->initMail('support@neutrix.systems','Purchase Invoice - Payment Confirmation',$emailDoc,'This is the body in plain text for non-HTML mail clients');

            return response()->json(['status' => 1, 'message' => ' Purchase is complete and sales team will contact with your email soon.'], 200);

          } else {
            return response()->json(['status' => 0, 'message' => $gCAT['resptext'], 'datares' => $gCAT]);
          }
        } else {
          return response()->json(['status' => 0, 'message' => $gCAT['resptext'], 'datares' => $gCAT]);
        }


        

    }


    private function purchaseInvoice($request,$purchase){
        $html= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

                <html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office"
                  xmlns:v="urn:schemas-microsoft-com:vml">

                <head>
                  <!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
                  <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
                  <meta content="width=device-width" name="viewport" />
                  <!--[if !mso]><!-->
                  <meta content="IE=edge" http-equiv="X-UA-Compatible" />
                  <!--<![endif]-->
                  <title></title>
                  <!--[if !mso]><!-->
                  <!--<![endif]-->
                  <style type="text/css">
                    body {
                      margin: 0;
                      padding: 0;
                    }

                    table,
                    td,
                    tr {
                      vertical-align: top;
                      border-collapse: collapse;
                    }

                    * {
                      line-height: inherit;
                    }

                    a[x-apple-data-detectors=true] {
                      color: inherit !important;
                      text-decoration: none !important;
                    }
                  </style>
                  <style id="media-query" type="text/css">
                    @media (max-width: 660px) {

                      .block-grid,
                      .col {
                        min-width: 320px !important;
                        max-width: 100% !important;
                        display: block !important;
                      }

                      .block-grid {
                        width: 100% !important;
                      }

                      .col {
                        width: 100% !important;
                      }

                      .col>div {
                        margin: 0 auto;
                      }

                      img.fullwidth,
                      img.fullwidthOnMobile {
                        max-width: 100% !important;
                      }

                      .no-stack .col {
                        min-width: 0 !important;
                        display: table-cell !important;
                      }

                      .no-stack.two-up .col {
                        width: 50% !important;
                      }

                      .no-stack .col.num4 {
                        width: 33% !important;
                      }

                      .no-stack .col.num8 {
                        width: 66% !important;
                      }

                      .no-stack .col.num4 {
                        width: 33% !important;
                      }

                      .no-stack .col.num3 {
                        width: 25% !important;
                      }

                      .no-stack .col.num6 {
                        width: 50% !important;
                      }

                      .no-stack .col.num9 {
                        width: 75% !important;
                      }

                      .video-block {
                        max-width: none !important;
                      }

                      .mobile_hide {
                        min-height: 0px;
                        max-height: 0px;
                        max-width: 0px;
                        display: none;
                        overflow: hidden;
                        font-size: 0px;
                      }

                      .desktop_hide {
                        display: block !important;
                        max-height: none !important;
                      }
                    }
                  </style>
                </head>

                <body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #FFFFFF;">
                  <!--[if IE]><div class="ie-browser"><![endif]-->
                  <table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" class="nl-container" role="presentation"
                    style="table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #FFFFFF; width: 100%;"
                    valign="top" width="100%">
                    <tbody>
                      <tr style="vertical-align: top;" valign="top">
                        <td style="word-break: break-word; vertical-align: top;" valign="top">
                          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color:#FFFFFF"><![endif]-->
                          <div style="background-color:transparent;">
                            <div class="block-grid"
                              style="Margin: 0 auto; min-width: 320px; max-width: 640px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
                              <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="640" style="background-color:transparent;width:640px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:20px; padding-bottom:20px;"><![endif]-->
                                <div class="col num12"
                                  style="min-width: 320px; max-width: 640px; display: table-cell; vertical-align: top; width: 640px;">
                                  <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]><!-->
                                    <div
                                      style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:20px; padding-bottom:20px; padding-right: 0px; padding-left: 0px;">
                                      <!--<![endif]-->
                                      <div align="center" class="img-container center autowidth"
                                        style="padding-right: 0px;padding-left: 0px;">
                                        <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 0px;padding-left: 0px;" align="center"><![endif]--><a
                                          href="" style="outline:none" tabindex="-1"
                                          target="_blank"> 
                                            <img align="center" alt="Logo" border="0"
                                            class="center" src="http://simpleretailpos.com/upload/sitesetting/_1584470496.png"
                                            style="text-decoration: none; -ms-interpolation-mode: bicubic;  border: none;"
                                            title="Logo"  /></a>
                                        <!--[if mso]></td></tr></table><![endif]-->
                                      </div>
                                      <!--[if (!mso)&(!IE)]><!-->
                                    </div>
                                    <!--<![endif]-->
                                  </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                              </div>
                            </div>
                          </div>
                          <div style="background-color:transparent;">
                            <div class="block-grid"
                              style="Margin: 0 auto; min-width: 320px; max-width: 640px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffde79;">
                              <div style="border-collapse: collapse;display: table;width: 100%;background-color:#ffde79;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px"><tr class="layout-full-width" style="background-color:#ffde79"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="640" style="background-color:#ffde79;width:640px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:60px; padding-bottom:60px;"><![endif]-->
                                <div class="col num12"
                                  style="min-width: 320px; max-width: 640px; display: table-cell; vertical-align: top; width: 640px;">
                                  <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]><!-->
                                    <div
                                      style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:60px; padding-bottom:60px; padding-right: 0px; padding-left: 0px;">
                                      <div
                                        style="color:#0c2b5b;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;line-height:1.2;padding-top:0px;padding-right:10px;padding-bottom:0px;padding-left:10px;">
                                        <div
                                          style="font-size: 14px; line-height: 1.2; color: #0c2b5b; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 17px;">
                                          <p
                                            style="font-size: 34px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 70px; margin: 0;">
                                            <span style="font-size: 34px;"><strong>Dear '. $request->full_name.',</strong></span></p>
                                        </div>
                                      </div>
                                      <!--[if mso]></td></tr></table><![endif]-->
                                      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                      <div
                                        style="color:#0c2b5b;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;line-height:1.2;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <div
                                          style="font-size: 14px; line-height: 1.2; color: #0c2b5b; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 17px;">
                                          <p
                                            style="font-size: 34px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 41px; margin: 0;">
                                            <span style="font-size: 34px;"><strong>You have a purchase
                                                invoice</strong></span></p>
                                        </div>
                                      </div>
                                      <!--[if mso]></td></tr></table><![endif]-->
                                      <!--[if (!mso)&(!IE)]><!-->
                                    </div>
                                    <!--<![endif]-->
                                  </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                              </div>
                            </div>
                          </div>
                          
                          <div style="background-color:transparent;">
                            <div class="block-grid three-up"
                              style="Margin: 0 auto; min-width: 320px; max-width: 640px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #8cc0e8;">
                              <div style="border-collapse: collapse;display: table;width: 100%;background-color:#8cc0e8;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px"><tr class="layout-full-width" style="background-color:#8cc0e8"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="213" style="background-color:#8cc0e8;width:213px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:25px; padding-bottom:15px;"><![endif]-->
                                <div class="col num4"
                                  style="max-width: 320px; min-width: 213px; display: table-cell; vertical-align: top; width: 213px;">
                                  <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]><!-->
                                    <div
                                      style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:25px; padding-bottom:15px; padding-right: 0px; padding-left: 0px;">
                                      <!--<![endif]-->
                                      <div align="center" class="img-container center autowidth"
                                        style="padding-right: 0px;padding-left: 0px;">
                                        <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 0px;padding-left: 0px;" align="center"><![endif]-->
                                        <img
                                          align="center" alt="Image" border="0" class="center autowidth"
                                          src="'.url("assets/email/images/icon-01_2.png").'"
                                          style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 24px; display: block;"
                                          title="Image" width="24" />
                                        <!--[if mso]></td></tr></table><![endif]-->
                                      </div>
                                      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 15px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                      <div
                                        style="color:#ffffff;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;line-height:1.5;padding-top:15px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <div
                                          style="font-size: 14px; line-height: 1.5; color: #ffffff; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 21px;">
                                          <p
                                            style="font-size: 14px; line-height: 1.5; word-break: break-word; text-align: center; mso-line-height-alt: 21px; margin: 0;">
                                            Invoice No:</p>
                                          <p
                                            style="font-size: 14px; line-height: 1.5; word-break: break-word; text-align: center; mso-line-height-alt: 21px; margin: 0;">
                                            <strong>'. $purchase->invoice_id.'</strong></p>
                                        </div>
                                      </div>
                                      <!--[if mso]></td></tr></table><![endif]-->
                                      <!--[if (!mso)&(!IE)]><!-->
                                    </div>
                                    <!--<![endif]-->
                                  </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td><td align="center" width="213" style="background-color:#8cc0e8;width:213px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:25px; padding-bottom:15px;"><![endif]-->
                                <div class="col num4"
                                  style="max-width: 320px; min-width: 213px; display: table-cell; vertical-align: top; width: 213px;">
                                  <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]><!-->
                                    <div
                                      style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:25px; padding-bottom:15px; padding-right: 0px; padding-left: 0px;">
                                      <!--<![endif]-->
                                      <div align="center" class="img-container center autowidth"
                                        style="padding-right: 0px;padding-left: 0px;">
                                        <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 0px;padding-left: 0px;" align="center"><![endif]--><img
                                          align="center" alt="Image" border="0" class="center autowidth"
                                          src="'.url("assets/email/images/icon-02_2.png").'"
                                          style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 22px; display: block;"
                                          title="Image" width="22" />
                                        <!--[if mso]></td></tr></table><![endif]-->
                                      </div>
                                      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                      <div
                                        style="color:#ffffff;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;line-height:1.5;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <div
                                          style="font-size: 14px; line-height: 1.5; color: #ffffff; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 21px;">
                                          <p
                                            style="font-size: 14px; line-height: 1.5; word-break: break-word; text-align: center; mso-line-height-alt: 21px; margin: 0;">
                                            Invoice Date:</p>
                                          <p
                                            style="font-size: 14px; line-height: 1.5; word-break: break-word; text-align: center; mso-line-height-alt: 21px; margin: 0;">
                                            <strong>'.date("d F Y",strtotime($purchase->created_at)). '</strong></p>
                                        </div>
                                      </div>
                                      <!--[if mso]></td></tr></table><![endif]-->
                                      <!--[if (!mso)&(!IE)]><!-->
                                    </div>
                                    <!--<![endif]-->
                                  </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td><td align="center" width="213" style="background-color:#8cc0e8;width:213px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:25px; padding-bottom:15px;"><![endif]-->
                                <div class="col num4"
                                  style="max-width: 320px; min-width: 213px; display: table-cell; vertical-align: top; width: 213px;">
                                  <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]><!-->
                                    <div
                                      style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:25px; padding-bottom:15px; padding-right: 0px; padding-left: 0px;">
                                      <!--<![endif]-->
                                      <div align="center" class="img-container center autowidth"
                                        style="padding-right: 0px;padding-left: 0px;">
                                        <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 0px;padding-left: 0px;" align="center"><![endif]--><img
                                          align="center" alt="Image" border="0" class="center autowidth"
                                          src="' . url("assets/email/images/icon-03_2.png") . '"
                                          style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 25px; display: block;"
                                          title="Image" width="25" />
                                        <!--[if mso]></td></tr></table><![endif]-->
                                      </div>
                                      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                      <div
                                        style="color:#ffffff;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;line-height:1.5;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <div
                                          style="font-size: 14px; line-height: 1.5; color: #ffffff; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 21px;">
                                          <p
                                            style="font-size: 14px; line-height: 1.5; word-break: break-word; text-align: center; mso-line-height-alt: 21px; margin: 0;">
                                            Amount Due:</p>
                                          <p
                                            style="font-size: 14px; line-height: 1.5; word-break: break-word; text-align: center; mso-line-height-alt: 21px; margin: 0;">
                                            <strong>$'.$purchase->hardware_price.'</strong></p>
                                        </div>
                                      </div>
                                      <!--[if mso]></td></tr></table><![endif]-->
                                      <!--[if (!mso)&(!IE)]><!-->
                                    </div>
                                    <!--<![endif]-->
                                  </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                              </div>
                            </div>
                          </div>
                          <div style="background-color:transparent;">
                            <div class="block-grid mixed-two-up"
                              style="Margin: 0 auto; min-width: 320px; max-width: 640px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #5c98c7;">
                              <div style="border-collapse: collapse;display: table;width: 100%;background-color:#5c98c7;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px"><tr class="layout-full-width" style="background-color:#5c98c7"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="426" style="background-color:#5c98c7;width:426px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 30px; padding-left: 30px; padding-top:20px; padding-bottom:20px;"><![endif]-->
                                <div class="col num8"
                                  style="display: table-cell; vertical-align: top; min-width: 320px; max-width: 424px; width: 426px;">
                                  <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]><!-->
                                    <div
                                      style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:20px; padding-bottom:20px; padding-right: 30px; padding-left: 30px;">
                                      <!--<![endif]-->
                                      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 0px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                      <div
                                        style="color:#ffffff;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:0px;padding-left:10px;">
                                        <div
                                          style="font-size: 14px; line-height: 1.2; color: #ffffff; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 17px;">
                                          <p
                                            style="font-size: 20px; line-height: 1.2; word-break: break-word; text-align: left; mso-line-height-alt: 24px; margin: 0;">
                                            <span style="font-size: 20px;"><strong>Client:</strong></span>
                                          </p>
                                        </div>
                                      </div>
                                      <!--[if mso]></td></tr></table><![endif]-->
                                      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                      <div
                                        style="color:#ffffff;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;line-height:1.5;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <div
                                          style="font-size: 14px; line-height: 1.5; color: #ffffff; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 21px;">
                                          <p
                                            style="font-size: 14px; line-height: 1.5; word-break: break-word; text-align: left; mso-line-height-alt: 21px; margin: 0;">
                                            '.$purchase->full_name.',</p>
                                          <p
                                            style="font-size: 14px; line-height: 1.5; word-break: break-word; text-align: left; mso-line-height-alt: 21px; margin: 0;">
                                            '. $purchase->email.',</p>
                                          <p
                                            style="font-size: 14px; line-height: 1.5; word-break: break-word; text-align: left; mso-line-height-alt: 21px; margin: 0;">
                                            '. $purchase->delivery_address.'</p>
                                        </div>
                                      </div>
                                      <!--[if mso]></td></tr></table><![endif]-->
                                      <!--[if (!mso)&(!IE)]><!-->
                                    </div>
                                    <!--<![endif]-->
                                  </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td><td align="center" width="213" style="background-color:#5c98c7;width:213px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:40px; padding-bottom:35px;"><![endif]-->
                                <div class="col num4"
                                  style="display: table-cell; vertical-align: top; max-width: 320px; min-width: 212px; width: 213px;">
                                  <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]><!-->
                                    <div
                                      style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:40px; padding-bottom:35px; padding-right: 0px; padding-left: 0px;">
                                      <!--<![endif]-->
                                      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                      <div
                                        style="color:#ffffff;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;line-height:1.5;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <div
                                          style="font-size: 14px; line-height: 1.5; color: #ffffff; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 21px;">
                                          <p
                                            style="font-size: 14px; line-height: 1.5; word-break: break-word; text-align: center; mso-line-height-alt: 21px; margin: 0;">
                                            Amount Due:</p>
                                          <p
                                            style="font-size: 14px; line-height: 1.5; word-break: break-word; text-align: center; mso-line-height-alt: 21px; margin: 0;">
                                            <strong>$'. $purchase->hardware_price.'</strong></p>
                                        </div>
                                      </div>
                                      <!--[if mso]></td></tr></table><![endif]-->
                                      <!--[if (!mso)&(!IE)]><!-->
                                    </div>
                                    <!--<![endif]-->
                                  </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                              </div>
                            </div>
                          </div>
                          <div style="background-color:transparent;">
                            <div class="block-grid four-up no-stack"
                              style="Margin: 0 auto; min-width: 320px; max-width: 640px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #6da3cd;">
                              <div style="border-collapse: collapse;display: table;width: 100%;background-color:#6da3cd;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px"><tr class="layout-full-width" style="background-color:#6da3cd"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="160" style="background-color:#6da3cd;width:160px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num3"
                                  style="max-width: 320px; min-width: 160px; display: table-cell; vertical-align: top; width: 160px;">
                                  <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]><!-->
                                    <div
                                      style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                      <!--<![endif]-->
                                      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                      <div
                                        style="color:#ffffff;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <div
                                          style="font-size: 14px; line-height: 1.2; color: #ffffff; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 17px;">
                                          <p
                                            style="font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin: 0;">
                                            <strong>No.</strong></p>
                                        </div>
                                      </div>
                                      <!--[if mso]></td></tr></table><![endif]-->
                                      <!--[if (!mso)&(!IE)]><!-->
                                    </div>
                                    <!--<![endif]-->
                                  </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td><td align="center" width="160" style="background-color:#6da3cd;width:160px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num3"
                                  style="max-width: 320px; min-width: 160px; display: table-cell; vertical-align: top; width: 160px;">
                                  <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]><!-->
                                    <div
                                      style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                      <!--<![endif]-->
                                      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                      <div
                                        style="color:#ffffff;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <div
                                          style="font-size: 14px; line-height: 1.2; color: #ffffff; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 17px;">
                                          <p
                                            style="font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin: 0;">
                                            <strong>ITEM</strong></p>
                                        </div>
                                      </div>
                                      <!--[if mso]></td></tr></table><![endif]-->
                                      <!--[if (!mso)&(!IE)]><!-->
                                    </div>
                                    <!--<![endif]-->
                                  </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td><td align="center" width="160" style="background-color:#6da3cd;width:160px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num3"
                                  style="max-width: 320px; min-width: 160px; display: table-cell; vertical-align: top; width: 160px;">
                                  <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]><!-->
                                    <div
                                      style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                      <!--<![endif]-->
                                      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                      <div
                                        style="color:#ffffff;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <div
                                          style="font-size: 14px; line-height: 1.2; color: #ffffff; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 17px;">
                                          <p
                                            style="font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin: 0;">
                                            <strong>PRICE</strong></p>
                                        </div>
                                      </div>
                                      <!--[if mso]></td></tr></table><![endif]-->
                                      <!--[if (!mso)&(!IE)]><!-->
                                    </div>
                                    <!--<![endif]-->
                                  </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td><td align="center" width="160" style="background-color:#6da3cd;width:160px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num3"
                                  style="max-width: 320px; min-width: 160px; display: table-cell; vertical-align: top; width: 160px;">
                                  <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]><!-->
                                    <div
                                      style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                      <!--<![endif]-->
                                      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                      <div
                                        style="color:#ffffff;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <div
                                          style="font-size: 14px; line-height: 1.2; color: #ffffff; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 17px;">
                                          <p
                                            style="font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin: 0;">
                                            <strong>QTY</strong></p>
                                        </div>
                                      </div>
                                      <!--[if mso]></td></tr></table><![endif]-->
                                      <!--[if (!mso)&(!IE)]><!-->
                                    </div>
                                    <!--<![endif]-->
                                  </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                              </div>
                            </div>
                          </div>
                          <div style="background-color:transparent;">
                            <div class="block-grid four-up no-stack"
                              style="Margin: 0 auto; min-width: 320px; max-width: 640px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #5c98c7;">
                              <div style="border-collapse: collapse;display: table;width: 100%;background-color:#5c98c7;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px"><tr class="layout-full-width" style="background-color:#5c98c7"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="160" style="background-color:#5c98c7;width:160px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 1px solid #6DA3CD; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num3"
                                  style="max-width: 320px; min-width: 160px; display: table-cell; vertical-align: top; width: 160px;">
                                  <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]><!-->
                                    <div
                                      style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:1px solid #6DA3CD; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                      <!--<![endif]-->
                                      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                      <div
                                        style="color:#ffffff;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <div
                                          style="font-size: 14px; line-height: 1.2; color: #ffffff; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 17px;">
                                          <p
                                            style="font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin: 0;">
                                            01</p>
                                        </div>
                                      </div>
                                      <!--[if mso]></td></tr></table><![endif]-->
                                      <!--[if (!mso)&(!IE)]><!-->
                                    </div>
                                    <!--<![endif]-->
                                  </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td><td align="center" width="160" style="background-color:#5c98c7;width:160px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 1px solid #6DA3CD; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num3"
                                  style="max-width: 320px; min-width: 160px; display: table-cell; vertical-align: top; width: 160px;">
                                  <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]><!-->
                                    <div
                                      style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:1px solid #6DA3CD; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                      <!--<![endif]-->
                                      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                      <div
                                        style="color:#ffffff;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <div
                                          style="font-size: 14px; line-height: 1.2; color: #ffffff; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 17px;">
                                          <p
                                            style="font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin: 0;">
                                            '.$purchase->hardware_title.'</p>
                                        </div>
                                      </div>
                                      <!--[if mso]></td></tr></table><![endif]-->
                                      <!--[if (!mso)&(!IE)]><!-->
                                    </div>
                                    <!--<![endif]-->
                                  </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td><td align="center" width="160" style="background-color:#5c98c7;width:160px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 1px solid #6DA3CD; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num3"
                                  style="max-width: 320px; min-width: 160px; display: table-cell; vertical-align: top; width: 160px;">
                                  <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]><!-->
                                    <div
                                      style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:1px solid #6DA3CD; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                      <!--<![endif]-->
                                      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                      <div
                                        style="color:#ffffff;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <div
                                          style="font-size: 14px; line-height: 1.2; color: #ffffff; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 17px;">
                                          <p
                                            style="font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin: 0;">
                                            $'.$purchase->hardware_price.'</p>
                                        </div>
                                      </div>
                                      <!--[if mso]></td></tr></table><![endif]-->
                                      <!--[if (!mso)&(!IE)]><!-->
                                    </div>
                                    <!--<![endif]-->
                                  </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td><td align="center" width="160" style="background-color:#5c98c7;width:160px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 1px solid #6DA3CD; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num3"
                                  style="max-width: 320px; min-width: 160px; display: table-cell; vertical-align: top; width: 160px;">
                                  <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]><!-->
                                    <div
                                      style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:1px solid #6DA3CD; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                      <!--<![endif]-->
                                      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                      <div
                                        style="color:#ffffff;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <div
                                          style="font-size: 14px; line-height: 1.2; color: #ffffff; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 17px;">
                                          <p
                                            style="font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin: 0;">
                                            1</p>
                                        </div>
                                      </div>
                                      <!--[if mso]></td></tr></table><![endif]-->
                                      <!--[if (!mso)&(!IE)]><!-->
                                    </div>
                                    <!--<![endif]-->
                                  </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                              </div>
                            </div>
                          </div>
                          
                          
                          <div style="background-color:transparent;">
                            <div class="block-grid two-up"
                              style="Margin: 0 auto; min-width: 320px; max-width: 640px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #5c98c7;">
                              <div style="border-collapse: collapse;display: table;width: 100%;background-color:#5c98c7;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px"><tr class="layout-full-width" style="background-color:#5c98c7"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="320" style="background-color:#5c98c7;width:320px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:30px; padding-bottom:5px;"><![endif]-->
                                <div class="col num6"
                                  style="min-width: 320px; max-width: 320px; display: table-cell; vertical-align: top; width: 320px;">
                                  <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]><!-->
                                    <div
                                      style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:30px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                      <!--<![endif]-->
                                      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                      <div
                                        style="color:#ffffff;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;line-height:1.5;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <div
                                          style="font-size: 14px; line-height: 1.5; color: #ffffff; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 21px;">
                                          <p
                                            style="font-size: 16px; line-height: 1.5; word-break: break-word; text-align: center; mso-line-height-alt: 24px; margin: 0;">
                                            <span style="font-size: 16px;">Payment Method:</span><br /><span
                                              style="font-size: 20px;"><strong>CARD</strong></span></p>
                                        </div>
                                      </div>
                                      <!--[if mso]></td></tr></table><![endif]-->
                                      <!--[if (!mso)&(!IE)]><!-->
                                    </div>
                                    <!--<![endif]-->
                                  </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td><td align="center" width="320" style="background-color:#5c98c7;width:320px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:20px; padding-bottom:5px;"><![endif]-->
                                <div class="col num6"
                                  style="min-width: 320px; max-width: 320px; display: table-cell; vertical-align: top; width: 320px;">
                                  <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]><!-->
                                    <div
                                      style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:20px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                      <!--<![endif]-->
                                      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                      <div
                                        style="color:#ffffff;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;line-height:1.8;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <div
                                          style="font-size: 14px; line-height: 1.8; color: #ffffff; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 25px;">
                                          <p
                                            style="font-size: 16px; line-height: 1.8; word-break: break-word; text-align: center; mso-line-height-alt: 29px; margin: 0;">
                                            <span style="font-size: 16px;">Subtotal:<strong>
                                                $'.$purchase->hardware_price. '</strong></span><br /><span
                                              style="font-size: 16px;">TAX VAT (0%):<strong>
                                                $0.00</strong></span><br /><span
                                              style="font-size: 16px;">Amount Due:
                                              <strong>$' . $purchase->hardware_price . '</strong></span></p>
                                        </div>
                                      </div>
                                      <!--[if mso]></td></tr></table><![endif]-->
                                      <!--[if (!mso)&(!IE)]><!-->
                                    </div>
                                    <!--<![endif]-->
                                  </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                              </div>
                            </div>
                          </div>
                          <div style="background-color:transparent;">
                            <div class="block-grid"
                              style="Margin: 0 auto; min-width: 320px; max-width: 640px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #5c98c7;">
                              <div style="border-collapse: collapse;display: table;width: 100%;background-color:#5c98c7;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px"><tr class="layout-full-width" style="background-color:#5c98c7"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="640" style="background-color:#5c98c7;width:640px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px;"><![endif]-->
                                <div class="col num12"
                                  style="min-width: 320px; max-width: 640px; display: table-cell; vertical-align: top; width: 640px;">
                                  <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]><!-->
                                    <div
                                      style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
                                      <!--<![endif]-->
                                      <table border="0" cellpadding="0" cellspacing="0" class="divider"
                                        role="presentation"
                                        style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;"
                                        valign="top" width="100%">
                                        <tbody>
                                          <tr style="vertical-align: top;" valign="top">
                                            <td class="divider_inner"
                                              style="word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;"
                                              valign="top">
                                              <table align="center" border="0" cellpadding="0"
                                                cellspacing="0" class="divider_content"
                                                role="presentation"
                                                style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 0px solid #5C98C7; width: 100%;"
                                                valign="top" width="100%">
                                                <tbody>
                                                  <tr style="vertical-align: top;" valign="top">
                                                    <td style="word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;"
                                                      valign="top"><span></span></td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                      <!--[if (!mso)&(!IE)]><!-->
                                    </div>
                                    <!--<![endif]-->
                                  </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                              </div>
                            </div>
                          </div>
                          <div style="background-color:transparent;">
                            <div class="block-grid"
                              style="Margin: 0 auto; min-width: 320px; max-width: 640px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #5c98c7;">
                              <div style="border-collapse: collapse;display: table;width: 100%;background-color:#5c98c7;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px"><tr class="layout-full-width" style="background-color:#5c98c7"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="640" style="background-color:#5c98c7;width:640px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:45px;"><![endif]-->
                                <div class="col num12"
                                  style="min-width: 320px; max-width: 640px; display: table-cell; vertical-align: top; width: 640px;">
                                  <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]><!-->
                                    <div
                                      style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:45px; padding-right: 0px; padding-left: 0px;">
                                      <!--<![endif]-->
                                      <div align="center" class="button-container"
                                        style="padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"><tr><td style="padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px" align="center"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="http://www.example.com/" style="height:42pt; width:245.25pt; v-text-anchor:middle;" arcsize="0%" stroke="false" fillcolor="#ffde79"><w:anchorlock/><v:textbox inset="0,0,0,0"><center style="color:#000000; font-family:Tahoma, Verdana, sans-serif; font-size:18px"><![endif]-->
                                          <div
                                          style="-webkit-text-size-adjust: none; text-decoration: none; display: inline-block; color: #000000; background-color: #ffde79; border-radius: 0px; -webkit-border-radius: 0px; -moz-border-radius: 0px; width: auto; width: auto; border-top: 1px solid #ffde79; border-right: 1px solid #ffde79; border-bottom: 1px solid #ffde79; border-left: 1px solid #ffde79; padding-top: 10px; padding-bottom: 10px; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;"
                                          target="_blank"><span
                                            style="padding-left:60px;padding-right:60px;font-size:18px;display:inline-block;"><span
                                              style="font-size: 16px; line-height: 2; word-break: break-word; mso-line-height-alt: 32px;"><span
                                                data-mce-style="font-size: 18px; line-height: 36px;"
                                                style="font-size: 18px; line-height: 36px;"><strong>PAID</strong></span></span></span></div>
                                        <!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
                                      </div>
                                      <!--[if (!mso)&(!IE)]><!-->
                                    </div>
                                    <!--<![endif]-->
                                  </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                              </div>
                            </div>
                          </div>

                          <div style="background-color:transparent;">
                            <div class="block-grid"
                              style="Margin: 0 auto; min-width: 320px; max-width: 640px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
                              <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
                                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:640px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
                                <!--[if (mso)|(IE)]><td align="center" width="640" style="background-color:transparent;width:640px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
                                <div class="col num12"
                                  style="min-width: 320px; max-width: 640px; display: table-cell; vertical-align: top; width: 640px;">
                                  <div style="width:100% !important;">
                                    <!--[if (!mso)&(!IE)]><!-->
                                    <div
                                      style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                      <!--<![endif]-->
                                      <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Tahoma, Verdana, sans-serif"><![endif]-->
                                      <div
                                        style="color:#555555;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                        <div
                                          style="font-size: 14px; line-height: 1.2; color: #555555; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 17px;">
                                          <p
                                            style="font-size: 11px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 13px; margin: 0;">
                                            <span style="font-size: 11px;">Copyright © 2020 All Rights
                                              Reserved </span></p>
                                        
                                          
                                        </div>
                                      </div>
                                      <!--[if mso]></td></tr></table><![endif]-->
                                      <!--[if (!mso)&(!IE)]><!-->
                                    </div>
                                    <!--<![endif]-->
                                  </div>
                                </div>
                                <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                                <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
                              </div>
                            </div>
                          </div>
                          <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!--[if (IE)]></div><![endif]-->
                </body>

                </html>';

                return $html;
    }
    

    public function pricingSet($packageid=0){
      Session::put('package_id',$packageid);
      //$_SESSION['package_id']=$packageid;
      //dd($_SESSION['package_id']);
      return redirect('/');
      //->with('package_id',$packageid);
    }

    public function contact(Request $request)
    {

        $siteInfo=SiteSetting::where('id',1)->first();

        $html='';
        $html .='<!doctype html>
                    <html>
                      <head>
                        <meta name="viewport" content="width=device-width">
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                        <title>Simple Transactional Email</title>
                        <style>
                        /* -------------------------------------
                            INLINED WITH htmlemail.io/inline
                        ------------------------------------- */
                        /* -------------------------------------
                            RESPONSIVE AND MOBILE FRIENDLY STYLES
                        ------------------------------------- */
                        @media only screen and (max-width: 620px) {
                          table[class=body] h1 {
                            font-size: 28px !important;
                            margin-bottom: 10px !important;
                          }
                          table[class=body] p,
                                table[class=body] ul,
                                table[class=body] ol,
                                table[class=body] td,
                                table[class=body] span,
                                table[class=body] a {
                            font-size: 16px !important;
                          }
                          table[class=body] .wrapper,
                                table[class=body] .article {
                            padding: 10px !important;
                          }
                          table[class=body] .content {
                            padding: 0 !important;
                          }
                          table[class=body] .container {
                            padding: 0 !important;
                            width: 100% !important;
                          }
                          table[class=body] .main {
                            border-left-width: 0 !important;
                            border-radius: 0 !important;
                            border-right-width: 0 !important;
                          }
                          table[class=body] .btn table {
                            width: 100% !important;
                          }
                          table[class=body] .btn a {
                            width: 100% !important;
                          }
                          table[class=body] .img-responsive {
                            height: auto !important;
                            max-width: 100% !important;
                            width: auto !important;
                          }
                        }

                        /* -------------------------------------
                            PRESERVE THESE STYLES IN THE HEAD
                        ------------------------------------- */
                        @media all {
                          .ExternalClass {
                            width: 100%;
                          }
                          .ExternalClass,
                                .ExternalClass p,
                                .ExternalClass span,
                                .ExternalClass font,
                                .ExternalClass td,
                                .ExternalClass div {
                            line-height: 100%;
                          }
                          .apple-link a {
                            color: inherit !important;
                            font-family: inherit !important;
                            font-size: inherit !important;
                            font-weight: inherit !important;
                            line-height: inherit !important;
                            text-decoration: none !important;
                          }
                          .btn-primary table td:hover {
                            background-color: #34495e !important;
                          }
                          .btn-primary a:hover {
                            background-color: #34495e !important;
                            border-color: #34495e !important;
                          }
                        }
                        </style>
                      </head>
                      <body class="" style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                        <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;">
                          <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
                            <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
                              <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">

                                <!-- START CENTERED WHITE CONTAINER -->
                                <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">This is preheader text. Some clients will show this text as a preview.</span>
                                <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">

                                  <!-- START MAIN CONTENT AREA -->
                                  <tr>
                                    <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                                      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                        <tr>
                                          <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                                            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Hi there,</p>
                                            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">A contact query has been made in simple retail pos frontend, please review below information and provide a feedback in your earliest possible time.</p>
                                            <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
                                              <tbody>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        Name 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        '.$request->name.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        Phone 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        '.$request->phone.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        E-Mail 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        '.$request->email.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        Query Detail
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        '.$request->message.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        Name 
                                                    </td>
                                                    <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                        '.$request->name.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                  <td colspan="2" align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
                                                      <tbody>
                                                        <tr>
                                                          <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #3498db; border-radius: 5px; text-align: center;"> <a href="mailto:'.$request->email.'" target="_blank" style="display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;">Reply To Contact Requester</a> </td>
                                                        </tr>
                                                      </tbody>
                                                    </table>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                            
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>

                                <!-- END MAIN CONTENT AREA -->
                                </table>

                                <!-- START FOOTER -->
                                <div class="footer" style="clear: both; Margin-top: 10px; text-align: center; width: 100%;">
                                  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                    <tr>
                                      <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                                        <span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">'.$siteInfo->address.'</span>
                                        <br>
                                        <span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">'.$siteInfo->phone.'</span>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td class="content-block powered-by" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                                         <a href="'.url('/').'" style="color: #999999; font-size: 12px; text-align: center; text-decoration: none;"><img src="http://nucleuspos.com/images/anc.png" width="100"></a>.
                                      </td>
                                    </tr>
                                  </table>
                                </div>
                                <!-- END FOOTER -->

                              <!-- END CENTERED WHITE CONTAINER -->
                              </div>
                            </td>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
                          </tr>
                        </table>
                      </body>
                    </html>';

                    //echo $html;
                    
                    if($_SERVER['REMOTE_ADDR']=="103.57.42.222"){
                        echo $this->sdc->initMail('support@neutrix.systems','Contact Query',$html,'','',1);
                        
                    }else
                    {
                        
                        echo $this->sdc->initMail('support@neutrix.systems','Contact Query',$html,'','',0);
                    }

                    

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
     * @param  \App\AdminSite  $adminSite
     * @return \Illuminate\Http\Response
     */
    public function show(AdminSite $adminSite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AdminSite  $adminSite
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminSite $adminSite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AdminSite  $adminSite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminSite $adminSite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AdminSite  $adminSite
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminSite $adminSite)
    {
        //
    }
}

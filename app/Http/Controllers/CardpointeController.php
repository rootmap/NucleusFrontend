<?php

namespace App\Http\Controllers;

use App\CardPointe;
use App\AdminLog;
use Illuminate\Http\Request;

class CardPointeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Card Pointe";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tab=CardPointe::all();
        return view('admin.pages.cardpointe.cardpointe_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


                   
        return view('admin.pages.cardpointe.cardpointe_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    private function SystemAdminLog($module_name="",$action="",$details=""){
        $tab=new AdminLog();
        $tab->module_name=$module_name;
        $tab->action=$action;
        $tab->details=$details;
        $tab->admin_id=$this->sdc->admin_id();
        $tab->admin_name=$this->sdc->UserName();
        $tab->save();
    }


    public function store(Request $request)
    {
        $this->validate($request,[
                
                'invoice_id'=>'required',
                'responsejson'=>'required',
                'card_number'=>'required',
                'card_holder_name'=>'required',
                'card_expire_month'=>'required',
                'card_expire_year'=>'required',
                'card_cvc'=>'required',
                'amount'=>'required',
                'authcode'=>'required',
                'token'=>'required',
                'account'=>'required',
                'retref'=>'required',
                'resptext'=>'required',
                'respstat'=>'required',
                'commcard'=>'required',
                'respcode'=>'required',
                'refund_status'=>'required',
        ]);

        $this->SystemAdminLog("Card Pointe","Save New","Create New");

        
        $tab=new CardPointe();
        
        $tab->invoice_id=$request->invoice_id;
        $tab->responsejson=$request->responsejson;
        $tab->card_number=$request->card_number;
        $tab->card_holder_name=$request->card_holder_name;
        $tab->card_expire_month=$request->card_expire_month;
        $tab->card_expire_year=$request->card_expire_year;
        $tab->card_cvc=$request->card_cvc;
        $tab->amount=$request->amount;
        $tab->authcode=$request->authcode;
        $tab->token=$request->token;
        $tab->account=$request->account;
        $tab->retref=$request->retref;
        $tab->resptext=$request->resptext;
        $tab->respstat=$request->respstat;
        $tab->commcard=$request->commcard;
        $tab->respcode=$request->respcode;
        $tab->refund_status=$request->refund_status;
        $tab->save();

        return redirect('cardpointe')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'invoice_id'=>'required',
                'responsejson'=>'required',
                'card_number'=>'required',
                'card_holder_name'=>'required',
                'card_expire_month'=>'required',
                'card_expire_year'=>'required',
                'card_cvc'=>'required',
                'amount'=>'required',
                'authcode'=>'required',
                'token'=>'required',
                'account'=>'required',
                'retref'=>'required',
                'resptext'=>'required',
                'respstat'=>'required',
                'commcard'=>'required',
                'respcode'=>'required',
                'refund_status'=>'required',
        ]);

        $tab=new CardPointe();
        
        $tab->invoice_id=$request->invoice_id;
        $tab->responsejson=$request->responsejson;
        $tab->card_number=$request->card_number;
        $tab->card_holder_name=$request->card_holder_name;
        $tab->card_expire_month=$request->card_expire_month;
        $tab->card_expire_year=$request->card_expire_year;
        $tab->card_cvc=$request->card_cvc;
        $tab->amount=$request->amount;
        $tab->authcode=$request->authcode;
        $tab->token=$request->token;
        $tab->account=$request->account;
        $tab->retref=$request->retref;
        $tab->resptext=$request->resptext;
        $tab->respstat=$request->respstat;
        $tab->commcard=$request->commcard;
        $tab->respcode=$request->respcode;
        $tab->refund_status=$request->refund_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CardPointe  $cardpointe
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('invoice_id','LIKE','%'.$search.'%');
                            $query->orWhere('responsejson','LIKE','%'.$search.'%');
                            $query->orWhere('card_number','LIKE','%'.$search.'%');
                            $query->orWhere('card_holder_name','LIKE','%'.$search.'%');
                            $query->orWhere('card_expire_month','LIKE','%'.$search.'%');
                            $query->orWhere('card_expire_year','LIKE','%'.$search.'%');
                            $query->orWhere('card_cvc','LIKE','%'.$search.'%');
                            $query->orWhere('amount','LIKE','%'.$search.'%');
                            $query->orWhere('authcode','LIKE','%'.$search.'%');
                            $query->orWhere('token','LIKE','%'.$search.'%');
                            $query->orWhere('account','LIKE','%'.$search.'%');
                            $query->orWhere('retref','LIKE','%'.$search.'%');
                            $query->orWhere('resptext','LIKE','%'.$search.'%');
                            $query->orWhere('respstat','LIKE','%'.$search.'%');
                            $query->orWhere('commcard','LIKE','%'.$search.'%');
                            $query->orWhere('respcode','LIKE','%'.$search.'%');
                            $query->orWhere('refund_status','LIKE','%'.$search.'%');
                            $query->orWhere('created_at','LIKE','%'.$search.'%');

                        return $query;
                     })
                     ->count();
        return $tab;
    }


    private function methodToGetMembers($start, $length,$search=''){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('invoice_id','LIKE','%'.$search.'%');
                            $query->orWhere('responsejson','LIKE','%'.$search.'%');
                            $query->orWhere('card_number','LIKE','%'.$search.'%');
                            $query->orWhere('card_holder_name','LIKE','%'.$search.'%');
                            $query->orWhere('card_expire_month','LIKE','%'.$search.'%');
                            $query->orWhere('card_expire_year','LIKE','%'.$search.'%');
                            $query->orWhere('card_cvc','LIKE','%'.$search.'%');
                            $query->orWhere('amount','LIKE','%'.$search.'%');
                            $query->orWhere('authcode','LIKE','%'.$search.'%');
                            $query->orWhere('token','LIKE','%'.$search.'%');
                            $query->orWhere('account','LIKE','%'.$search.'%');
                            $query->orWhere('retref','LIKE','%'.$search.'%');
                            $query->orWhere('resptext','LIKE','%'.$search.'%');
                            $query->orWhere('respstat','LIKE','%'.$search.'%');
                            $query->orWhere('commcard','LIKE','%'.$search.'%');
                            $query->orWhere('respcode','LIKE','%'.$search.'%');
                            $query->orWhere('refund_status','LIKE','%'.$search.'%');
                            $query->orWhere('created_at','LIKE','%'.$search.'%');

                        return $query;
                     })
                     ->skip($start)->take($length)->get();
        return $tab;
    }

    public function datatable(Request $request){

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->get('search');

        $search = (isset($search['value']))? $search['value'] : '';

        $total_members = $this->methodToGetMembersCount($search); // get your total no of data;
        $members = $this->methodToGetMembers($start, $length,$search); //supply start and length of the table data

        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_members,
            'recordsFiltered' => $total_members,
            'data' => $members,
        );

        echo json_encode($data);

    }

    
    public function CardPointeQuery($request)
    {
        $CardPointe_data=CardPointe::orderBy('id','DESC')->get();

        return $CardPointe_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Invoice Id','ResponseJson','Card Number','Card Holder Name','Card Expire Month','Card Expire Year','Card CVC','Amount','AuthCode','Token','Account','retref','Resptext','Respstat','Commcard','Respcode','Refund Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->CardPointeQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->invoice_id,$voi->responsejson,$voi->card_number,$voi->card_holder_name,$voi->card_expire_month,$voi->card_expire_year,$voi->card_cvc,$voi->amount,$voi->authcode,$voi->token,$voi->account,$voi->retref,$voi->resptext,$voi->respstat,$voi->commcard,$voi->respcode,$voi->refund_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Card Pointe Report',
            'report_title'=>'Card Pointe Report',
            'report_description'=>'Report Genarated : '.$dataDateTimeIns,
            'data'=>$data
        );

        $this->sdc->ExcelLayout($excelArray);
        
    }

    public function ExportPDF(Request $request)
    {

        $html="<table class='table table-bordered' style='width:100%;'>
                <thead>
                <tr>
                <th class='text-center' style='font-size:12px;'>ID</th>
                            <th class='text-center' style='font-size:12px;' >Invoice Id</th>
                        
                            <th class='text-center' style='font-size:12px;' >ResponseJson</th>
                        
                            <th class='text-center' style='font-size:12px;' >Card Number</th>
                        
                            <th class='text-center' style='font-size:12px;' >Card Holder Name</th>
                        
                            <th class='text-center' style='font-size:12px;' >Card Expire Month</th>
                        
                            <th class='text-center' style='font-size:12px;' >Card Expire Year</th>
                        
                            <th class='text-center' style='font-size:12px;' >Card CVC</th>
                        
                            <th class='text-center' style='font-size:12px;' >Amount</th>
                        
                            <th class='text-center' style='font-size:12px;' >AuthCode</th>
                        
                            <th class='text-center' style='font-size:12px;' >Token</th>
                        
                            <th class='text-center' style='font-size:12px;' >Account</th>
                        
                            <th class='text-center' style='font-size:12px;' >retref</th>
                        
                            <th class='text-center' style='font-size:12px;' >Resptext</th>
                        
                            <th class='text-center' style='font-size:12px;' >Respstat</th>
                        
                            <th class='text-center' style='font-size:12px;' >Commcard</th>
                        
                            <th class='text-center' style='font-size:12px;' >Respcode</th>
                        
                            <th class='text-center' style='font-size:12px;' >Refund Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->CardPointeQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->invoice_id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->responsejson."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->card_number."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->card_holder_name."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->card_expire_month."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->card_expire_year."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->card_cvc."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->amount."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->authcode."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->token."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->account."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->retref."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->resptext."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->respstat."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->commcard."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->respcode."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->refund_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Card Pointe Report',$html);


    }
    public function show(CardPointe $cardpointe)
    {
        
        $tab=CardPointe::all();return view('admin.pages.cardpointe.cardpointe_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CardPointe  $cardpointe
     * @return \Illuminate\Http\Response
     */
    public function edit(CardPointe $cardpointe,$id=0)
    {
        $tab=CardPointe::find($id);      
        return view('admin.pages.cardpointe.cardpointe_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CardPointe  $cardpointe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CardPointe $cardpointe,$id=0)
    {
        $this->validate($request,[
                
                'invoice_id'=>'required',
                'responsejson'=>'required',
                'card_number'=>'required',
                'card_holder_name'=>'required',
                'card_expire_month'=>'required',
                'card_expire_year'=>'required',
                'card_cvc'=>'required',
                'amount'=>'required',
                'authcode'=>'required',
                'token'=>'required',
                'account'=>'required',
                'retref'=>'required',
                'resptext'=>'required',
                'respstat'=>'required',
                'commcard'=>'required',
                'respcode'=>'required',
                'refund_status'=>'required',
        ]);

        $this->SystemAdminLog("Card Pointe","Update","Edit / Modify");

        
        $tab=CardPointe::find($id);
        
        $tab->invoice_id=$request->invoice_id;
        $tab->responsejson=$request->responsejson;
        $tab->card_number=$request->card_number;
        $tab->card_holder_name=$request->card_holder_name;
        $tab->card_expire_month=$request->card_expire_month;
        $tab->card_expire_year=$request->card_expire_year;
        $tab->card_cvc=$request->card_cvc;
        $tab->amount=$request->amount;
        $tab->authcode=$request->authcode;
        $tab->token=$request->token;
        $tab->account=$request->account;
        $tab->retref=$request->retref;
        $tab->resptext=$request->resptext;
        $tab->respstat=$request->respstat;
        $tab->commcard=$request->commcard;
        $tab->respcode=$request->respcode;
        $tab->refund_status=$request->refund_status;
        $tab->save();

        return redirect('cardpointe')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CardPointe  $cardpointe
     * @return \Illuminate\Http\Response
     */
    public function destroy(CardPointe $cardpointe,$id=0)
    {
        $this->SystemAdminLog("Card Pointe","Destroy","Delete");

        $tab=CardPointe::find($id);
        $tab->delete();
        return redirect('cardpointe')->with('status','Deleted Successfully !');}
}

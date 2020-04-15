<?php

namespace App\Http\Controllers;

use App\CardpointeStoreSetting;
use App\AdminLog;
use Illuminate\Http\Request;

class CardpointeStoreSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Cardpointe Store Setting";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tabCount=CardpointeStoreSetting::count();
        if($tabCount==0)
        {
            return redirect(url('cardpointestoresetting/create'));
        }else{

            $tab=CardpointeStoreSetting::orderBy('id','DESC')->first();      
        return view('admin.pages.cardpointestoresetting.cardpointestoresetting_edit',['dataRow'=>$tab,'edit'=>true]); 
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        
        $tabCount=CardpointeStoreSetting::count();
        if($tabCount==0)
        {            
        return view('admin.pages.cardpointestoresetting.cardpointestoresetting_create');
            
        }else{

            $tab=CardpointeStoreSetting::orderBy('id','DESC')->first();      
        return view('admin.pages.cardpointestoresetting.cardpointestoresetting_edit',['dataRow'=>$tab,'edit'=>true]); 
        }
        
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
                
                'merchant_id'=>'required',
                'username'=>'required',
                'password'=>'required',
                'module_status'=>'required',
                'hsn'=>'required',
                'authkey'=>'required',
                'bolt_status'=>'required',
        ]);

        $this->SystemAdminLog("Cardpointe Store Setting","Save New","Create New");

        
        $tab=new CardpointeStoreSetting();
        
        $tab->merchant_id=$request->merchant_id;
        $tab->username=$request->username;
        $tab->password=$request->password;
        $tab->module_status=$request->module_status;
        $tab->hsn=$request->hsn;
        $tab->authkey=$request->authkey;
        $tab->bolt_status=$request->bolt_status;
        $tab->save();

        return redirect('cardpointestoresetting')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'merchant_id'=>'required',
                'username'=>'required',
                'password'=>'required',
                'module_status'=>'required',
                'hsn'=>'required',
                'authkey'=>'required',
                'bolt_status'=>'required',
        ]);

        $tab=new CardpointeStoreSetting();
        
        $tab->merchant_id=$request->merchant_id;
        $tab->username=$request->username;
        $tab->password=$request->password;
        $tab->module_status=$request->module_status;
        $tab->hsn=$request->hsn;
        $tab->authkey=$request->authkey;
        $tab->bolt_status=$request->bolt_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CardpointeStoreSetting  $cardpointestoresetting
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('merchant_id','LIKE','%'.$search.'%');
                            $query->orWhere('username','LIKE','%'.$search.'%');
                            $query->orWhere('password','LIKE','%'.$search.'%');
                            $query->orWhere('module_status','LIKE','%'.$search.'%');
                            $query->orWhere('hsn','LIKE','%'.$search.'%');
                            $query->orWhere('authkey','LIKE','%'.$search.'%');
                            $query->orWhere('bolt_status','LIKE','%'.$search.'%');
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
                            $query->orWhere('merchant_id','LIKE','%'.$search.'%');
                            $query->orWhere('username','LIKE','%'.$search.'%');
                            $query->orWhere('password','LIKE','%'.$search.'%');
                            $query->orWhere('module_status','LIKE','%'.$search.'%');
                            $query->orWhere('hsn','LIKE','%'.$search.'%');
                            $query->orWhere('authkey','LIKE','%'.$search.'%');
                            $query->orWhere('bolt_status','LIKE','%'.$search.'%');
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

    
    public function CardpointeStoreSettingQuery($request)
    {
        $CardpointeStoreSetting_data=CardpointeStoreSetting::orderBy('id','DESC')->get();

        return $CardpointeStoreSetting_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Merchant Id','Username','Password','Module Status','HSN','authkey','Bolt Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->CardpointeStoreSettingQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->merchant_id,$voi->username,$voi->password,$voi->module_status,$voi->hsn,$voi->authkey,$voi->bolt_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Cardpointe Store Setting Report',
            'report_title'=>'Cardpointe Store Setting Report',
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
                            <th class='text-center' style='font-size:12px;' >Merchant Id</th>
                        
                            <th class='text-center' style='font-size:12px;' >Username</th>
                        
                            <th class='text-center' style='font-size:12px;' >Password</th>
                        
                            <th class='text-center' style='font-size:12px;' >Module Status</th>
                        
                            <th class='text-center' style='font-size:12px;' >HSN</th>
                        
                            <th class='text-center' style='font-size:12px;' >authkey</th>
                        
                            <th class='text-center' style='font-size:12px;' >Bolt Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->CardpointeStoreSettingQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->merchant_id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->username."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->password."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->module_status."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->hsn."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->authkey."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->bolt_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Cardpointe Store Setting Report',$html);


    }
    public function show(CardpointeStoreSetting $cardpointestoresetting)
    {
        
        $tab=CardpointeStoreSetting::all();return view('admin.pages.cardpointestoresetting.cardpointestoresetting_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CardpointeStoreSetting  $cardpointestoresetting
     * @return \Illuminate\Http\Response
     */
    public function edit(CardpointeStoreSetting $cardpointestoresetting,$id=0)
    {
        $tab=CardpointeStoreSetting::find($id);      
        return view('admin.pages.cardpointestoresetting.cardpointestoresetting_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CardpointeStoreSetting  $cardpointestoresetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CardpointeStoreSetting $cardpointestoresetting,$id=0)
    {
        $this->validate($request,[
                
                'merchant_id'=>'required',
                'username'=>'required',
                'password'=>'required',
                'module_status'=>'required',
                'hsn'=>'required',
                'authkey'=>'required',
                'bolt_status'=>'required',
        ]);

        $this->SystemAdminLog("Cardpointe Store Setting","Update","Edit / Modify");

        
        $tab=CardpointeStoreSetting::find($id);
        
        $tab->merchant_id=$request->merchant_id;
        $tab->username=$request->username;
        $tab->password=$request->password;
        $tab->module_status=$request->module_status;
        $tab->hsn=$request->hsn;
        $tab->authkey=$request->authkey;
        $tab->bolt_status=$request->bolt_status;
        $tab->save();

        return redirect('cardpointestoresetting')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CardpointeStoreSetting  $cardpointestoresetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(CardpointeStoreSetting $cardpointestoresetting,$id=0)
    {
        $this->SystemAdminLog("Cardpointe Store Setting","Destroy","Delete");

        $tab=CardpointeStoreSetting::find($id);
        $tab->delete();
        return redirect('cardpointestoresetting')->with('status','Deleted Successfully !');}
}

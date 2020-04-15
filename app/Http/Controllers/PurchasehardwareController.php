<?php

namespace App\Http\Controllers;

use App\PurchaseHardware;
use App\AdminLog;
use Illuminate\Http\Request;
use App\Country;
                
use App\HardwarePackage;
                

class PurchaseHardwareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Purchase Hardware";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tab=PurchaseHardware::all();
        return view('admin.pages.purchasehardware.purchasehardware_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        
        $tab_Category= Country::all();
        $tab_HardwarePackage=HardwarePackage::all();           
        return view('admin.pages.purchasehardware.purchasehardware_create',['dataRow_Category'=>$tab_Category,'dataRow_HardwarePackage'=>$tab_HardwarePackage]);
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
                
                'full_name'=>'required',
                'email'=>'required',
                'phone'=>'required',
                'country'=>'required',
                'state'=>'required',
                'zip_code'=>'required',
                'delivery_address'=>'required',
                'card_number'=>'required',
                'card_holder_name'=>'required',
                'card_month'=>'required',
                'card_year'=>'required',
                'card_pin'=>'required',
                'hardware'=>'required',
                'hardware_price'=>'required',
                'payment_status'=>'required',
                'hardware_delivery_status'=>'required',
        ]);

        $this->SystemAdminLog("Purchase Hardware","Save New","Create New");

        
        $tab_3_Category=Country::where('id',$request->country)->first();
        $country_3_Category=$tab_3_Category->name;
        $tab_12_HardwarePackage=HardwarePackage::where('id',$request->hardware)->first();
        $hardware_12_HardwarePackage=$tab_12_HardwarePackage->title;
        $tab=new PurchaseHardware();
        
        $tab->full_name=$request->full_name;
        $tab->email=$request->email;
        $tab->phone=$request->phone;
        $tab->country_name=$country_3_Category;
        $tab->country=$request->country;
        $tab->state=$request->state;
        $tab->zip_code=$request->zip_code;
        $tab->delivery_address=$request->delivery_address;
        $tab->card_number=$request->card_number;
        $tab->card_holder_name=$request->card_holder_name;
        $tab->card_month=$request->card_month;
        $tab->card_year=$request->card_year;
        $tab->card_pin=$request->card_pin;
        $tab->hardware_title=$hardware_12_HardwarePackage;
        $tab->hardware=$request->hardware;
        $tab->hardware_price=$request->hardware_price;
        $tab->payment_status=$request->payment_status;
        $tab->hardware_delivery_status=$request->hardware_delivery_status;
        $tab->save();

        return redirect('purchasehardware')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'full_name'=>'required',
                'email'=>'required',
                'phone'=>'required',
                'country'=>'required',
                'state'=>'required',
                'zip_code'=>'required',
                'delivery_address'=>'required',
                'card_number'=>'required',
                'card_holder_name'=>'required',
                'card_month'=>'required',
                'card_year'=>'required',
                'card_pin'=>'required',
                'hardware'=>'required',
                'hardware_price'=>'required',
                'payment_status'=>'required',
                'hardware_delivery_status'=>'required',
        ]);

        $tab=new PurchaseHardware();
        
        $tab->full_name=$request->full_name;
        $tab->email=$request->email;
        $tab->phone=$request->phone;
        $tab->country_name=$country_3_Category;
        $tab->country=$request->country;
        $tab->state=$request->state;
        $tab->zip_code=$request->zip_code;
        $tab->delivery_address=$request->delivery_address;
        $tab->card_number=$request->card_number;
        $tab->card_holder_name=$request->card_holder_name;
        $tab->card_month=$request->card_month;
        $tab->card_year=$request->card_year;
        $tab->card_pin=$request->card_pin;
        $tab->hardware_title=$hardware_12_HardwarePackage;
        $tab->hardware=$request->hardware;
        $tab->hardware_price=$request->hardware_price;
        $tab->payment_status=$request->payment_status;
        $tab->hardware_delivery_status=$request->hardware_delivery_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PurchaseHardware  $purchasehardware
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('full_name','LIKE','%'.$search.'%');
                            $query->orWhere('email','LIKE','%'.$search.'%');
                            $query->orWhere('phone','LIKE','%'.$search.'%');
                            $query->orWhere('country','LIKE','%'.$search.'%');
                            $query->orWhere('state','LIKE','%'.$search.'%');
                            $query->orWhere('zip_code','LIKE','%'.$search.'%');
                            $query->orWhere('delivery_address','LIKE','%'.$search.'%');
                            $query->orWhere('card_number','LIKE','%'.$search.'%');
                            $query->orWhere('card_holder_name','LIKE','%'.$search.'%');
                            $query->orWhere('card_month','LIKE','%'.$search.'%');
                            $query->orWhere('card_year','LIKE','%'.$search.'%');
                            $query->orWhere('card_pin','LIKE','%'.$search.'%');
                            $query->orWhere('hardware','LIKE','%'.$search.'%');
                            $query->orWhere('hardware_price','LIKE','%'.$search.'%');
                            $query->orWhere('payment_status','LIKE','%'.$search.'%');
                            $query->orWhere('hardware_delivery_status','LIKE','%'.$search.'%');
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
                            $query->orWhere('full_name','LIKE','%'.$search.'%');
                            $query->orWhere('email','LIKE','%'.$search.'%');
                            $query->orWhere('phone','LIKE','%'.$search.'%');
                            $query->orWhere('country','LIKE','%'.$search.'%');
                            $query->orWhere('state','LIKE','%'.$search.'%');
                            $query->orWhere('zip_code','LIKE','%'.$search.'%');
                            $query->orWhere('delivery_address','LIKE','%'.$search.'%');
                            $query->orWhere('card_number','LIKE','%'.$search.'%');
                            $query->orWhere('card_holder_name','LIKE','%'.$search.'%');
                            $query->orWhere('card_month','LIKE','%'.$search.'%');
                            $query->orWhere('card_year','LIKE','%'.$search.'%');
                            $query->orWhere('card_pin','LIKE','%'.$search.'%');
                            $query->orWhere('hardware','LIKE','%'.$search.'%');
                            $query->orWhere('hardware_price','LIKE','%'.$search.'%');
                            $query->orWhere('payment_status','LIKE','%'.$search.'%');
                            $query->orWhere('hardware_delivery_status','LIKE','%'.$search.'%');
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

    
    public function PurchaseHardwareQuery($request)
    {
        $PurchaseHardware_data=PurchaseHardware::orderBy('id','DESC')->get();

        return $PurchaseHardware_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Full Name','Email','Phone','Country','State','Zip Code','Delivery Address','Card Number','Card Holder Name','Card Month','Card Year','Card Pin','Hardware','Hardware Price','Payment Status','Hardware Delivery Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->PurchaseHardwareQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->full_name,$voi->email,$voi->phone,$voi->country,$voi->state,$voi->zip_code,$voi->delivery_address,$voi->card_number,$voi->card_holder_name,$voi->card_month,$voi->card_year,$voi->card_pin,$voi->hardware,$voi->hardware_price,$voi->payment_status,$voi->hardware_delivery_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Purchase Hardware Report',
            'report_title'=>'Purchase Hardware Report',
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
                            <th class='text-center' style='font-size:12px;' >Full Name</th>
                        
                            <th class='text-center' style='font-size:12px;' >Email</th>
                        
                            <th class='text-center' style='font-size:12px;' >Phone</th>
                        
                            <th class='text-center' style='font-size:12px;' >Country</th>
                        
                            <th class='text-center' style='font-size:12px;' >State</th>
                        
                            <th class='text-center' style='font-size:12px;' >Zip Code</th>
                        
                            <th class='text-center' style='font-size:12px;' >Delivery Address</th>
                        
                            <th class='text-center' style='font-size:12px;' >Card Number</th>
                        
                            <th class='text-center' style='font-size:12px;' >Card Holder Name</th>
                        
                            <th class='text-center' style='font-size:12px;' >Card Month</th>
                        
                            <th class='text-center' style='font-size:12px;' >Card Year</th>
                        
                            <th class='text-center' style='font-size:12px;' >Card Pin</th>
                        
                            <th class='text-center' style='font-size:12px;' >Hardware</th>
                        
                            <th class='text-center' style='font-size:12px;' >Hardware Price</th>
                        
                            <th class='text-center' style='font-size:12px;' >Payment Status</th>
                        
                            <th class='text-center' style='font-size:12px;' >Hardware Delivery Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->PurchaseHardwareQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->full_name."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->email."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->phone."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->country."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->state."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->zip_code."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->delivery_address."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->card_number."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->card_holder_name."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->card_month."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->card_year."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->card_pin."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->hardware."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->hardware_price."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->payment_status."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->hardware_delivery_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Purchase Hardware Report',$html);


    }
    public function show(PurchaseHardware $purchasehardware)
    {
        
        $tab=PurchaseHardware::all();return view('admin.pages.purchasehardware.purchasehardware_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PurchaseHardware  $purchasehardware
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseHardware $purchasehardware,$id=0)
    {
        $tab=PurchaseHardware::find($id); 
        $tab_Category= Country::all();
        $tab_HardwarePackage=HardwarePackage::all();     
        return view('admin.pages.purchasehardware.purchasehardware_edit',['dataRow_Category'=>$tab_Category,'dataRow_HardwarePackage'=>$tab_HardwarePackage,'dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PurchaseHardware  $purchasehardware
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseHardware $purchasehardware,$id=0)
    {
        $this->validate($request,[
                
                'full_name'=>'required',
                'email'=>'required',
                'phone'=>'required',
                'country'=>'required',
                'state'=>'required',
                'zip_code'=>'required',
                'delivery_address'=>'required',
                'card_number'=>'required',
                'card_holder_name'=>'required',
                'card_month'=>'required',
                'card_year'=>'required',
                'card_pin'=>'required',
                'hardware'=>'required',
                'hardware_price'=>'required',
                'payment_status'=>'required',
                'hardware_delivery_status'=>'required',
        ]);

        $this->SystemAdminLog("Purchase Hardware","Update","Edit / Modify");

        
        $tab_3_Category= Country::where('id',$request->country)->first();
        $country_3_Category=$tab_3_Category->name;
        $tab_12_HardwarePackage=HardwarePackage::where('id',$request->hardware)->first();
        $hardware_12_HardwarePackage=$tab_12_HardwarePackage->title;
        $tab=PurchaseHardware::find($id);
        
        $tab->full_name=$request->full_name;
        $tab->email=$request->email;
        $tab->phone=$request->phone;
        $tab->country_name=$country_3_Category;
        $tab->country=$request->country;
        $tab->state=$request->state;
        $tab->zip_code=$request->zip_code;
        $tab->delivery_address=$request->delivery_address;
        $tab->card_number=$request->card_number;
        $tab->card_holder_name=$request->card_holder_name;
        $tab->card_month=$request->card_month;
        $tab->card_year=$request->card_year;
        $tab->card_pin=$request->card_pin;
        $tab->hardware_title=$hardware_12_HardwarePackage;
        $tab->hardware=$request->hardware;
        $tab->hardware_price=$request->hardware_price;
        $tab->payment_status=$request->payment_status;
        $tab->hardware_delivery_status=$request->hardware_delivery_status;
        $tab->save();

        return redirect('purchasehardware')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PurchaseHardware  $purchasehardware
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseHardware $purchasehardware,$id=0)
    {
        $this->SystemAdminLog("Purchase Hardware","Destroy","Delete");

        $tab=PurchaseHardware::find($id);
        $tab->delete();
        return redirect('purchasehardware')->with('status','Deleted Successfully !');}
}

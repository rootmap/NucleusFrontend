<?php

namespace App\Http\Controllers;

use App\BusinessPOSSystem;
use App\AdminLog;
use Illuminate\Http\Request;

class BusinessPOSSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Business POS System";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tabCount=BusinessPOSSystem::count();
        if($tabCount==0)
        {
            return redirect(url('businesspossystem/create'));
        }else{

            $tab=BusinessPOSSystem::orderBy('id','DESC')->first();      
        return view('admin.pages.businesspossystem.businesspossystem_edit',['dataRow'=>$tab,'edit'=>true]); 
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        
        $tabCount=BusinessPOSSystem::count();
        if($tabCount==0)
        {            
        return view('admin.pages.businesspossystem.businesspossystem_create');
            
        }else{

            $tab=BusinessPOSSystem::orderBy('id','DESC')->first();      
        return view('admin.pages.businesspossystem.businesspossystem_edit',['dataRow'=>$tab,'edit'=>true]); 
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
                
                'heading'=>'required',
                'detail'=>'required',
                'content_image'=>'required',
                'section_foreground_color'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Business POS System","Save New","Create New");

        

        $filename_businesspossystem_2='';
        if ($request->hasFile('content_image')) {
            $img_businesspossystem = $request->file('content_image');
            $upload_businesspossystem = 'upload/businesspossystem';
            $filename_businesspossystem_2 = env('APP_NAME').'_'.time() . '.' . $img_businesspossystem->getClientOriginalExtension();
            $img_businesspossystem->move($upload_businesspossystem, $filename_businesspossystem_2);
        }

                
        $tab=new BusinessPOSSystem();
        
        $tab->heading=$request->heading;
        $tab->detail=$request->detail;
        $tab->content_image=$filename_businesspossystem_2;
        $tab->section_foreground_color=$request->section_foreground_color;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('businesspossystem')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'heading'=>'required',
                'detail'=>'required',
                'content_image'=>'required',
                'section_foreground_color'=>'required',
                'module_status'=>'required',
        ]);

        $tab=new BusinessPOSSystem();
        
        $tab->heading=$request->heading;
        $tab->detail=$request->detail;
        $tab->content_image=$filename_businesspossystem_2;
        $tab->section_foreground_color=$request->section_foreground_color;
        $tab->module_status=$request->module_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BusinessPOSSystem  $businesspossystem
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('heading','LIKE','%'.$search.'%');
                            $query->orWhere('detail','LIKE','%'.$search.'%');
                            $query->orWhere('content_image','LIKE','%'.$search.'%');
                            $query->orWhere('section_foreground_color','LIKE','%'.$search.'%');
                            $query->orWhere('module_status','LIKE','%'.$search.'%');
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
                            $query->orWhere('heading','LIKE','%'.$search.'%');
                            $query->orWhere('detail','LIKE','%'.$search.'%');
                            $query->orWhere('content_image','LIKE','%'.$search.'%');
                            $query->orWhere('section_foreground_color','LIKE','%'.$search.'%');
                            $query->orWhere('module_status','LIKE','%'.$search.'%');
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

    
    public function BusinessPOSSystemQuery($request)
    {
        $BusinessPOSSystem_data=BusinessPOSSystem::orderBy('id','DESC')->get();

        return $BusinessPOSSystem_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Heading','Detail','Content Image','Section Foreground Color','Module Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->BusinessPOSSystemQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->heading,$voi->detail,$voi->content_image,$voi->section_foreground_color,$voi->module_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Business POS System Report',
            'report_title'=>'Business POS System Report',
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
                            <th class='text-center' style='font-size:12px;' >Heading</th>
                        
                            <th class='text-center' style='font-size:12px;' >Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Content Image</th>
                        
                            <th class='text-center' style='font-size:12px;' >Section Foreground Color</th>
                        
                            <th class='text-center' style='font-size:12px;' >Module Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->BusinessPOSSystemQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->heading."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->content_image."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_foreground_color."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->module_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Business POS System Report',$html);


    }
    public function show(BusinessPOSSystem $businesspossystem)
    {
        
        $tab=BusinessPOSSystem::all();return view('admin.pages.businesspossystem.businesspossystem_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BusinessPOSSystem  $businesspossystem
     * @return \Illuminate\Http\Response
     */
    public function edit(BusinessPOSSystem $businesspossystem,$id=0)
    {
        $tab=BusinessPOSSystem::find($id);      
        return view('admin.pages.businesspossystem.businesspossystem_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BusinessPOSSystem  $businesspossystem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusinessPOSSystem $businesspossystem,$id=0)
    {
        $this->validate($request,[
                
                'heading'=>'required',
                'detail'=>'required',
                'section_foreground_color'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Business POS System","Update","Edit / Modify");

        

        $filename_businesspossystem_2=$request->ex_content_image;
        if ($request->hasFile('content_image')) {
            $img_businesspossystem = $request->file('content_image');
            $upload_businesspossystem = 'upload/businesspossystem';
            $filename_businesspossystem_2 = env('APP_NAME').'_'.time() . '.' . $img_businesspossystem->getClientOriginalExtension();
            $img_businesspossystem->move($upload_businesspossystem, $filename_businesspossystem_2);
        }

                
        $tab=BusinessPOSSystem::find($id);
        
        $tab->heading=$request->heading;
        $tab->detail=$request->detail;
        $tab->content_image=$filename_businesspossystem_2;
        $tab->section_foreground_color=$request->section_foreground_color;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('businesspossystem')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BusinessPOSSystem  $businesspossystem
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessPOSSystem $businesspossystem,$id=0)
    {
        $this->SystemAdminLog("Business POS System","Destroy","Delete");

        $tab=BusinessPOSSystem::find($id);
        $tab->delete();
        return redirect('businesspossystem')->with('status','Deleted Successfully !');}
}

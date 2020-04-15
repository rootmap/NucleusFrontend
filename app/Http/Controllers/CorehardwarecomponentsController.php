<?php

namespace App\Http\Controllers;

use App\CoreHardwareComponents;
use App\AdminLog;
use Illuminate\Http\Request;

class CoreHardwareComponentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Core Hardware Components";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tab=CoreHardwareComponents::all();
        return view('admin.pages.corehardwarecomponents.corehardwarecomponents_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


                   
        return view('admin.pages.corehardwarecomponents.corehardwarecomponents_create');
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
                
                'hardware_image'=>'required',
                'hardware_title'=>'required',
                'hardware_detail'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Core Hardware Components","Save New","Create New");

        

        $filename_corehardwarecomponents_0='';
        if ($request->hasFile('hardware_image')) {
            $img_corehardwarecomponents = $request->file('hardware_image');
            $upload_corehardwarecomponents = 'upload/corehardwarecomponents';
            $filename_corehardwarecomponents_0 = env('APP_NAME').'_'.time() . '.' . $img_corehardwarecomponents->getClientOriginalExtension();
            $img_corehardwarecomponents->move($upload_corehardwarecomponents, $filename_corehardwarecomponents_0);
        }

                
        $tab=new CoreHardwareComponents();
        
        $tab->hardware_image=$filename_corehardwarecomponents_0;
        $tab->hardware_title=$request->hardware_title;
        $tab->hardware_detail=$request->hardware_detail;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('corehardwarecomponents')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'hardware_image'=>'required',
                'hardware_title'=>'required',
                'hardware_detail'=>'required',
                'module_status'=>'required',
        ]);

        $tab=new CoreHardwareComponents();
        
        $tab->hardware_image=$filename_corehardwarecomponents_0;
        $tab->hardware_title=$request->hardware_title;
        $tab->hardware_detail=$request->hardware_detail;
        $tab->module_status=$request->module_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CoreHardwareComponents  $corehardwarecomponents
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('hardware_image','LIKE','%'.$search.'%');
                            $query->orWhere('hardware_title','LIKE','%'.$search.'%');
                            $query->orWhere('hardware_detail','LIKE','%'.$search.'%');
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
                            $query->orWhere('hardware_image','LIKE','%'.$search.'%');
                            $query->orWhere('hardware_title','LIKE','%'.$search.'%');
                            $query->orWhere('hardware_detail','LIKE','%'.$search.'%');
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

    
    public function CoreHardwareComponentsQuery($request)
    {
        $CoreHardwareComponents_data=CoreHardwareComponents::orderBy('id','DESC')->get();

        return $CoreHardwareComponents_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Hardware Image','Hardware Title','Hardware Detail','Module Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->CoreHardwareComponentsQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->hardware_image,$voi->hardware_title,$voi->hardware_detail,$voi->module_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Core Hardware Components Report',
            'report_title'=>'Core Hardware Components Report',
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
                            <th class='text-center' style='font-size:12px;' >Hardware Image</th>
                        
                            <th class='text-center' style='font-size:12px;' >Hardware Title</th>
                        
                            <th class='text-center' style='font-size:12px;' >Hardware Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Module Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->CoreHardwareComponentsQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->hardware_image."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->hardware_title."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->hardware_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->module_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Core Hardware Components Report',$html);


    }
    public function show(CoreHardwareComponents $corehardwarecomponents)
    {
        
        $tab=CoreHardwareComponents::all();return view('admin.pages.corehardwarecomponents.corehardwarecomponents_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CoreHardwareComponents  $corehardwarecomponents
     * @return \Illuminate\Http\Response
     */
    public function edit(CoreHardwareComponents $corehardwarecomponents,$id=0)
    {
        $tab=CoreHardwareComponents::find($id);      
        return view('admin.pages.corehardwarecomponents.corehardwarecomponents_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CoreHardwareComponents  $corehardwarecomponents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CoreHardwareComponents $corehardwarecomponents,$id=0)
    {
        $this->validate($request,[
                
                'hardware_title'=>'required',
                'hardware_detail'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Core Hardware Components","Update","Edit / Modify");

        

        $filename_corehardwarecomponents_0=$request->ex_hardware_image;
        if ($request->hasFile('hardware_image')) {
            $img_corehardwarecomponents = $request->file('hardware_image');
            $upload_corehardwarecomponents = 'upload/corehardwarecomponents';
            $filename_corehardwarecomponents_0 = env('APP_NAME').'_'.time() . '.' . $img_corehardwarecomponents->getClientOriginalExtension();
            $img_corehardwarecomponents->move($upload_corehardwarecomponents, $filename_corehardwarecomponents_0);
        }

                
        $tab=CoreHardwareComponents::find($id);
        
        $tab->hardware_image=$filename_corehardwarecomponents_0;
        $tab->hardware_title=$request->hardware_title;
        $tab->hardware_detail=$request->hardware_detail;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('corehardwarecomponents')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CoreHardwareComponents  $corehardwarecomponents
     * @return \Illuminate\Http\Response
     */
    public function destroy(CoreHardwareComponents $corehardwarecomponents,$id=0)
    {
        $this->SystemAdminLog("Core Hardware Components","Destroy","Delete");

        $tab=CoreHardwareComponents::find($id);
        $tab->delete();
        return redirect('corehardwarecomponents')->with('status','Deleted Successfully !');}
}

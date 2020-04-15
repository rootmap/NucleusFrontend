<?php

namespace App\Http\Controllers;

use App\CoreSoftwareComponents;
use App\AdminLog;
use Illuminate\Http\Request;

class CoreSoftwareComponentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Core Software Components";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tab=CoreSoftwareComponents::all();
        return view('admin.pages.coresoftwarecomponents.coresoftwarecomponents_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


                   
        return view('admin.pages.coresoftwarecomponents.coresoftwarecomponents_create');
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
                
                'content_image'=>'required',
                'sub_title'=>'required',
                'content_detail'=>'required',
                'section_status'=>'required',
        ]);

        $this->SystemAdminLog("Core Software Components","Save New","Create New");

        

        $filename_coresoftwarecomponents_0='';
        if ($request->hasFile('content_image')) {
            $img_coresoftwarecomponents = $request->file('content_image');
            $upload_coresoftwarecomponents = 'upload/coresoftwarecomponents';
            $filename_coresoftwarecomponents_0 = env('APP_NAME').'_'.time() . '.' . $img_coresoftwarecomponents->getClientOriginalExtension();
            $img_coresoftwarecomponents->move($upload_coresoftwarecomponents, $filename_coresoftwarecomponents_0);
        }

                
        $tab=new CoreSoftwareComponents();
        
        $tab->content_image=$filename_coresoftwarecomponents_0;
        $tab->sub_title=$request->sub_title;
        $tab->content_detail=$request->content_detail;
        $tab->section_status=$request->section_status;
        $tab->save();

        return redirect('coresoftwarecomponents')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'content_image'=>'required',
                'sub_title'=>'required',
                'content_detail'=>'required',
                'section_status'=>'required',
        ]);

        $tab=new CoreSoftwareComponents();
        
        $tab->content_image=$filename_coresoftwarecomponents_0;
        $tab->sub_title=$request->sub_title;
        $tab->content_detail=$request->content_detail;
        $tab->section_status=$request->section_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CoreSoftwareComponents  $coresoftwarecomponents
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('content_image','LIKE','%'.$search.'%');
                            $query->orWhere('sub_title','LIKE','%'.$search.'%');
                            $query->orWhere('content_detail','LIKE','%'.$search.'%');
                            $query->orWhere('section_status','LIKE','%'.$search.'%');
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
                            $query->orWhere('content_image','LIKE','%'.$search.'%');
                            $query->orWhere('sub_title','LIKE','%'.$search.'%');
                            $query->orWhere('content_detail','LIKE','%'.$search.'%');
                            $query->orWhere('section_status','LIKE','%'.$search.'%');
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

    
    public function CoreSoftwareComponentsQuery($request)
    {
        $CoreSoftwareComponents_data=CoreSoftwareComponents::orderBy('id','DESC')->get();

        return $CoreSoftwareComponents_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Content Image','Sub Title','Content Detail','Section Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->CoreSoftwareComponentsQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->content_image,$voi->sub_title,$voi->content_detail,$voi->section_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Core Software Components Report',
            'report_title'=>'Core Software Components Report',
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
                            <th class='text-center' style='font-size:12px;' >Content Image</th>
                        
                            <th class='text-center' style='font-size:12px;' >Sub Title</th>
                        
                            <th class='text-center' style='font-size:12px;' >Content Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Section Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->CoreSoftwareComponentsQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->content_image."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->sub_title."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->content_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Core Software Components Report',$html);


    }
    public function show(CoreSoftwareComponents $coresoftwarecomponents)
    {
        
        $tab=CoreSoftwareComponents::all();return view('admin.pages.coresoftwarecomponents.coresoftwarecomponents_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CoreSoftwareComponents  $coresoftwarecomponents
     * @return \Illuminate\Http\Response
     */
    public function edit(CoreSoftwareComponents $coresoftwarecomponents,$id=0)
    {
        $tab=CoreSoftwareComponents::find($id);      
        return view('admin.pages.coresoftwarecomponents.coresoftwarecomponents_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CoreSoftwareComponents  $coresoftwarecomponents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CoreSoftwareComponents $coresoftwarecomponents,$id=0)
    {
        $this->validate($request,[
                
                'sub_title'=>'required',
                'content_detail'=>'required',
                'section_status'=>'required',
        ]);

        $this->SystemAdminLog("Core Software Components","Update","Edit / Modify");

        

        $filename_coresoftwarecomponents_0=$request->ex_content_image;
        if ($request->hasFile('content_image')) {
            $img_coresoftwarecomponents = $request->file('content_image');
            $upload_coresoftwarecomponents = 'upload/coresoftwarecomponents';
            $filename_coresoftwarecomponents_0 = env('APP_NAME').'_'.time() . '.' . $img_coresoftwarecomponents->getClientOriginalExtension();
            $img_coresoftwarecomponents->move($upload_coresoftwarecomponents, $filename_coresoftwarecomponents_0);
        }

                
        $tab=CoreSoftwareComponents::find($id);
        
        $tab->content_image=$filename_coresoftwarecomponents_0;
        $tab->sub_title=$request->sub_title;
        $tab->content_detail=$request->content_detail;
        $tab->section_status=$request->section_status;
        $tab->save();

        return redirect('coresoftwarecomponents')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CoreSoftwareComponents  $coresoftwarecomponents
     * @return \Illuminate\Http\Response
     */
    public function destroy(CoreSoftwareComponents $coresoftwarecomponents,$id=0)
    {
        $this->SystemAdminLog("Core Software Components","Destroy","Delete");

        $tab=CoreSoftwareComponents::find($id);
        $tab->delete();
        return redirect('coresoftwarecomponents')->with('status','Deleted Successfully !');}
}

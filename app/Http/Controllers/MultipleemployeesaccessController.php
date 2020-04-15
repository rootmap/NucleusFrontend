<?php

namespace App\Http\Controllers;

use App\MultipleEmployeesAccess;
use App\AdminLog;
use Illuminate\Http\Request;

class MultipleEmployeesAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Multiple Employees Access";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tabCount=MultipleEmployeesAccess::count();
        if($tabCount==0)
        {
            return redirect(url('multipleemployeesaccess/create'));
        }else{

            $tab=MultipleEmployeesAccess::orderBy('id','DESC')->first();      
        return view('admin.pages.multipleemployeesaccess.multipleemployeesaccess_edit',['dataRow'=>$tab,'edit'=>true]); 
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        
        $tabCount=MultipleEmployeesAccess::count();
        if($tabCount==0)
        {            
        return view('admin.pages.multipleemployeesaccess.multipleemployeesaccess_create');
            
        }else{

            $tab=MultipleEmployeesAccess::orderBy('id','DESC')->first();      
        return view('admin.pages.multipleemployeesaccess.multipleemployeesaccess_edit',['dataRow'=>$tab,'edit'=>true]); 
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
                'title'=>'required',
                'content_detail'=>'required',
                'content_image'=>'required',
                'section_foreground_color'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Multiple Employees Access","Save New","Create New");

        

        $filename_multipleemployeesaccess_4='';
        if ($request->hasFile('content_image')) {
            $img_multipleemployeesaccess = $request->file('content_image');
            $upload_multipleemployeesaccess = 'upload/multipleemployeesaccess';
            $filename_multipleemployeesaccess_4 = env('APP_NAME').'_'.time() . '.' . $img_multipleemployeesaccess->getClientOriginalExtension();
            $img_multipleemployeesaccess->move($upload_multipleemployeesaccess, $filename_multipleemployeesaccess_4);
        }

                
        $tab=new MultipleEmployeesAccess();
        
        $tab->heading=$request->heading;
        $tab->detail=$request->detail;
        $tab->title=$request->title;
        $tab->content_detail=$request->content_detail;
        $tab->content_image=$filename_multipleemployeesaccess_4;
        $tab->section_foreground_color=$request->section_foreground_color;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('multipleemployeesaccess')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'heading'=>'required',
                'detail'=>'required',
                'title'=>'required',
                'content_detail'=>'required',
                'content_image'=>'required',
                'section_foreground_color'=>'required',
                'module_status'=>'required',
        ]);

        $tab=new MultipleEmployeesAccess();
        
        $tab->heading=$request->heading;
        $tab->detail=$request->detail;
        $tab->title=$request->title;
        $tab->content_detail=$request->content_detail;
        $tab->content_image=$filename_multipleemployeesaccess_4;
        $tab->section_foreground_color=$request->section_foreground_color;
        $tab->module_status=$request->module_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MultipleEmployeesAccess  $multipleemployeesaccess
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('heading','LIKE','%'.$search.'%');
                            $query->orWhere('detail','LIKE','%'.$search.'%');
                            $query->orWhere('title','LIKE','%'.$search.'%');
                            $query->orWhere('content_detail','LIKE','%'.$search.'%');
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
                            $query->orWhere('title','LIKE','%'.$search.'%');
                            $query->orWhere('content_detail','LIKE','%'.$search.'%');
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

    
    public function MultipleEmployeesAccessQuery($request)
    {
        $MultipleEmployeesAccess_data=MultipleEmployeesAccess::orderBy('id','DESC')->get();

        return $MultipleEmployeesAccess_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Heading','Detail','Title','Content Detail','Content Image','Section Foreground Color','Module Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->MultipleEmployeesAccessQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->heading,$voi->detail,$voi->title,$voi->content_detail,$voi->content_image,$voi->section_foreground_color,$voi->module_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Multiple Employees Access Report',
            'report_title'=>'Multiple Employees Access Report',
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
                        
                            <th class='text-center' style='font-size:12px;' >Title</th>
                        
                            <th class='text-center' style='font-size:12px;' >Content Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Content Image</th>
                        
                            <th class='text-center' style='font-size:12px;' >Section Foreground Color</th>
                        
                            <th class='text-center' style='font-size:12px;' >Module Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->MultipleEmployeesAccessQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->heading."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->title."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->content_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->content_image."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_foreground_color."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->module_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Multiple Employees Access Report',$html);


    }
    public function show(MultipleEmployeesAccess $multipleemployeesaccess)
    {
        
        $tab=MultipleEmployeesAccess::all();return view('admin.pages.multipleemployeesaccess.multipleemployeesaccess_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MultipleEmployeesAccess  $multipleemployeesaccess
     * @return \Illuminate\Http\Response
     */
    public function edit(MultipleEmployeesAccess $multipleemployeesaccess,$id=0)
    {
        $tab=MultipleEmployeesAccess::find($id);      
        return view('admin.pages.multipleemployeesaccess.multipleemployeesaccess_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MultipleEmployeesAccess  $multipleemployeesaccess
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MultipleEmployeesAccess $multipleemployeesaccess,$id=0)
    {
        $this->validate($request,[
                
                'heading'=>'required',
                'detail'=>'required',
                'title'=>'required',
                'content_detail'=>'required',
                'section_foreground_color'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Multiple Employees Access","Update","Edit / Modify");

        

        $filename_multipleemployeesaccess_4=$request->ex_content_image;
        if ($request->hasFile('content_image')) {
            $img_multipleemployeesaccess = $request->file('content_image');
            $upload_multipleemployeesaccess = 'upload/multipleemployeesaccess';
            $filename_multipleemployeesaccess_4 = env('APP_NAME').'_'.time() . '.' . $img_multipleemployeesaccess->getClientOriginalExtension();
            $img_multipleemployeesaccess->move($upload_multipleemployeesaccess, $filename_multipleemployeesaccess_4);
        }

                
        $tab=MultipleEmployeesAccess::find($id);
        
        $tab->heading=$request->heading;
        $tab->detail=$request->detail;
        $tab->title=$request->title;
        $tab->content_detail=$request->content_detail;
        $tab->content_image=$filename_multipleemployeesaccess_4;
        $tab->section_foreground_color=$request->section_foreground_color;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('multipleemployeesaccess')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MultipleEmployeesAccess  $multipleemployeesaccess
     * @return \Illuminate\Http\Response
     */
    public function destroy(MultipleEmployeesAccess $multipleemployeesaccess,$id=0)
    {
        $this->SystemAdminLog("Multiple Employees Access","Destroy","Delete");

        $tab=MultipleEmployeesAccess::find($id);
        $tab->delete();
        return redirect('multipleemployeesaccess')->with('status','Deleted Successfully !');}
}

<?php

namespace App\Http\Controllers;

use App\PowerfulCapabilities;
use App\AdminLog;
use Illuminate\Http\Request;

class PowerfulCapabilitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Powerful Capabilities";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tabCount=PowerfulCapabilities::count();
        if($tabCount==0)
        {
            return redirect(url('powerfulcapabilities/create'));
        }else{

            $tab=PowerfulCapabilities::orderBy('id','DESC')->first();      
        return view('admin.pages.powerfulcapabilities.powerfulcapabilities_edit',['dataRow'=>$tab,'edit'=>true]); 
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        
        $tabCount=PowerfulCapabilities::count();
        if($tabCount==0)
        {            
        return view('admin.pages.powerfulcapabilities.powerfulcapabilities_create');
            
        }else{

            $tab=PowerfulCapabilities::orderBy('id','DESC')->first();      
        return view('admin.pages.powerfulcapabilities.powerfulcapabilities_edit',['dataRow'=>$tab,'edit'=>true]); 
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
                
                'heading_detail'=>'required',
                'heading_title'=>'required',
                'content_image'=>'required',
                'section_foreground_color'=>'required',
                'section_status'=>'required',
        ]);

        $this->SystemAdminLog("Powerful Capabilities","Save New","Create New");

        

        $filename_powerfulcapabilities_3='';
        if ($request->hasFile('content_image')) {
            $img_powerfulcapabilities = $request->file('content_image');
            $upload_powerfulcapabilities = 'upload/powerfulcapabilities';
            $filename_powerfulcapabilities_3 = env('APP_NAME').'_'.time() . '.' . $img_powerfulcapabilities->getClientOriginalExtension();
            $img_powerfulcapabilities->move($upload_powerfulcapabilities, $filename_powerfulcapabilities_3);
        }

        $newAr=[];

        if(count($request->capability_item)>0)
        {
            foreach ($request->capability_item as $key => $row) {
                $newAr[]=array('name'=>$row);
            }
        }

        $feature_details=json_encode($newAr);

                
        $tab=new PowerfulCapabilities();
        
        $tab->heading_detail=$request->heading_detail;
        $tab->heading_title=$request->heading_title;
        $tab->capability_item=$feature_details;
        $tab->content_image=$filename_powerfulcapabilities_3;
        $tab->section_foreground_color=$request->section_foreground_color;
        $tab->section_status=$request->section_status;
        $tab->save();

        return redirect('powerfulcapabilities')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'heading_detail'=>'required',
                'heading_title'=>'required',
                'capability_item'=>'required',
                'content_image'=>'required',
                'section_foreground_color'=>'required',
                'section_status'=>'required',
        ]);

        $tab=new PowerfulCapabilities();
        
        $tab->heading_detail=$request->heading_detail;
        $tab->heading_title=$request->heading_title;
        $tab->capability_item=$request->capability_item;
        $tab->content_image=$filename_powerfulcapabilities_3;
        $tab->section_foreground_color=$request->section_foreground_color;
        $tab->section_status=$request->section_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PowerfulCapabilities  $powerfulcapabilities
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('heading_detail','LIKE','%'.$search.'%');
                            $query->orWhere('heading_title','LIKE','%'.$search.'%');
                            $query->orWhere('capability_item','LIKE','%'.$search.'%');
                            $query->orWhere('content_image','LIKE','%'.$search.'%');
                            $query->orWhere('section_foreground_color','LIKE','%'.$search.'%');
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
                            $query->orWhere('heading_detail','LIKE','%'.$search.'%');
                            $query->orWhere('heading_title','LIKE','%'.$search.'%');
                            $query->orWhere('capability_item','LIKE','%'.$search.'%');
                            $query->orWhere('content_image','LIKE','%'.$search.'%');
                            $query->orWhere('section_foreground_color','LIKE','%'.$search.'%');
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

    
    public function PowerfulCapabilitiesQuery($request)
    {
        $PowerfulCapabilities_data=PowerfulCapabilities::orderBy('id','DESC')->get();

        return $PowerfulCapabilities_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Heading Detail','Heading Title','Capability Item','Content Image','Section Foreground Color','Section Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->PowerfulCapabilitiesQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->heading_detail,$voi->heading_title,$voi->capability_item,$voi->content_image,$voi->section_foreground_color,$voi->section_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Powerful Capabilities Report',
            'report_title'=>'Powerful Capabilities Report',
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
                            <th class='text-center' style='font-size:12px;' >Heading Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Heading Title</th>
                        
                            <th class='text-center' style='font-size:12px;' >Capability Item</th>
                        
                            <th class='text-center' style='font-size:12px;' >Content Image</th>
                        
                            <th class='text-center' style='font-size:12px;' >Section Foreground Color</th>
                        
                            <th class='text-center' style='font-size:12px;' >Section Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->PowerfulCapabilitiesQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->heading_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->heading_title."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->capability_item."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->content_image."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_foreground_color."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Powerful Capabilities Report',$html);


    }
    public function show(PowerfulCapabilities $powerfulcapabilities)
    {
        
        $tab=PowerfulCapabilities::all();return view('admin.pages.powerfulcapabilities.powerfulcapabilities_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PowerfulCapabilities  $powerfulcapabilities
     * @return \Illuminate\Http\Response
     */
    public function edit(PowerfulCapabilities $powerfulcapabilities,$id=0)
    {
        $tab=PowerfulCapabilities::find($id);      
        return view('admin.pages.powerfulcapabilities.powerfulcapabilities_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PowerfulCapabilities  $powerfulcapabilities
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PowerfulCapabilities $powerfulcapabilities,$id=0)
    {
        $this->validate($request,[
                
                'heading_detail'=>'required',
                'heading_title'=>'required',
                
                'section_foreground_color'=>'required',
                'section_status'=>'required',
        ]);

        $this->SystemAdminLog("Powerful Capabilities","Update","Edit / Modify");

        $newAr=[];

        if(count($request->capability_item)>0)
        {
            foreach ($request->capability_item as $key => $row) {
                $newAr[]=array('name'=>$row);
            }
        }

        $feature_details=json_encode($newAr);

        $filename_powerfulcapabilities_3=$request->ex_content_image;
        if ($request->hasFile('content_image')) {
            $img_powerfulcapabilities = $request->file('content_image');
            $upload_powerfulcapabilities = 'upload/powerfulcapabilities';
            $filename_powerfulcapabilities_3 = env('APP_NAME').'_'.time() . '.' . $img_powerfulcapabilities->getClientOriginalExtension();
            $img_powerfulcapabilities->move($upload_powerfulcapabilities, $filename_powerfulcapabilities_3);
        }

                
        $tab=PowerfulCapabilities::find($id);
        
        $tab->heading_detail=$request->heading_detail;
        $tab->heading_title=$request->heading_title;
        $tab->capability_item=$feature_details;
        $tab->content_image=$filename_powerfulcapabilities_3;
        $tab->section_foreground_color=$request->section_foreground_color;
        $tab->section_status=$request->section_status;
        $tab->save();

        return redirect('powerfulcapabilities')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PowerfulCapabilities  $powerfulcapabilities
     * @return \Illuminate\Http\Response
     */
    public function destroy(PowerfulCapabilities $powerfulcapabilities,$id=0)
    {
        $this->SystemAdminLog("Powerful Capabilities","Destroy","Delete");

        $tab=PowerfulCapabilities::find($id);
        $tab->delete();
        return redirect('powerfulcapabilities')->with('status','Deleted Successfully !');}
}

<?php

namespace App\Http\Controllers;

use App\OtherFeature;
use App\AdminLog;
use Illuminate\Http\Request;

class OtherFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Other Feature";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tab=OtherFeature::all();
        return view('admin.pages.otherfeature.otherfeature_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


                   
        return view('admin.pages.otherfeature.otherfeature_create');
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
                'details'=>'required',
                'content_image'=>'required',
                'image_position'=>'required',
                'section_foreground_color'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Other Feature","Save New","Create New");

        

        $filename_otherfeature_2='';
        if ($request->hasFile('content_image')) {
            $img_otherfeature = $request->file('content_image');
            $upload_otherfeature = 'upload/otherfeature';
            $filename_otherfeature_2 = env('APP_NAME').'_'.time() . '.' . $img_otherfeature->getClientOriginalExtension();
            $img_otherfeature->move($upload_otherfeature, $filename_otherfeature_2);
        }

                
        $tab=new OtherFeature();
        
        $tab->heading=$request->heading;
        $tab->details=$request->details;
        $tab->content_image=$filename_otherfeature_2;
        $tab->image_position=$request->image_position;
        $tab->section_foreground_color=$request->section_foreground_color;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('otherfeature')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'heading'=>'required',
                'details'=>'required',
                'content_image'=>'required',
                'image_position'=>'required',
                'section_foreground_color'=>'required',
                'module_status'=>'required',
        ]);

        $tab=new OtherFeature();
        
        $tab->heading=$request->heading;
        $tab->details=$request->details;
        $tab->content_image=$filename_otherfeature_2;
        $tab->image_position=$request->image_position;
        $tab->section_foreground_color=$request->section_foreground_color;
        $tab->module_status=$request->module_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OtherFeature  $otherfeature
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('heading','LIKE','%'.$search.'%');
                            $query->orWhere('details','LIKE','%'.$search.'%');
                            $query->orWhere('content_image','LIKE','%'.$search.'%');
                            $query->orWhere('image_position','LIKE','%'.$search.'%');
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
                            $query->orWhere('details','LIKE','%'.$search.'%');
                            $query->orWhere('content_image','LIKE','%'.$search.'%');
                            $query->orWhere('image_position','LIKE','%'.$search.'%');
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

    
    public function OtherFeatureQuery($request)
    {
        $OtherFeature_data=OtherFeature::orderBy('id','DESC')->get();

        return $OtherFeature_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Heading','Details','Content Image','Image Position','Section Foreground Color','Module Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->OtherFeatureQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->heading,$voi->details,$voi->content_image,$voi->image_position,$voi->section_foreground_color,$voi->module_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Other Feature Report',
            'report_title'=>'Other Feature Report',
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
                        
                            <th class='text-center' style='font-size:12px;' >Details</th>
                        
                            <th class='text-center' style='font-size:12px;' >Content Image</th>
                        
                            <th class='text-center' style='font-size:12px;' >Image Position</th>
                        
                            <th class='text-center' style='font-size:12px;' >Section Foreground Color</th>
                        
                            <th class='text-center' style='font-size:12px;' >Module Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->OtherFeatureQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->heading."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->details."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->content_image."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->image_position."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_foreground_color."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->module_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Other Feature Report',$html);


    }
    public function show(OtherFeature $otherfeature)
    {
        
        $tab=OtherFeature::all();return view('admin.pages.otherfeature.otherfeature_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OtherFeature  $otherfeature
     * @return \Illuminate\Http\Response
     */
    public function edit(OtherFeature $otherfeature,$id=0)
    {
        $tab=OtherFeature::find($id);      
        return view('admin.pages.otherfeature.otherfeature_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OtherFeature  $otherfeature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OtherFeature $otherfeature,$id=0)
    {
        $this->validate($request,[
                
                'heading'=>'required',
                'details'=>'required',
                'image_position'=>'required',
                'section_foreground_color'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Other Feature","Update","Edit / Modify");

        

        $filename_otherfeature_2=$request->ex_content_image;
        if ($request->hasFile('content_image')) {
            $img_otherfeature = $request->file('content_image');
            $upload_otherfeature = 'upload/otherfeature';
            $filename_otherfeature_2 = env('APP_NAME').'_'.time() . '.' . $img_otherfeature->getClientOriginalExtension();
            $img_otherfeature->move($upload_otherfeature, $filename_otherfeature_2);
        }

                
        $tab=OtherFeature::find($id);
        
        $tab->heading=$request->heading;
        $tab->details=$request->details;
        $tab->content_image=$filename_otherfeature_2;
        $tab->image_position=$request->image_position;
        $tab->section_foreground_color=$request->section_foreground_color;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('otherfeature')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OtherFeature  $otherfeature
     * @return \Illuminate\Http\Response
     */
    public function destroy(OtherFeature $otherfeature,$id=0)
    {
        $this->SystemAdminLog("Other Feature","Destroy","Delete");

        $tab=OtherFeature::find($id);
        $tab->delete();
        return redirect('otherfeature')->with('status','Deleted Successfully !');}
}

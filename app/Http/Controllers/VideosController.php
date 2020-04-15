<?php

namespace App\Http\Controllers;

use App\Videos;
use App\AdminLog;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Videos";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tab=Videos::all();
        return view('admin.pages.videos.videos_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


                   
        return view('admin.pages.videos.videos_create');
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
                'video_image'=>'required',
                'video_link'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Videos","Save New","Create New");

        

        $filename_videos_1='';
        if ($request->hasFile('video_image')) {
            $img_videos = $request->file('video_image');
            $upload_videos = 'upload/videos';
            $filename_videos_1 = env('APP_NAME').'_'.time() . '.' . $img_videos->getClientOriginalExtension();
            $img_videos->move($upload_videos, $filename_videos_1);
        }

                
        $tab=new Videos();
        
        $tab->heading=$request->heading;
        $tab->video_image=$filename_videos_1;
        $tab->video_link=$request->video_link;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('videos')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'heading'=>'required',
                'video_image'=>'required',
                'video_link'=>'required',
                'module_status'=>'required',
        ]);

        $tab=new Videos();
        
        $tab->heading=$request->heading;
        $tab->video_image=$filename_videos_1;
        $tab->video_link=$request->video_link;
        $tab->module_status=$request->module_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Videos  $videos
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('heading','LIKE','%'.$search.'%');
                            $query->orWhere('video_image','LIKE','%'.$search.'%');
                            $query->orWhere('video_link','LIKE','%'.$search.'%');
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
                            $query->orWhere('video_image','LIKE','%'.$search.'%');
                            $query->orWhere('video_link','LIKE','%'.$search.'%');
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

    
    public function VideosQuery($request)
    {
        $Videos_data=Videos::orderBy('id','DESC')->get();

        return $Videos_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Heading','Video Image','Video Link','Module Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->VideosQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->heading,$voi->video_image,$voi->video_link,$voi->module_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Videos Report',
            'report_title'=>'Videos Report',
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
                        
                            <th class='text-center' style='font-size:12px;' >Video Image</th>
                        
                            <th class='text-center' style='font-size:12px;' >Video Link</th>
                        
                            <th class='text-center' style='font-size:12px;' >Module Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->VideosQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->heading."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->video_image."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->video_link."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->module_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Videos Report',$html);


    }
    public function show(Videos $videos)
    {
        
        $tab=Videos::all();return view('admin.pages.videos.videos_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Videos  $videos
     * @return \Illuminate\Http\Response
     */
    public function edit(Videos $videos,$id=0)
    {
        $tab=Videos::find($id);      
        return view('admin.pages.videos.videos_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Videos  $videos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Videos $videos,$id=0)
    {
        $this->validate($request,[
                
                'heading'=>'required',
                'video_link'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Videos","Update","Edit / Modify");

        

        $filename_videos_1=$request->ex_video_image;
        if ($request->hasFile('video_image')) {
            $img_videos = $request->file('video_image');
            $upload_videos = 'upload/videos';
            $filename_videos_1 = env('APP_NAME').'_'.time() . '.' . $img_videos->getClientOriginalExtension();
            $img_videos->move($upload_videos, $filename_videos_1);
        }

                
        $tab=Videos::find($id);
        
        $tab->heading=$request->heading;
        $tab->video_image=$filename_videos_1;
        $tab->video_link=$request->video_link;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('videos')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Videos  $videos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Videos $videos,$id=0)
    {
        $this->SystemAdminLog("Videos","Destroy","Delete");

        $tab=Videos::find($id);
        $tab->delete();
        return redirect('videos')->with('status','Deleted Successfully !');}
}

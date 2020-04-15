<?php

namespace App\Http\Controllers;

use App\YoutubeVideoGallery;
use App\AdminLog;
use Illuminate\Http\Request;

class YoutubeVideoGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Youtube Video Gallery";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tab=YoutubeVideoGallery::all();
        return view('admin.pages.youtubevideogallery.youtubevideogallery_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


                   
        return view('admin.pages.youtubevideogallery.youtubevideogallery_create');
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
                
                'youtube_link_id'=>'required',
        ]);

        $this->SystemAdminLog("Youtube Video Gallery","Save New","Create New");

        
        $tab=new YoutubeVideoGallery();
        
        $tab->youtube_link_id=$request->youtube_link_id;
        $tab->save();

        return redirect('youtubevideogallery')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'youtube_link_id'=>'required',
        ]);

        $tab=new YoutubeVideoGallery();
        
        $tab->youtube_link_id=$request->youtube_link_id;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\YoutubeVideoGallery  $youtubevideogallery
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('youtube_link_id','LIKE','%'.$search.'%');
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
                            $query->orWhere('youtube_link_id','LIKE','%'.$search.'%');
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

    
    public function YoutubeVideoGalleryQuery($request)
    {
        $YoutubeVideoGallery_data=YoutubeVideoGallery::orderBy('id','DESC')->get();

        return $YoutubeVideoGallery_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Youtube Link ID','Created Date');
        array_push($data, $array_column);
        $inv=$this->YoutubeVideoGalleryQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->youtube_link_id,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Youtube Video Gallery Report',
            'report_title'=>'Youtube Video Gallery Report',
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
                            <th class='text-center' style='font-size:12px;' >Youtube Link ID</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->YoutubeVideoGalleryQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->youtube_link_id."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Youtube Video Gallery Report',$html);


    }
    public function show(YoutubeVideoGallery $youtubevideogallery)
    {
        
        $tab=YoutubeVideoGallery::all();return view('admin.pages.youtubevideogallery.youtubevideogallery_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\YoutubeVideoGallery  $youtubevideogallery
     * @return \Illuminate\Http\Response
     */
    public function edit(YoutubeVideoGallery $youtubevideogallery,$id=0)
    {
        $tab=YoutubeVideoGallery::find($id);      
        return view('admin.pages.youtubevideogallery.youtubevideogallery_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\YoutubeVideoGallery  $youtubevideogallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, YoutubeVideoGallery $youtubevideogallery,$id=0)
    {
        $this->validate($request,[
                
                'youtube_link_id'=>'required',
        ]);

        $this->SystemAdminLog("Youtube Video Gallery","Update","Edit / Modify");

        
        $tab=YoutubeVideoGallery::find($id);
        
        $tab->youtube_link_id=$request->youtube_link_id;
        $tab->save();

        return redirect('youtubevideogallery')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\YoutubeVideoGallery  $youtubevideogallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(YoutubeVideoGallery $youtubevideogallery,$id=0)
    {
        $this->SystemAdminLog("Youtube Video Gallery","Destroy","Delete");

        $tab=YoutubeVideoGallery::find($id);
        $tab->delete();
        return redirect('youtubevideogallery')->with('status','Deleted Successfully !');}
}

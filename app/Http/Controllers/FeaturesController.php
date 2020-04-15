<?php

namespace App\Http\Controllers;

use App\Features;
use App\AdminLog;
use Illuminate\Http\Request;

class FeaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Features";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tab=Features::all();
        return view('admin.pages.features.features_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


                   
        return view('admin.pages.features.features_create');
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
                
                'feature_name'=>'required',
                'feature_image'=>'required',
                'feature_status'=>'required',
        ]);

        $this->SystemAdminLog("Features","Save New","Create New");

        

        $filename_features_1='';
        if ($request->hasFile('feature_image')) {
            $img_features = $request->file('feature_image');
            $upload_features = 'upload/features';
            $filename_features_1 = env('APP_NAME').'_'.time() . '.' . $img_features->getClientOriginalExtension();
            $img_features->move($upload_features, $filename_features_1);
        }

                
        $tab=new Features();
        
        $tab->feature_name=$request->feature_name;
        $tab->feature_image=$filename_features_1;
        $tab->feature_status=$request->feature_status;
        $tab->save();

        return redirect('features')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'feature_name'=>'required',
                'feature_image'=>'required',
                'feature_status'=>'required',
        ]);

        $tab=new Features();
        
        $tab->feature_name=$request->feature_name;
        $tab->feature_image=$filename_features_1;
        $tab->feature_status=$request->feature_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Features  $features
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('feature_name','LIKE','%'.$search.'%');
                            $query->orWhere('feature_image','LIKE','%'.$search.'%');
                            $query->orWhere('feature_status','LIKE','%'.$search.'%');
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
                            $query->orWhere('feature_name','LIKE','%'.$search.'%');
                            $query->orWhere('feature_image','LIKE','%'.$search.'%');
                            $query->orWhere('feature_status','LIKE','%'.$search.'%');
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

    
    public function FeaturesQuery($request)
    {
        $Features_data=Features::orderBy('id','DESC')->get();

        return $Features_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Feature Name','Feature Image','Feature Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->FeaturesQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->feature_name,$voi->feature_image,$voi->feature_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Features Report',
            'report_title'=>'Features Report',
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
                            <th class='text-center' style='font-size:12px;' >Feature Name</th>
                        
                            <th class='text-center' style='font-size:12px;' >Feature Image</th>
                        
                            <th class='text-center' style='font-size:12px;' >Feature Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->FeaturesQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->feature_name."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->feature_image."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->feature_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Features Report',$html);


    }
    public function show(Features $features)
    {
        
        $tab=Features::all();return view('admin.pages.features.features_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Features  $features
     * @return \Illuminate\Http\Response
     */
    public function edit(Features $features,$id=0)
    {
        $tab=Features::find($id);      
        return view('admin.pages.features.features_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Features  $features
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Features $features,$id=0)
    {
        $this->validate($request,[
                
                'feature_name'=>'required',
                'feature_status'=>'required',
        ]);

        $this->SystemAdminLog("Features","Update","Edit / Modify");

        

        $filename_features_1=$request->ex_feature_image;
        if ($request->hasFile('feature_image')) {
            $img_features = $request->file('feature_image');
            $upload_features = 'upload/features';
            $filename_features_1 = env('APP_NAME').'_'.time() . '.' . $img_features->getClientOriginalExtension();
            $img_features->move($upload_features, $filename_features_1);
        }

                
        $tab=Features::find($id);
        
        $tab->feature_name=$request->feature_name;
        $tab->feature_image=$filename_features_1;
        $tab->feature_status=$request->feature_status;
        $tab->save();

        return redirect('features')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Features  $features
     * @return \Illuminate\Http\Response
     */
    public function destroy(Features $features,$id=0)
    {
        $this->SystemAdminLog("Features","Destroy","Delete");

        $tab=Features::find($id);
        $tab->delete();
        return redirect('features')->with('status','Deleted Successfully !');}
}

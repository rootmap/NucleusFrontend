<?php

namespace App\Http\Controllers;

use App\PageSetting;
use App\AdminLog;
use Illuminate\Http\Request;
use App\Package;
                

class PageSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Page Setting";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tabCount=PageSetting::count();
        if($tabCount==0)
        {
            return redirect(url('pagesetting/create'));
        }else{

            $tab=PageSetting::orderBy('id','DESC')->first(); 
        $tab_Package=Package::all();     
        return view('admin.pages.pagesetting.pagesetting_edit',['dataRow_Package'=>$tab_Package,'dataRow'=>$tab,'edit'=>true]); 
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        
        $tabCount=PageSetting::count();
        if($tabCount==0)
        { 
        $tab_Package=Package::all();           
        return view('admin.pages.pagesetting.pagesetting_create',['dataRow_Package'=>$tab_Package]);
            
        }else{

            $tab=PageSetting::orderBy('id','DESC')->first(); 
        $tab_Package=Package::all();     
        return view('admin.pages.pagesetting.pagesetting_edit',['dataRow_Package'=>$tab_Package,'dataRow'=>$tab,'edit'=>true]); 
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
                
                'home_feature_title'=>'required',
                'home_intragted_solution'=>'required',
                'default_package'=>'required',
                'business_pos_core_software_title'=>'required',
                'business_pos_core_hardware_title'=>'required',
                'retail_store_key_feature_title'=>'required',
        ]);

        $this->SystemAdminLog("Page Setting","Save New","Create New");

        
        $tab_2_Package=Package::where('id',$request->default_package)->first();
        $default_package_2_Package=$tab_2_Package->title;
        $tab=new PageSetting();
        
        $tab->home_feature_title=$request->home_feature_title;
        $tab->home_intragted_solution=$request->home_intragted_solution;
        $tab->default_package_title=$default_package_2_Package;
        $tab->default_package=$request->default_package;
        $tab->business_pos_core_software_title=$request->business_pos_core_software_title;
        $tab->business_pos_core_software_detail=$request->business_pos_core_software_detail;
        $tab->business_pos_core_hardware_title=$request->business_pos_core_hardware_title;
        $tab->business_pos_core_hardware_detail=$request->business_pos_core_hardware_detail;
        $tab->retail_store_key_feature_title=$request->retail_store_key_feature_title;
        $tab->question_what_makes_better=$request->question_what_makes_better;
        $tab->save();

        return redirect('pagesetting')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'home_feature_title'=>'required',
                'home_intragted_solution'=>'required',
                'default_package'=>'required',
                'business_pos_core_software_title'=>'required',
                'business_pos_core_hardware_title'=>'required',
                'retail_store_key_feature_title'=>'required',
        ]);

        $tab=new PageSetting();
        
        $tab->home_feature_title=$request->home_feature_title;
        $tab->home_intragted_solution=$request->home_intragted_solution;
        $tab->default_package_title=$default_package_2_Package;
        $tab->default_package=$request->default_package;
        $tab->business_pos_core_software_title=$request->business_pos_core_software_title;
        $tab->business_pos_core_hardware_title=$request->business_pos_core_hardware_title;
        $tab->retail_store_key_feature_title=$request->retail_store_key_feature_title;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PageSetting  $pagesetting
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('home_feature_title','LIKE','%'.$search.'%');
                            $query->orWhere('home_intragted_solution','LIKE','%'.$search.'%');
                            $query->orWhere('default_package','LIKE','%'.$search.'%');
                            $query->orWhere('business_pos_core_software_title','LIKE','%'.$search.'%');
                            $query->orWhere('business_pos_core_hardware_title','LIKE','%'.$search.'%');
                            $query->orWhere('retail_store_key_feature_title','LIKE','%'.$search.'%');
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
                            $query->orWhere('home_feature_title','LIKE','%'.$search.'%');
                            $query->orWhere('home_intragted_solution','LIKE','%'.$search.'%');
                            $query->orWhere('default_package','LIKE','%'.$search.'%');
                            $query->orWhere('business_pos_core_software_title','LIKE','%'.$search.'%');
                            $query->orWhere('business_pos_core_hardware_title','LIKE','%'.$search.'%');
                            $query->orWhere('retail_store_key_feature_title','LIKE','%'.$search.'%');
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

    
    public function PageSettingQuery($request)
    {
        $PageSetting_data=PageSetting::orderBy('id','DESC')->get();

        return $PageSetting_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Home Feature Title','Home Intragted Solution','Default Package','Business POS Core Software Title','Business POS Core Hardware Title','Retail Store Key Feature Title','Created Date');
        array_push($data, $array_column);
        $inv=$this->PageSettingQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->home_feature_title,$voi->home_intragted_solution,$voi->default_package,$voi->business_pos_core_software_title,$voi->business_pos_core_hardware_title,$voi->retail_store_key_feature_title,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Page Setting Report',
            'report_title'=>'Page Setting Report',
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
                            <th class='text-center' style='font-size:12px;' >Home Feature Title</th>
                        
                            <th class='text-center' style='font-size:12px;' >Home Intragted Solution</th>
                        
                            <th class='text-center' style='font-size:12px;' >Default Package</th>
                        
                            <th class='text-center' style='font-size:12px;' >Business POS Core Software Title</th>
                        
                            <th class='text-center' style='font-size:12px;' >Business POS Core Hardware Title</th>
                        
                            <th class='text-center' style='font-size:12px;' >Retail Store Key Feature Title</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->PageSettingQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->home_feature_title."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->home_intragted_solution."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->default_package."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->business_pos_core_software_title."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->business_pos_core_hardware_title."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->retail_store_key_feature_title."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Page Setting Report',$html);


    }
    public function show(PageSetting $pagesetting)
    {
        
        $tab=PageSetting::all();return view('admin.pages.pagesetting.pagesetting_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PageSetting  $pagesetting
     * @return \Illuminate\Http\Response
     */
    public function edit(PageSetting $pagesetting,$id=0)
    {
        $tab=PageSetting::find($id); 
        $tab_Package=Package::all();     
        return view('admin.pages.pagesetting.pagesetting_edit',['dataRow_Package'=>$tab_Package,'dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PageSetting  $pagesetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PageSetting $pagesetting,$id=0)
    {
        $this->validate($request,[
                
                'home_feature_title'=>'required',
                'home_intragted_solution'=>'required',
                'default_package'=>'required',
                'business_pos_core_software_title'=>'required',
                'business_pos_core_hardware_title'=>'required',
                'retail_store_key_feature_title'=>'required',
        ]);

        $this->SystemAdminLog("Page Setting","Update","Edit / Modify");

        
        $tab_2_Package=Package::where('id',$request->default_package)->first();
        $default_package_2_Package=$tab_2_Package->title;
        $tab=PageSetting::find($id);
        
        $tab->home_feature_title=$request->home_feature_title;
        $tab->home_intragted_solution=$request->home_intragted_solution;
        $tab->default_package_title=$default_package_2_Package;
        $tab->default_package=$request->default_package;
        $tab->business_pos_core_software_title=$request->business_pos_core_software_title;
        $tab->business_pos_core_software_detail=$request->business_pos_core_software_detail;
        $tab->business_pos_core_hardware_title=$request->business_pos_core_hardware_title;
        $tab->business_pos_core_hardware_detail=$request->business_pos_core_hardware_detail;
        $tab->retail_store_key_feature_title=$request->retail_store_key_feature_title;
        $tab->question_what_makes_better=$request->question_what_makes_better;
        $tab->save();

        return redirect('pagesetting')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PageSetting  $pagesetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(PageSetting $pagesetting,$id=0)
    {
        $this->SystemAdminLog("Page Setting","Destroy","Delete");

        $tab=PageSetting::find($id);
        $tab->delete();
        return redirect('pagesetting')->with('status','Deleted Successfully !');}
}

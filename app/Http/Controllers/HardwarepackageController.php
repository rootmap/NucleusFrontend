<?php

namespace App\Http\Controllers;

use App\HardwarePackage;
use App\AdminLog;
use Illuminate\Http\Request;

class HardwarePackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Hardware Package";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tab=HardwarePackage::all();
        return view('admin.pages.hardwarepackage.hardwarepackage_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


                   
        return view('admin.pages.hardwarepackage.hardwarepackage_create');
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
                
                'title'=>'required',
                'price'=>'required',
                'hardware_image'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Hardware Package","Save New","Create New");

        

        $filename_hardwarepackage_2='';
        if ($request->hasFile('hardware_image')) {
            $img_hardwarepackage = $request->file('hardware_image');
            $upload_hardwarepackage = 'upload/hardwarepackage';
            $filename_hardwarepackage_2 = env('APP_NAME').'_'.time() . '.' . $img_hardwarepackage->getClientOriginalExtension();
            $img_hardwarepackage->move($upload_hardwarepackage, $filename_hardwarepackage_2);
        }

        $newAr = [];

        if (count($request->feature_detail) > 0) {
            foreach ($request->feature_detail as $key => $row) {
                $newAr[] = array('name' => $row, 'status' => $request->feature_status[$key]);
            }
        }

        $hardware_detail = json_encode($newAr);

                
        $tab=new HardwarePackage();
        
        $tab->title=$request->title;
        $tab->price=$request->price;
        $tab->hardware_image=$filename_hardwarepackage_2;
        $tab->hardware_detail= $hardware_detail;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('hardwarepackage')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'title'=>'required',
                'price'=>'required',
                'hardware_image'=>'required',
                'module_status'=>'required',
        ]);

        $tab=new HardwarePackage();
        
        $tab->title=$request->title;
        $tab->price=$request->price;
        $tab->hardware_image=$filename_hardwarepackage_2;
        $tab->hardware_detail=$request->hardware_detail;
        $tab->module_status=$request->module_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HardwarePackage  $hardwarepackage
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('title','LIKE','%'.$search.'%');
                            $query->orWhere('price','LIKE','%'.$search.'%');
                            $query->orWhere('hardware_image','LIKE','%'.$search.'%');
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
                            $query->orWhere('title','LIKE','%'.$search.'%');
                            $query->orWhere('price','LIKE','%'.$search.'%');
                            $query->orWhere('hardware_image','LIKE','%'.$search.'%');
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

    
    public function HardwarePackageQuery($request)
    {
        $HardwarePackage_data=HardwarePackage::orderBy('id','DESC')->get();

        return $HardwarePackage_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Title','Price','Hardware Image','Hardware Detail','Module Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->HardwarePackageQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->title,$voi->price,$voi->hardware_image,$voi->hardware_detail,$voi->module_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Hardware Package Report',
            'report_title'=>'Hardware Package Report',
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
                            <th class='text-center' style='font-size:12px;' >Title</th>
                        
                            <th class='text-center' style='font-size:12px;' >Price</th>
                        
                            <th class='text-center' style='font-size:12px;' >Hardware Image</th>
                        
                            <th class='text-center' style='font-size:12px;' >Hardware Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Module Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->HardwarePackageQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->title."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->price."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->hardware_image."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->hardware_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->module_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Hardware Package Report',$html);


    }
    public function show(HardwarePackage $hardwarepackage)
    {
        
        $tab=HardwarePackage::all();
        return view('admin.pages.hardwarepackage.hardwarepackage_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HardwarePackage  $hardwarepackage
     * @return \Illuminate\Http\Response
     */
    public function edit(HardwarePackage $hardwarepackage,$id=0)
    {
        $tab=HardwarePackage::find($id);      
        return view('admin.pages.hardwarepackage.hardwarepackage_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HardwarePackage  $hardwarepackage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HardwarePackage $hardwarepackage,$id=0)
    {
        $this->validate($request,[
                
                'title'=>'required',
                'price'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Hardware Package","Update","Edit / Modify");

        

        $filename_hardwarepackage_2=$request->ex_hardware_image;
        if ($request->hasFile('hardware_image')) {
            $img_hardwarepackage = $request->file('hardware_image');
            $upload_hardwarepackage = 'upload/hardwarepackage';
            $filename_hardwarepackage_2 = env('APP_NAME').'_'.time() . '.' . $img_hardwarepackage->getClientOriginalExtension();
            $img_hardwarepackage->move($upload_hardwarepackage, $filename_hardwarepackage_2);
        }

        $newAr = [];

        if (count($request->feature_detail) > 0) {
            foreach ($request->feature_detail as $key => $row) {
                $newAr[] = array('name' => $row, 'status' => $request->feature_status[$key]);
            }
        }

        $hardware_detail = json_encode($newAr);
                
        $tab=HardwarePackage::find($id);
        
        $tab->title=$request->title;
        $tab->price=$request->price;
        $tab->hardware_image=$filename_hardwarepackage_2;
        $tab->hardware_detail= $hardware_detail;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('hardwarepackage')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HardwarePackage  $hardwarepackage
     * @return \Illuminate\Http\Response
     */
    public function destroy(HardwarePackage $hardwarepackage,$id=0)
    {
        $this->SystemAdminLog("Hardware Package","Destroy","Delete");

        $tab=HardwarePackage::find($id);
        $tab->delete();
        return redirect('hardwarepackage')->with('status','Deleted Successfully !');}
}

<?php

namespace App\Http\Controllers;

use App\Package;
use App\AdminLog;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Package";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tab=Package::all();
        return view('admin.pages.package.package_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


                   
        return view('admin.pages.package.package_create');
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
                'subscription_type'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Package","Save New","Create New");

        

        $filename_package_3='';
        if ($request->hasFile('package_image')) {
            $img_package = $request->file('package_image');
            $upload_package = 'upload/package';
            $filename_package_3 = env('APP_NAME').'_'.time() . '.' . $img_package->getClientOriginalExtension();
            $img_package->move($upload_package, $filename_package_3);
        }

        

        $newAr=[];

        if(count($request->feature_detail)>0)
        {
            foreach ($request->feature_detail as $key => $row) {
                $newAr[]=array('name'=>$row,'status'=>$request->feature_status[$key]);
            }
        }

        $feature_details=json_encode($newAr);
                
        $tab=new Package();
        
        $tab->title=$request->title;
        $tab->price=$request->price;
        $tab->subscription_type=$request->subscription_type;
        $tab->package_image=$filename_package_3;
        $tab->feature_detail=$feature_details;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('package')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'title'=>'required',
                'price'=>'required',
                'subscription_type'=>'required',
                'feature_detail'=>'required',
                'module_status'=>'required',
        ]);

        $tab=new Package();
        
        $tab->title=$request->title;
        $tab->price=$request->price;
        $tab->subscription_type=$request->subscription_type;
        $tab->package_image=$filename_package_3;
        $tab->feature_detail=$request->feature_detail;
        $tab->module_status=$request->module_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('title','LIKE','%'.$search.'%');
                            $query->orWhere('price','LIKE','%'.$search.'%');
                            $query->orWhere('subscription_type','LIKE','%'.$search.'%');
                            $query->orWhere('package_image','LIKE','%'.$search.'%');
                            $query->orWhere('feature_detail','LIKE','%'.$search.'%');
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
                            $query->orWhere('subscription_type','LIKE','%'.$search.'%');
                            $query->orWhere('package_image','LIKE','%'.$search.'%');
                            $query->orWhere('feature_detail','LIKE','%'.$search.'%');
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

    
    public function PackageQuery($request)
    {
        $Package_data=Package::orderBy('id','DESC')->get();

        return $Package_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Title','Price','Subscription Type','Package Image','Feature Detail','Module Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->PackageQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->title,$voi->price,$voi->subscription_type,$voi->package_image,$voi->feature_detail,$voi->module_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Package Report',
            'report_title'=>'Package Report',
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
                        
                            <th class='text-center' style='font-size:12px;' >Subscription Type</th>
                        
                            <th class='text-center' style='font-size:12px;' >Package Image</th>
                        
                            <th class='text-center' style='font-size:12px;' >Feature Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Module Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->PackageQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->title."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->price."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->subscription_type."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->package_image."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->feature_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->module_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Package Report',$html);


    }
    public function show(Package $package)
    {
        
        $tab=Package::all();return view('admin.pages.package.package_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package,$id=0)
    {
        $tab=Package::find($id);      
        return view('admin.pages.package.package_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package,$id=0)
    {
        $this->validate($request,[
                
                'title'=>'required',
                'price'=>'required',
                'subscription_type'=>'required',
                'feature_detail'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Package","Update","Edit / Modify");

        

        $filename_package_3=$request->ex_package_image;
        if ($request->hasFile('package_image')) {
            $img_package = $request->file('package_image');
            $upload_package = 'upload/package';
            $filename_package_3 = env('APP_NAME').'_'.time() . '.' . $img_package->getClientOriginalExtension();
            $img_package->move($upload_package, $filename_package_3);
        }

        
        $newAr=[];

        if(count($request->feature_detail)>0)
        {
            foreach ($request->feature_detail as $key => $row) {
                $newAr[]=array('name'=>$row,'status'=>$request->feature_status[$key]);
            }
        }

        $feature_details=json_encode($newAr);

                
        $tab=Package::find($id);
        
        $tab->title=$request->title;
        $tab->price=$request->price;
        $tab->subscription_type=$request->subscription_type;
        $tab->package_image=$filename_package_3;
        $tab->feature_detail=$feature_details;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('package')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package,$id=0)
    {
        $this->SystemAdminLog("Package","Destroy","Delete");

        $tab=Package::find($id);
        $tab->delete();
        return redirect('package')->with('status','Deleted Successfully !');}
}

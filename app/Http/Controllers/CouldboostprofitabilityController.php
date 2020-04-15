<?php

namespace App\Http\Controllers;

use App\CouldBoostProfitability;
use App\AdminLog;
use Illuminate\Http\Request;

class CouldBoostProfitabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Could Boost Profitability";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tabCount=CouldBoostProfitability::count();
        if($tabCount==0)
        {
            return redirect(url('couldboostprofitability/create'));
        }else{

            $tab=CouldBoostProfitability::orderBy('id','DESC')->first();      
        return view('admin.pages.couldboostprofitability.couldboostprofitability_edit',['dataRow'=>$tab,'edit'=>true]); 
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        
        $tabCount=CouldBoostProfitability::count();
        if($tabCount==0)
        {            
        return view('admin.pages.couldboostprofitability.couldboostprofitability_create');
            
        }else{

            $tab=CouldBoostProfitability::orderBy('id','DESC')->first();      
        return view('admin.pages.couldboostprofitability.couldboostprofitability_edit',['dataRow'=>$tab,'edit'=>true]); 
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
                'content_image'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Could Boost Profitability","Save New","Create New");

        

        $filename_couldboostprofitability_2='';
        if ($request->hasFile('content_image')) {
            $img_couldboostprofitability = $request->file('content_image');
            $upload_couldboostprofitability = 'upload/couldboostprofitability';
            $filename_couldboostprofitability_2 = env('APP_NAME').'_'.time() . '.' . $img_couldboostprofitability->getClientOriginalExtension();
            $img_couldboostprofitability->move($upload_couldboostprofitability, $filename_couldboostprofitability_2);
        }

                
        $tab=new CouldBoostProfitability();
        
        $tab->heading=$request->heading;
        $tab->detail=$request->detail;
        $tab->content_image=$filename_couldboostprofitability_2;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('couldboostprofitability')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'heading'=>'required',
                'detail'=>'required',
                'content_image'=>'required',
                'module_status'=>'required',
        ]);

        $tab=new CouldBoostProfitability();
        
        $tab->heading=$request->heading;
        $tab->detail=$request->detail;
        $tab->content_image=$filename_couldboostprofitability_2;
        $tab->module_status=$request->module_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CouldBoostProfitability  $couldboostprofitability
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('heading','LIKE','%'.$search.'%');
                            $query->orWhere('detail','LIKE','%'.$search.'%');
                            $query->orWhere('content_image','LIKE','%'.$search.'%');
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
                            $query->orWhere('content_image','LIKE','%'.$search.'%');
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

    
    public function CouldBoostProfitabilityQuery($request)
    {
        $CouldBoostProfitability_data=CouldBoostProfitability::orderBy('id','DESC')->get();

        return $CouldBoostProfitability_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Heading','Detail','Content Image','Module Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->CouldBoostProfitabilityQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->heading,$voi->detail,$voi->content_image,$voi->module_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Could Boost Profitability Report',
            'report_title'=>'Could Boost Profitability Report',
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
                        
                            <th class='text-center' style='font-size:12px;' >Content Image</th>
                        
                            <th class='text-center' style='font-size:12px;' >Module Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->CouldBoostProfitabilityQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->heading."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->content_image."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->module_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Could Boost Profitability Report',$html);


    }
    public function show(CouldBoostProfitability $couldboostprofitability)
    {
        
        $tab=CouldBoostProfitability::all();return view('admin.pages.couldboostprofitability.couldboostprofitability_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CouldBoostProfitability  $couldboostprofitability
     * @return \Illuminate\Http\Response
     */
    public function edit(CouldBoostProfitability $couldboostprofitability,$id=0)
    {
        $tab=CouldBoostProfitability::find($id);      
        return view('admin.pages.couldboostprofitability.couldboostprofitability_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CouldBoostProfitability  $couldboostprofitability
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CouldBoostProfitability $couldboostprofitability,$id=0)
    {
        $this->validate($request,[
                
                'heading'=>'required',
                'detail'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Could Boost Profitability","Update","Edit / Modify");

        

        $filename_couldboostprofitability_2=$request->ex_content_image;
        if ($request->hasFile('content_image')) {
            $img_couldboostprofitability = $request->file('content_image');
            $upload_couldboostprofitability = 'upload/couldboostprofitability';
            $filename_couldboostprofitability_2 = env('APP_NAME').'_'.time() . '.' . $img_couldboostprofitability->getClientOriginalExtension();
            $img_couldboostprofitability->move($upload_couldboostprofitability, $filename_couldboostprofitability_2);
        }

                
        $tab=CouldBoostProfitability::find($id);
        
        $tab->heading=$request->heading;
        $tab->detail=$request->detail;
        $tab->content_image=$filename_couldboostprofitability_2;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('couldboostprofitability')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CouldBoostProfitability  $couldboostprofitability
     * @return \Illuminate\Http\Response
     */
    public function destroy(CouldBoostProfitability $couldboostprofitability,$id=0)
    {
        $this->SystemAdminLog("Could Boost Profitability","Destroy","Delete");

        $tab=CouldBoostProfitability::find($id);
        $tab->delete();
        return redirect('couldboostprofitability')->with('status','Deleted Successfully !');}
}

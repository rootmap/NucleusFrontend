<?php

namespace App\Http\Controllers;

use App\IntragtedSolutions;
use App\AdminLog;
use Illuminate\Http\Request;

class IntragtedSolutionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Intragted Solutions";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tab=IntragtedSolutions::all();
        return view('admin.pages.intragtedsolutions.intragtedsolutions_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


                   
        return view('admin.pages.intragtedsolutions.intragtedsolutions_create');
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
                
                'company_logo'=>'required',
                'sub_title'=>'required',
                'detail'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Intragted Solutions","Save New","Create New");

        

        $filename_intragtedsolutions_0='';
        if ($request->hasFile('company_logo')) {
            $img_intragtedsolutions = $request->file('company_logo');
            $upload_intragtedsolutions = 'upload/intragtedsolutions';
            $filename_intragtedsolutions_0 = env('APP_NAME').'_'.time() . '.' . $img_intragtedsolutions->getClientOriginalExtension();
            $img_intragtedsolutions->move($upload_intragtedsolutions, $filename_intragtedsolutions_0);
        }

                
        $tab=new IntragtedSolutions();
        
        $tab->company_logo=$filename_intragtedsolutions_0;
        $tab->sub_title=$request->sub_title;
        $tab->detail=$request->detail;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('intragtedsolutions')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'company_logo'=>'required',
                'sub_title'=>'required',
                'detail'=>'required',
                'module_status'=>'required',
        ]);

        $tab=new IntragtedSolutions();
        
        $tab->company_logo=$filename_intragtedsolutions_0;
        $tab->sub_title=$request->sub_title;
        $tab->detail=$request->detail;
        $tab->module_status=$request->module_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IntragtedSolutions  $intragtedsolutions
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('company_logo','LIKE','%'.$search.'%');
                            $query->orWhere('sub_title','LIKE','%'.$search.'%');
                            $query->orWhere('detail','LIKE','%'.$search.'%');
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
                            $query->orWhere('company_logo','LIKE','%'.$search.'%');
                            $query->orWhere('sub_title','LIKE','%'.$search.'%');
                            $query->orWhere('detail','LIKE','%'.$search.'%');
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

    
    public function IntragtedSolutionsQuery($request)
    {
        $IntragtedSolutions_data=IntragtedSolutions::orderBy('id','DESC')->get();

        return $IntragtedSolutions_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Company Logo','Sub Title','Detail','Module Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->IntragtedSolutionsQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->company_logo,$voi->sub_title,$voi->detail,$voi->module_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Intragted Solutions Report',
            'report_title'=>'Intragted Solutions Report',
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
                            <th class='text-center' style='font-size:12px;' >Company Logo</th>
                        
                            <th class='text-center' style='font-size:12px;' >Sub Title</th>
                        
                            <th class='text-center' style='font-size:12px;' >Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Module Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->IntragtedSolutionsQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->company_logo."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->sub_title."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->module_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Intragted Solutions Report',$html);


    }
    public function show(IntragtedSolutions $intragtedsolutions)
    {
        
        $tab=IntragtedSolutions::all();return view('admin.pages.intragtedsolutions.intragtedsolutions_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IntragtedSolutions  $intragtedsolutions
     * @return \Illuminate\Http\Response
     */
    public function edit(IntragtedSolutions $intragtedsolutions,$id=0)
    {
        $tab=IntragtedSolutions::find($id);      
        return view('admin.pages.intragtedsolutions.intragtedsolutions_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IntragtedSolutions  $intragtedsolutions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IntragtedSolutions $intragtedsolutions,$id=0)
    {
        $this->validate($request,[
                
                'sub_title'=>'required',
                'detail'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Intragted Solutions","Update","Edit / Modify");

        

        $filename_intragtedsolutions_0=$request->ex_company_logo;
        if ($request->hasFile('company_logo')) {
            $img_intragtedsolutions = $request->file('company_logo');
            $upload_intragtedsolutions = 'upload/intragtedsolutions';
            $filename_intragtedsolutions_0 = env('APP_NAME').'_'.time() . '.' . $img_intragtedsolutions->getClientOriginalExtension();
            $img_intragtedsolutions->move($upload_intragtedsolutions, $filename_intragtedsolutions_0);
        }

                
        $tab=IntragtedSolutions::find($id);
        
        $tab->company_logo=$filename_intragtedsolutions_0;
        $tab->sub_title=$request->sub_title;
        $tab->detail=$request->detail;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('intragtedsolutions')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IntragtedSolutions  $intragtedsolutions
     * @return \Illuminate\Http\Response
     */
    public function destroy(IntragtedSolutions $intragtedsolutions,$id=0)
    {
        $this->SystemAdminLog("Intragted Solutions","Destroy","Delete");

        $tab=IntragtedSolutions::find($id);
        $tab->delete();
        return redirect('intragtedsolutions')->with('status','Deleted Successfully !');}
}

<?php

namespace App\Http\Controllers;

use App\Retail;
use App\AdminLog;
use Illuminate\Http\Request;

class RetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Retail";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tabCount=Retail::count();
        if($tabCount==0)
        {
            return redirect(url('retail/create'));
        }else{

            $tab=Retail::orderBy('id','DESC')->first();      
        return view('admin.pages.retail.retail_edit',['dataRow'=>$tab,'edit'=>true]); 
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        
        $tabCount=Retail::count();
        if($tabCount==0)
        {            
        return view('admin.pages.retail.retail_create');
            
        }else{

            $tab=Retail::orderBy('id','DESC')->first();      
        return view('admin.pages.retail.retail_edit',['dataRow'=>$tab,'edit'=>true]); 
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
                
                'title'=>'required',
                'detail'=>'required',
                'retail_image'=>'required',
                'section_foreground_color'=>'required',
                'section_status'=>'required',
        ]);

        $this->SystemAdminLog("Retail","Save New","Create New");

        

        $filename_retail_2='';
        if ($request->hasFile('retail_image')) {
            $img_retail = $request->file('retail_image');
            $upload_retail = 'upload/retail';
            $filename_retail_2 = env('APP_NAME').'_'.time() . '.' . $img_retail->getClientOriginalExtension();
            $img_retail->move($upload_retail, $filename_retail_2);
        }

                
        $tab=new Retail();
        
        $tab->title=$request->title;
        $tab->detail=$request->detail;
        $tab->retail_image=$filename_retail_2;
        $tab->section_foreground_color=$request->section_foreground_color;
        $tab->section_status=$request->section_status;
        $tab->save();

        return redirect('retail')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'title'=>'required',
                'detail'=>'required',
                'retail_image'=>'required',
                'section_foreground_color'=>'required',
                'section_status'=>'required',
        ]);

        $tab=new Retail();
        
        $tab->title=$request->title;
        $tab->detail=$request->detail;
        $tab->retail_image=$filename_retail_2;
        $tab->section_foreground_color=$request->section_foreground_color;
        $tab->section_status=$request->section_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Retail  $retail
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('title','LIKE','%'.$search.'%');
                            $query->orWhere('detail','LIKE','%'.$search.'%');
                            $query->orWhere('retail_image','LIKE','%'.$search.'%');
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
                            $query->orWhere('title','LIKE','%'.$search.'%');
                            $query->orWhere('detail','LIKE','%'.$search.'%');
                            $query->orWhere('retail_image','LIKE','%'.$search.'%');
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

    
    public function RetailQuery($request)
    {
        $Retail_data=Retail::orderBy('id','DESC')->get();

        return $Retail_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Title','Detail','Retail Image','Section Foreground Color','Section Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->RetailQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->title,$voi->detail,$voi->retail_image,$voi->section_foreground_color,$voi->section_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Retail Report',
            'report_title'=>'Retail Report',
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
                        
                            <th class='text-center' style='font-size:12px;' >Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Retail Image</th>
                        
                            <th class='text-center' style='font-size:12px;' >Section Foreground Color</th>
                        
                            <th class='text-center' style='font-size:12px;' >Section Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->RetailQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->title."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->retail_image."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_foreground_color."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Retail Report',$html);


    }
    public function show(Retail $retail)
    {
        
        $tab=Retail::all();return view('admin.pages.retail.retail_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Retail  $retail
     * @return \Illuminate\Http\Response
     */
    public function edit(Retail $retail,$id=0)
    {
        $tab=Retail::find($id);      
        return view('admin.pages.retail.retail_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Retail  $retail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Retail $retail,$id=0)
    {
        $this->validate($request,[
                
                'title'=>'required',
                'detail'=>'required',
                'section_foreground_color'=>'required',
                'section_status'=>'required',
        ]);

        $this->SystemAdminLog("Retail","Update","Edit / Modify");

        

        $filename_retail_2=$request->ex_retail_image;
        if ($request->hasFile('retail_image')) {
            $img_retail = $request->file('retail_image');
            $upload_retail = 'upload/retail';
            $filename_retail_2 = env('APP_NAME').'_'.time() . '.' . $img_retail->getClientOriginalExtension();
            $img_retail->move($upload_retail, $filename_retail_2);
        }

                
        $tab=Retail::find($id);
        
        $tab->title=$request->title;
        $tab->detail=$request->detail;
        $tab->retail_image=$filename_retail_2;
        $tab->section_foreground_color=$request->section_foreground_color;
        $tab->section_status=$request->section_status;
        $tab->save();

        return redirect('retail')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Retail  $retail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Retail $retail,$id=0)
    {
        $this->SystemAdminLog("Retail","Destroy","Delete");

        $tab=Retail::find($id);
        $tab->delete();
        return redirect('retail')->with('status','Deleted Successfully !');}
}

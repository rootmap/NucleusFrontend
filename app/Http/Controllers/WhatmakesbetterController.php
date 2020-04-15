<?php

namespace App\Http\Controllers;

use App\WhatMakesBetter;
use App\AdminLog;
use Illuminate\Http\Request;

class WhatMakesBetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="What Makes Better";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tab=WhatMakesBetter::all();
        return view('admin.pages.whatmakesbetter.whatmakesbetter_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


                   
        return view('admin.pages.whatmakesbetter.whatmakesbetter_create');
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
                
                'content_image'=>'required',
                'sub_heading'=>'required',
                'content_detail'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("What Makes Better","Save New","Create New");

        

        $filename_whatmakesbetter_0='';
        if ($request->hasFile('content_image')) {
            $img_whatmakesbetter = $request->file('content_image');
            $upload_whatmakesbetter = 'upload/whatmakesbetter';
            $filename_whatmakesbetter_0 = env('APP_NAME').'_'.time() . '.' . $img_whatmakesbetter->getClientOriginalExtension();
            $img_whatmakesbetter->move($upload_whatmakesbetter, $filename_whatmakesbetter_0);
        }

                
        $tab=new WhatMakesBetter();
        
        $tab->content_image=$filename_whatmakesbetter_0;
        $tab->sub_heading=$request->sub_heading;
        $tab->content_detail=$request->content_detail;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('whatmakesbetter')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'content_image'=>'required',
                'sub_heading'=>'required',
                'content_detail'=>'required',
                'module_status'=>'required',
        ]);

        $tab=new WhatMakesBetter();
        
        $tab->content_image=$filename_whatmakesbetter_0;
        $tab->sub_heading=$request->sub_heading;
        $tab->content_detail=$request->content_detail;
        $tab->module_status=$request->module_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WhatMakesBetter  $whatmakesbetter
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('content_image','LIKE','%'.$search.'%');
                            $query->orWhere('sub_heading','LIKE','%'.$search.'%');
                            $query->orWhere('content_detail','LIKE','%'.$search.'%');
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
                            $query->orWhere('content_image','LIKE','%'.$search.'%');
                            $query->orWhere('sub_heading','LIKE','%'.$search.'%');
                            $query->orWhere('content_detail','LIKE','%'.$search.'%');
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

    
    public function WhatMakesBetterQuery($request)
    {
        $WhatMakesBetter_data=WhatMakesBetter::orderBy('id','DESC')->get();

        return $WhatMakesBetter_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Content Image','Sub Heading','Content Detail','Module Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->WhatMakesBetterQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->content_image,$voi->sub_heading,$voi->content_detail,$voi->module_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'What Makes Better Report',
            'report_title'=>'What Makes Better Report',
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
                            <th class='text-center' style='font-size:12px;' >Content Image</th>
                        
                            <th class='text-center' style='font-size:12px;' >Sub Heading</th>
                        
                            <th class='text-center' style='font-size:12px;' >Content Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Module Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->WhatMakesBetterQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->content_image."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->sub_heading."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->content_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->module_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('What Makes Better Report',$html);


    }
    public function show(WhatMakesBetter $whatmakesbetter)
    {
        
        $tab=WhatMakesBetter::all();return view('admin.pages.whatmakesbetter.whatmakesbetter_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WhatMakesBetter  $whatmakesbetter
     * @return \Illuminate\Http\Response
     */
    public function edit(WhatMakesBetter $whatmakesbetter,$id=0)
    {
        $tab=WhatMakesBetter::find($id);      
        return view('admin.pages.whatmakesbetter.whatmakesbetter_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WhatMakesBetter  $whatmakesbetter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WhatMakesBetter $whatmakesbetter,$id=0)
    {
        $this->validate($request,[
                
                'sub_heading'=>'required',
                'content_detail'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("What Makes Better","Update","Edit / Modify");

        

        $filename_whatmakesbetter_0=$request->ex_content_image;
        if ($request->hasFile('content_image')) {
            $img_whatmakesbetter = $request->file('content_image');
            $upload_whatmakesbetter = 'upload/whatmakesbetter';
            $filename_whatmakesbetter_0 = env('APP_NAME').'_'.time() . '.' . $img_whatmakesbetter->getClientOriginalExtension();
            $img_whatmakesbetter->move($upload_whatmakesbetter, $filename_whatmakesbetter_0);
        }

                
        $tab=WhatMakesBetter::find($id);
        
        $tab->content_image=$filename_whatmakesbetter_0;
        $tab->sub_heading=$request->sub_heading;
        $tab->content_detail=$request->content_detail;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('whatmakesbetter')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WhatMakesBetter  $whatmakesbetter
     * @return \Illuminate\Http\Response
     */
    public function destroy(WhatMakesBetter $whatmakesbetter,$id=0)
    {
        $this->SystemAdminLog("What Makes Better","Destroy","Delete");

        $tab=WhatMakesBetter::find($id);
        $tab->delete();
        return redirect('whatmakesbetter')->with('status','Deleted Successfully !');}
}

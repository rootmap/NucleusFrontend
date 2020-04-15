<?php

namespace App\Http\Controllers;

use App\BlogComment;
use App\AdminLog;
use Illuminate\Http\Request;
use App\Blogs;
                

class BlogCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Blog Comment";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tab=BlogComment::all();
        return view('admin.pages.blogcomment.blogcomment_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        
        $tab_Blogs=Blogs::all();           
        return view('admin.pages.blogcomment.blogcomment_create',['dataRow_Blogs'=>$tab_Blogs]);
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
                
                'name'=>'required',
                'email'=>'required',
                'comment'=>'required',
                'blog'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Blog Comment","Save New","Create New");

        
        $tab_4_Blogs=Blogs::where('id',$request->blog)->first();
        $blog_4_Blogs=$tab_4_Blogs->heading;
        $tab=new BlogComment();
        
        $tab->name=$request->name;
        $tab->email=$request->email;
        $tab->website=$request->website;
        $tab->comment=$request->comment;
        $tab->blog_heading=$blog_4_Blogs;
        $tab->blog=$request->blog;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('blogcomment')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'name'=>'required',
                'email'=>'required',
                'comment'=>'required',
                'blog'=>'required',
                'module_status'=>'required',
        ]);

        $tab=new BlogComment();
        
        $tab->name=$request->name;
        $tab->email=$request->email;
        $tab->website=$request->website;
        $tab->comment=$request->comment;
        $tab->blog_heading=$blog_4_Blogs;
        $tab->blog=$request->blog;
        $tab->module_status=$request->module_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BlogComment  $blogcomment
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('name','LIKE','%'.$search.'%');
                            $query->orWhere('email','LIKE','%'.$search.'%');
                            $query->orWhere('website','LIKE','%'.$search.'%');
                            $query->orWhere('comment','LIKE','%'.$search.'%');
                            $query->orWhere('blog','LIKE','%'.$search.'%');
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
                            $query->orWhere('name','LIKE','%'.$search.'%');
                            $query->orWhere('email','LIKE','%'.$search.'%');
                            $query->orWhere('website','LIKE','%'.$search.'%');
                            $query->orWhere('comment','LIKE','%'.$search.'%');
                            $query->orWhere('blog','LIKE','%'.$search.'%');
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

    
    public function BlogCommentQuery($request)
    {
        $BlogComment_data=BlogComment::orderBy('id','DESC')->get();

        return $BlogComment_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Name','Email','Website','Comment','Blog','Module Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->BlogCommentQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->name,$voi->email,$voi->website,$voi->comment,$voi->blog,$voi->module_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Blog Comment Report',
            'report_title'=>'Blog Comment Report',
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
                            <th class='text-center' style='font-size:12px;' >Name</th>
                        
                            <th class='text-center' style='font-size:12px;' >Email</th>
                        
                            <th class='text-center' style='font-size:12px;' >Website</th>
                        
                            <th class='text-center' style='font-size:12px;' >Comment</th>
                        
                            <th class='text-center' style='font-size:12px;' >Blog</th>
                        
                            <th class='text-center' style='font-size:12px;' >Module Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->BlogCommentQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->name."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->email."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->website."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->comment."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->blog."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->module_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Blog Comment Report',$html);


    }
    public function show(BlogComment $blogcomment)
    {
        
        $tab=BlogComment::all();return view('admin.pages.blogcomment.blogcomment_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BlogComment  $blogcomment
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogComment $blogcomment,$id=0)
    {
        $tab=BlogComment::find($id); 
        $tab_Blogs=Blogs::all();     
        return view('admin.pages.blogcomment.blogcomment_edit',['dataRow_Blogs'=>$tab_Blogs,'dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BlogComment  $blogcomment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogComment $blogcomment,$id=0)
    {
        $this->validate($request,[
                
                'name'=>'required',
                'email'=>'required',
                'comment'=>'required',
                'blog'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Blog Comment","Update","Edit / Modify");

        
        $tab_4_Blogs=Blogs::where('id',$request->blog)->first();
        $blog_4_Blogs=$tab_4_Blogs->heading;
        $tab=BlogComment::find($id);
        
        $tab->name=$request->name;
        $tab->email=$request->email;
        $tab->website=$request->website;
        $tab->comment=$request->comment;
        $tab->blog_heading=$blog_4_Blogs;
        $tab->blog=$request->blog;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('blogcomment')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BlogComment  $blogcomment
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogComment $blogcomment,$id=0)
    {
        $this->SystemAdminLog("Blog Comment","Destroy","Delete");

        $tab=BlogComment::find($id);
        $tab->delete();
        return redirect('blogcomment')->with('status','Deleted Successfully !');}
}

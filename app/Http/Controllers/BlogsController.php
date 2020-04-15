<?php

namespace App\Http\Controllers;

use App\Blogs;
use App\AdminLog;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Blogs";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tab=Blogs::all();
        return view('admin.pages.blogs.blogs_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


                   
        return view('admin.pages.blogs.blogs_create');
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

    private function resize_crop_image($max_width, $max_height, $source_file, $dst_dir, $quality = 80){
        $imgsize = getimagesize($source_file);
        $width = $imgsize[0];
        $height = $imgsize[1];
        $mime = $imgsize['mime'];

        switch($mime){
            case 'image/gif':
                $image_create = "imagecreatefromgif";
                $image = "imagegif";
                break;

            case 'image/png':
                $image_create = "imagecreatefrompng";
                $image = "imagepng";
                $quality = 7;
                break;

            case 'image/jpeg':
                $image_create = "imagecreatefromjpeg";
                $image = "imagejpeg";
                $quality = 80;
                break;

            default:
                return false;
                break;
        }

        $dst_img = imagecreatetruecolor($max_width, $max_height);
        $src_img = $image_create($source_file);

        $width_new = $height * $max_width / $max_height;
        $height_new = $width * $max_height / $max_width;
        //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
        if($width_new > $width){
            //cut point by height
            $h_point = (($height - $height_new) / 2);
            //copy image
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
        }else{
            //cut point by width
            $w_point = (($width - $width_new) / 2);
            imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
        }

        $image($dst_img, $dst_dir, $quality);

        if($dst_img)imagedestroy($dst_img);
        if($src_img)imagedestroy($src_img);
    }


    public function store(Request $request)
    {
        $this->validate($request,[
                
                'heading'=>'required',
                'detail'=>'required',
                'blog_primary_image'=>'required',
                'blog_creator_name'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Blogs","Save New","Create New");

        

        $filename_blogs_2='';
        if ($request->hasFile('blog_primary_image')) {
            $img_blogs = $request->file('blog_primary_image');
            $upload_blogs = 'upload/blogs';
            $filename_blogs_2 = env('APP_NAME').'_'.time() . '.' . $img_blogs->getClientOriginalExtension();
            $img_blogs->move($upload_blogs, $filename_blogs_2);
            $this->resize_crop_image(348, 200, $upload_blogs.'/'.$filename_blogs_2, $upload_blogs.'/small/'.$filename_blogs_2);
            $this->resize_crop_image(100,180, $upload_blogs.'/'.$filename_blogs_2, $upload_blogs.'/populer/'.$filename_blogs_2);
        }

        $a = strip_tags($request->detail);
        $short_detail=substr($a,0,155).'...'; 

        $aa = strip_tags($request->heading);
        $aaLink = str_replace(' ','-',$aa);
                
        $tab=new Blogs();
        
        $tab->heading=$request->heading;
        $tab->detail=$request->detail;
        $tab->short_detail=$short_detail;
        $tab->link=$aaLink;
        $tab->blog_primary_image=$filename_blogs_2;
        $tab->blog_creator_name=$request->blog_creator_name;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('blogs')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'heading'=>'required',
                'detail'=>'required',
                'blog_primary_image'=>'required',
                'blog_creator_name'=>'required',
                'module_status'=>'required',
        ]);

        $a = strip_tags($request->detail);
        $short_detail=substr($a,0,167).'...'; 

        $tab=new Blogs();
        
        $tab->heading=$request->heading;
        $tab->detail=$request->detail;
        $tab->short_detail=$short_detail;
        $tab->blog_primary_image=$filename_blogs_2;
        $tab->blog_creator_name=$request->blog_creator_name;
        $tab->module_status=$request->module_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blogs  $blogs
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('heading','LIKE','%'.$search.'%');
                            $query->orWhere('detail','LIKE','%'.$search.'%');
                            $query->orWhere('blog_primary_image','LIKE','%'.$search.'%');
                            $query->orWhere('blog_creator_name','LIKE','%'.$search.'%');
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
                            $query->orWhere('blog_primary_image','LIKE','%'.$search.'%');
                            $query->orWhere('blog_creator_name','LIKE','%'.$search.'%');
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

    
    public function BlogsQuery($request)
    {
        $Blogs_data=Blogs::orderBy('id','DESC')->get();

        return $Blogs_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Heading','Detail','Blog Primary Image','Blog Creator Name','Module Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->BlogsQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->heading,$voi->detail,$voi->blog_primary_image,$voi->blog_creator_name,$voi->module_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Blogs Report',
            'report_title'=>'Blogs Report',
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
                        
                            <th class='text-center' style='font-size:12px;' >Blog Primary Image</th>
                        
                            <th class='text-center' style='font-size:12px;' >Blog Creator Name</th>
                        
                            <th class='text-center' style='font-size:12px;' >Module Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->BlogsQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->heading."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->blog_primary_image."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->blog_creator_name."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->module_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Blogs Report',$html);


    }
    public function show(Blogs $blogs)
    {
        
        $tab=Blogs::all();return view('admin.pages.blogs.blogs_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blogs  $blogs
     * @return \Illuminate\Http\Response
     */
    public function edit(Blogs $blogs,$id=0)
    {
        $tab=Blogs::find($id);      
        return view('admin.pages.blogs.blogs_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blogs  $blogs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blogs $blogs,$id=0)
    {
        $this->validate($request,[
                
                'heading'=>'required',
                'detail'=>'required',
                'blog_creator_name'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Blogs","Update","Edit / Modify");

        //echo strlen('People, I am feeling it. I am feeling that excitement about spring and green things sprouting from the ground and sunshine warming my back in the mornings and bright a'); die();

        $a = strip_tags($request->detail);
        $short_detail=substr($a,0,155).'...'; 
        //die();
        //dd($a);
        
        $aa = strip_tags($request->heading);
        $aaLink = str_replace(' ','-',$aa);

        $filename_blogs_2=$request->ex_blog_primary_image;
        if ($request->hasFile('blog_primary_image')) {
            $img_blogs = $request->file('blog_primary_image');
            $upload_blogs = 'upload/blogs';
            $filename_blogs_2 = env('APP_NAME').'_'.time() . '.' . $img_blogs->getClientOriginalExtension();
            $img_blogs->move($upload_blogs, $filename_blogs_2);
            $this->resize_crop_image(348, 200, $upload_blogs.'/'.$filename_blogs_2, $upload_blogs.'/small/'.$filename_blogs_2);
            $this->resize_crop_image(100,180, $upload_blogs.'/'.$filename_blogs_2, $upload_blogs.'/populer/'.$filename_blogs_2);
        }

                
        $tab=Blogs::find($id);
        
        $tab->heading=$request->heading;
        $tab->detail=$request->detail;
        $tab->short_detail=$short_detail;
        $tab->link=$aaLink;
        $tab->blog_primary_image=$filename_blogs_2;
        $tab->blog_creator_name=$request->blog_creator_name;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('blogs')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blogs  $blogs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blogs $blogs,$id=0)
    {
        $this->SystemAdminLog("Blogs","Destroy","Delete");

        $tab=Blogs::find($id);
        $tab->delete();
        return redirect('blogs')->with('status','Deleted Successfully !');}
}

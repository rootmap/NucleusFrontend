<?php

namespace App\Http\Controllers;

use App\Crud;
use Illuminate\Http\Request;
use DB;
use App\PageName;
class CrudController extends Controller
{
    public function crud()
    {
        $tables = PageName::all();
        return view('admin.pages.crud',['table'=>$tables]);
    }    

    private function GenarateWithLink($fileLink='',$content=''){
        $handle = fopen($fileLink, 'a') or die('Cannot open file:  '.$fileLink);
        $new_data =str_replace("&#36;","$",$content);
        $new_data =str_replace("&#$2$#;","",$new_data);
        fwrite($handle, $new_data);
        fclose($handle);
    }

    private function genarateModelName($data=''){
        $data=str_replace(" ","",$data);
        return $data;
        //page_name
    }

    public static function getPluralPrase($phrase,$value){
        $plural='';
        if($value>1){
            for($i=0;$i<strlen($phrase);$i++){
                if($i==strlen($phrase)-1){
                    $plural.=($phrase[$i]=='y')? 'ies':(($phrase[$i]=='s'|| $phrase[$i]=='x' || $phrase[$i]=='z' || $phrase[$i]=='ch' || $phrase[$i]=='sh')? $phrase[$i].'es' :$phrase[$i].'s');
                }else{
                    $plural.=$phrase[$i];
                }
            }
            return $plural;
        }
        return $phrase;
    }

    private function modelResourceDirectory($modelFileName=''){
        return str_replace(" ","",strtolower($modelFileName));
    }

    private function createDirectoryWithLocation($structure=''){
        if (!mkdir($structure, 0777, true)) {
            die('Failed to create folders...');
        }
        else{
            return true;
        }
    }

    private function genarateFieldName($fieldName=''){
        return str_replace(" ","_",db_esc_like_raw(strtolower($fieldName)));
    }

    private function genrateFormField($request){
        $content='';
        foreach($request->field_name as $key=>$field){

           if($request->field_type[$key]==1)
           {

                $content .='
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="'.$this->genarateFieldName($field).'">'.$field.'</label>
                        <input type="text" class="form-control" placeholder="'.$request->field_name_placeholder[$key].'" id="'.$this->genarateFieldName($field).'" name="'.$this->genarateFieldName($field).'">
                      </div>
                    </div>
                </div>
                ';
           }
           elseif($request->field_type[$key]==2)
           {
                $content .='
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="'.$this->genarateFieldName($field).'">'.$field.'</label>
                        <textarea class="form-control" rows="3"  placeholder="'.$request->field_name_placeholder[$key].'" id="'.$this->genarateFieldName($field).'" name="'.$this->genarateFieldName($field).'"></textarea>
                      </div>
                    </div>
                </div>
                ';
           }
           elseif($request->field_type[$key]==3)
           {
                $content .=$this->genarateStaticCheckbox($this->genarateFieldName($field),$request,$key);
           }
           elseif($request->field_type[$key]==4)
           {
                $content .=$this->genarateStaticRadioButton($this->genarateFieldName($field),$request,$key);
           }
           elseif($request->field_type[$key]==5)
           {

                if($request->field_table[$key]==1){

                    $content .='
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>'.$request->field_name_placeholder[$key].'</label>
                                  <select class="form-control select2" style="width: 100%;"  id="'.$this->genarateFieldName($field).'" name="'.$this->genarateFieldName($field).'">
                                    '.$this->genarateStaticDropDown($request->field_option[$key]).'
                                  </select>
                                </div>
                            </div>
                        </div>
                    ';
                }
                else{

                    $content .='
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>'.$request->field_name_placeholder[$key].'</label>
                                  <select class="form-control select2" style="width: 100%;"  id="'.$this->genarateFieldName($field).'" name="'.$this->genarateFieldName($field).'">';
                    $content .='
                                        <option value="">Please Select</option>
                                        @if(isset(&#36;dataRow_'.$request->field_table[$key].'))    
                                            @if(count(&#36;dataRow_'.$request->field_table[$key].')>0)
                                                @foreach(&#36;dataRow_'.$request->field_table[$key].' as &#36;'.$request->field_table[$key].')
                                                    ';
                                            $datExplodeField=explode(",",$request->field_option[$key]);        
                                            $content .='<option value="{{&#36;'.$request->field_table[$key].'->'.$datExplodeField[0].'}}">{{&#36;'.$request->field_table[$key].'->'.$datExplodeField[1].'}}</option>
                                            ';
                                            $content .='        
                                                @endforeach
                                            @endif
                                        @endif 
                                        ';
                    $content .='
                                  </select>
                                </div>
                            </div>
                        </div>
                    ';                  
                }

                
           }
           elseif($request->field_type[$key]==6)
           {
                $content .='
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>'.$request->field_name_placeholder[$key].'</label>
                                    <!-- <label for="customFile">'.$request->field_name_placeholder[$key].'</label> -->

                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input"  id="'.$this->genarateFieldName($field).'" name="'.$this->genarateFieldName($field).'">
                                      <label class="custom-file-label" for="customFile">'.$request->field_name_placeholder[$key].'</label>
                                    </div>
                                </div>
                            </div>
                        </div>';
           }
           elseif($request->field_type[$key]==7)
           {
                $content .='
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>'.$request->field_name_placeholder[$key].'</label>
                                    <!-- <label for="customFile">'.$request->field_name_placeholder[$key].'</label> -->

                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input"  id="'.$this->genarateFieldName($field).'" name="'.$this->genarateFieldName($field).'">
                                      <label class="custom-file-label" for="customFile">'.$request->field_name_placeholder[$key].'</label>
                                    </div>
                                </div>
                            </div>
                        </div>';
           }
            
        }


        return $content;
    }

    private function genrateEditFormField($request,$data){
        $content='';
        foreach($request->field_name as $key=>$field){

           if($request->field_type[$key]==1)
           {
                $content .='
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="'.$this->genarateFieldName($field).'">'.$field.'</label>
                        <input type="text" 
                        ';

                        $content .='    
                        <?php 
                        if(isset(&#36;dataRow->'.$this->genarateFieldName($field).')){
                            ?>
                            value="{{&#36;dataRow->'.$this->genarateFieldName($field).'}}" 
                            <?php 
                        }
                        ?>
                        ';

                        $content .='
                        class="form-control" placeholder="'.$request->field_name_placeholder[$key].'" id="'.$this->genarateFieldName($field).'" name="'.$this->genarateFieldName($field).'">
                      </div>
                    </div>
                </div>
                ';
           }
           elseif($request->field_type[$key]==2)
           {
                $content .='
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="'.$this->genarateFieldName($field).'">'.$field.'</label>
                        <textarea class="form-control" rows="3"  placeholder="'.$request->field_name_placeholder[$key].'" id="'.$this->genarateFieldName($field).'" name="'.$this->genarateFieldName($field).'">';
                                    $content .='<?php 
                                if(isset(&#36;dataRow->'.$this->genarateFieldName($field).')){
                                    
                                    echo &#36;dataRow->'.$this->genarateFieldName($field).';
                                    
                                }
                                ?>';
                                $content .='</textarea>
                      </div>
                    </div>
                </div>
                ';
           }
           elseif($request->field_type[$key]==3)
           {
                $content .=$this->genarateStaticCheckbox($this->genarateFieldName($field),$request,$key,$data);
           }
           elseif($request->field_type[$key]==4)
           {
                $content .=$this->genarateStaticRadioButton($this->genarateFieldName($field),$request,$key,$data);
           }
           elseif($request->field_type[$key]==5)
           {

                if($request->field_table[$key]==1){
                    $content .='
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>'.$request->field_name_placeholder[$key].'</label>
                                  <select class="form-control select2" style="width: 100%;"  id="'.$this->genarateFieldName($field).'" name="'.$this->genarateFieldName($field).'">
                                    '.$this->genarateStaticDropDown($request->field_option[$key],$data,$this->genarateFieldName($field)).'
                                  </select>
                                </div>
                            </div>
                        </div>
                    ';
                }
                else{

                    $content .='
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>'.$request->field_name_placeholder[$key].'</label>
                                  <select class="form-control select2" style="width: 100%;"  id="'.$this->genarateFieldName($field).'" name="'.$this->genarateFieldName($field).'">
                                    ';
                                        $content .='
                                        <option value="">Please Select</option>
                                        @if(count(&#36;dataRow_'.$request->field_table[$key].')>0)
                                            @foreach(&#36;dataRow_'.$request->field_table[$key].' as &#36;'.$request->field_table[$key].')
                                                ';
                                        $datExplodeField=explode(",",$request->field_option[$key]);        
                                        $content .='<option 
                                        @if(isset(&#36;dataRow->'.$datExplodeField[0].'))
                                            @if(&#36;dataRow->'.$datExplodeField[0].'==&#36;'.$request->field_table[$key].'->'.$datExplodeField[0].')
                                                selected="selected" 
                                            @endif
                                        @endif 
                                         value="{{&#36;'.$request->field_table[$key].'->'.$datExplodeField[0].'}}">{{&#36;'.$request->field_table[$key].'->'.$datExplodeField[1].'}}</option>
                                        ';
                                        $content .='        
                                            @endforeach
                                        @endif
                                        ';

                                        $content .='
                                  </select>
                                </div>
                            </div>
                        </div>
                    ';                 
                }

                
           }
           elseif($request->field_type[$key]==6)
           {
                $imgEncodeURL="'upload/".strtolower($this->genarateModelName($request->page_name))."/'.&#36;dataRow->".$this->genarateFieldName($field);
                $content .='
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>'.$request->field_name_placeholder[$key].'</label>
                                    <!-- <label for="customFile">'.$request->field_name_placeholder[$key].'</label> -->
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input"  id="'.$this->genarateFieldName($field).'" name="'.$this->genarateFieldName($field).'">
                                      <input type="hidden" value="{{&#36;dataRow->'.$this->genarateFieldName($field).'}}" name="ex_'.$this->genarateFieldName($field).'" />
                                      <label class="custom-file-label" for="customFile">'.$request->field_name_placeholder[$key].'</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if(isset(&#36;dataRow->'.$this->genarateFieldName($field).'))
                                    @if(!empty(&#36;dataRow->'.$this->genarateFieldName($field).'))
                                        <img class="img-thumbnail" src="{{url('.$imgEncodeURL.')}}" width="150">
                                    @endif
                                @endif
                            </div>
                        </div>';

           }
           elseif($request->field_type[$key]==7)
           {
                $imgEncodeURL="'upload/".strtolower($this->genarateModelName($request->page_name))."/'.&#36;dataRow->".$this->genarateFieldName($field);
                $content .='
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>'.$request->field_name_placeholder[$key].'</label>
                                    <!-- <label for="customFile">'.$request->field_name_placeholder[$key].'</label> -->
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input"  id="'.$this->genarateFieldName($field).'" name="'.$this->genarateFieldName($field).'">
                                      <input type="hidden" value="{{&#36;dataRow->'.$this->genarateFieldName($field).'}}" name="ex_'.$this->genarateFieldName($field).'" />
                                      <label class="custom-file-label" for="customFile">'.$request->field_name_placeholder[$key].'</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <a href="{{url('.$imgEncodeURL.')}}" class="btn btn-primary">
                                    <i class="fas fa-download"></i> 
                                    Download / Open File
                                </a>
                            </div>
                        </div>';
           }
            
            
        }


        return $content;
    }

    private function genarateStaticDropDown($param='',$datafill='',$filedName=''){
        $content='
        <option value="">Please select</option>';
        $checkBoxArray=explode(",",$param);
        foreach ($checkBoxArray as $key => $value) {
            $content .='
            <option ';


                if(!empty($datafill)){
                    $content .='
                    <?php 
                    if(&#36;dataRow->'.$filedName.'=="'.trim($value).'"){
                        ?>
                        selected="selected" 
                        <?php 
                    }
                    ?> ';
                }


$content .='
            value="'.trim($value).'">'.$value.'</option>';
        }

        //echo $datafill; die();

        return $content;
    }

    private function genarateStaticCheckbox($filedName,$request,$key,$datafill=''){
        $content='';

        $placeholder=$request->field_name_placeholder[$key];
        $param=$request->field_option[$key];
        $checkBoxArray=explode(",",$param);

        $content.='
        <div class="row">
            <div class="col-sm-12">
              <!-- checkbox -->
              <div class="form-group">
              <label>'.$placeholder.'</label>
        ';

        foreach ($checkBoxArray as $key => $value) {
                $content .='
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" ';
                            if(!empty($datafill)){
                $content .=' 
                                <?php 
                                if(&#36;dataRow->'.$filedName.'=="'.trim($value).'"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>';
                            }
                $content .='
                          id="'.$filedName.'_'.$key.'" name="'.$filedName.'" value="'.trim($value).'">
                          <label class="form-check-label">'.$value.'</label>
                        </div>
                ';
        }

        $content .='
                    </div>
                </div>
            </div>
            ';

        return $content;
    }


    private function genarateStaticRadioButton($filedName,$request,$key,$datafill=''){
        $content='';

        $placeholder=$request->field_name_placeholder[$key];
        $param=$request->field_option[$key];
        $checkBoxArray=explode(",",$param);

        $content.='
        <div class="row">
            <div class="col-sm-12">
              <!-- radio -->
              <div class="form-group">
              <label>'.$placeholder.'</label>
        ';

        foreach ($checkBoxArray as $key => $value) {
                $content .='
                        <div class="form-check">
                            <input class="form-check-input" type="radio" ';
                            if(!empty($datafill)){
                $content .=' 
                                <?php 
                                if(&#36;dataRow->'.$filedName.'=="'.trim($value).'"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>';
                            }
                $content .='
                          id="'.$filedName.'_'.$key.'" name="'.$filedName.'" value="'.trim($value).'">
                          <label class="form-check-label">'.$value.'</label>
                        </div>
                ';
        }

        $content .='
                    </div>
                </div>
            </div>
            ';

        return $content;
    }


    private function CoreRouteResource($page_route){
        $routePath = __DIR__."/../../../routes/web.php";
        $routeContent='';
        $routeContent .="\n//======================== ".ucfirst($page_route)." Route Start ===============================//";
        $routeContent .="\nRoute::get('/".$page_route."/list','".ucfirst($page_route)."Controller@show');";
        $routeContent .="\nRoute::get('/".$page_route."/create','".ucfirst($page_route)."Controller@create');";
        $routeContent .="\nRoute::get('/".$page_route."/edit/{id}','".ucfirst($page_route)."Controller@edit');";
        $routeContent .="\nRoute::get('/".$page_route."/delete/{id}','".ucfirst($page_route)."Controller@destroy');";
        $routeContent .="\nRoute::get('/".$page_route."','".ucfirst($page_route)."Controller@index');";
        $routeContent .="\nRoute::get('/".$page_route."/export/excel','".ucfirst($page_route)."Controller@ExportExcel');";
        $routeContent .="\nRoute::get('/".$page_route."/export/pdf','".ucfirst($page_route)."Controller@ExportPDF');";

        $routeContent .="\nRoute::post('/".$page_route."','".ucfirst($page_route)."Controller@store');";
        $routeContent .="\nRoute::post('/".$page_route."/ajax','".ucfirst($page_route)."Controller@ajaxSave');";
        $routeContent .="\nRoute::post('/".$page_route."/datatable/ajax','".ucfirst($page_route)."Controller@datatable');";
        $routeContent .="\nRoute::post('/".$page_route."/update/{id}','".ucfirst($page_route)."Controller@update');";
        $routeContent .="\n//======================== ".ucfirst($page_route)." Route End ===============================//";
        $this->GenarateWithLink($routePath,$routeContent);

    }

    private function CoreModelResource($modelFileName,$getMigrationTable,$request){


        $migFileName=str_replace(" ","_",$request->page_name);
        $getMigrationTableFile=$this->getPluralPrase(strtolower($migFileName),strlen($migFileName));

        $modelContent='';
        $modelContent .="<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ".$modelFileName." extends Model
{
    use SoftDeletes;
    protected &#36;dates = ['deleted_at'];
    protected &#36;table='".$getMigrationTableFile."';
}
        ";

        $modelPathFile = __DIR__."/../../".$modelFileName.".php";

        $this->GenarateWithLink($modelPathFile,$modelContent);
    }

    private function CoreControllerResource($modelFileName,$controllerPathFile,$request){
        $controllerContent='';
        $controllerContent .='<?php

namespace App\Http\Controllers;

use App\&#$2$#;'.$modelFileName.';
use App\&#$2$#;AdminLog;
use Illuminate\Http\Request;';

foreach($request->field_name as $key=>$field){
    if(isset($request->field_type[$key]))
    {
        if($request->field_type[$key]==5){
            if($request->field_table[$key]!=1){
                //echo 22; die();
                //echo $request->field_table[$key];
                $controllerContent .='
use App\&#$2$#;'.$request->field_table[$key].';
                ';
            }

            //echo 1; die();
            
        }
    }
}

$controllerContent .='

class '.$modelFileName.'Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private &#36;moduleName="'.$request->page_name.'";
    private &#36;sdc;
    public function __construct(){ &#36;this->sdc = new CoreCustomController(); }
    
    public function index(){';

        

        if($request->page_type=="Single"){

            $createPageRoute=$request->page_route."/create";

            $controllerContent .="
        &#36;tabCount=".$modelFileName."::count();
        if(&#36;tabCount==0)
        {
            return redirect(url('".$createPageRoute."'));
        }else{

            &#36;tab=".$modelFileName."::orderBy('id','DESC')->first(); ";

            $perseDataConcat="";
        $perseDataConcatParam="";
        foreach($request->field_name as $key=>$field){
            if(isset($request->field_type[$key]))
            {
                if($request->field_type[$key]==5){
                    if($request->field_table[$key]!=1){

                        $controllerContent .="
        &#36;tab_".$request->field_table[$key]."=".$request->field_table[$key]."::all();";
                        if(!empty($perseDataConcatParam)){
                            $perseDataConcatParam .=",'dataRow_".$request->field_table[$key]."'=>&#36;tab_".$request->field_table[$key]."";
                        }
                        else
                        {
                            $perseDataConcatParam .="'dataRow_".$request->field_table[$key]."'=>&#36;tab_".$request->field_table[$key]."";
                        }
                        
                    }
                    
                }
            }
        }

        if(!empty($perseDataConcatParam)){
            $perseDataConcat=",[".$perseDataConcatParam.",'dataRow'=>&#36;tab,'edit'=>true]";
        }
        else{
            $perseDataConcat=",['dataRow'=>&#36;tab,'edit'=>true]";
        }

    $controllerContent .="     
        return view('admin.pages.".$this->modelResourceDirectory($modelFileName).".".$this->modelResourceDirectory($modelFileName)."_edit'".$perseDataConcat."); ";

        $controllerContent .="
        }
        ";

        


        }else{
            $controllerContent .="
        &#36;tab=".$modelFileName."::all();";

            $controllerContent .="
        return view('admin.pages.".$this->modelResourceDirectory($modelFileName).".".$this->modelResourceDirectory($modelFileName)."_list',['dataRow'=>&#36;tab]);";
        }


        
        
     $controllerContent .='
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        ';


        if($request->page_type=="Single"){

            $createPageRoute=$request->page_route."/create";

            $controllerContent .="
        &#36;tabCount=".$modelFileName."::count();
        if(&#36;tabCount==0)
        { ";

        $perseDataConcat="";
        $perseDataConcatParam="";

        $contentValidation="";


        foreach($request->field_name as $key=>$field){

            //$field=$_POST['field_validation_'.($key+1)];

            if(isset($_POST['field_validation_'.($key+1)]))
            {
                    $contentValidation .="
                '".$this->genarateFieldName($field)."'=>'required',";
            }

        }

        foreach($request->field_name as $key=>$field){
            if(isset($request->field_type[$key]))
            {
                if($request->field_type[$key]==5){
                    if($request->field_table[$key]!=1){

                        $controllerContent .="
        &#36;tab_".$request->field_table[$key]."=".$request->field_table[$key]."::all();";
                        if(!empty($perseDataConcatParam)){
                            $perseDataConcatParam .=",'dataRow_".$request->field_table[$key]."'=>&#36;tab_".$request->field_table[$key]."";
                        }
                        else
                        {
                            $perseDataConcatParam .="'dataRow_".$request->field_table[$key]."'=>&#36;tab_".$request->field_table[$key]."";
                        }
                        
                    }
                    
                }
            }
        }

        if(!empty($perseDataConcatParam)){
            $perseDataConcat=",[".$perseDataConcatParam."]";
        }


        $storeSuccess="return redirect('".strtolower($modelFileName)."')->with('status','Added Successfully !');";
        $storeUpdateSuccess="return redirect('".strtolower($modelFileName)."')->with('status','Updated Successfully !');";

    $controllerContent .="           
        return view('admin.pages.".$this->modelResourceDirectory($modelFileName).".".$this->modelResourceDirectory($modelFileName)."_create'".$perseDataConcat.");";


        $controllerContent .="
            
        }else{

            &#36;tab=".$modelFileName."::orderBy('id','DESC')->first(); ";

            $perseDataConcat="";
        $perseDataConcatParam="";
        foreach($request->field_name as $key=>$field){
            if(isset($request->field_type[$key]))
            {
                if($request->field_type[$key]==5){
                    if($request->field_table[$key]!=1){

                        $controllerContent .="
        &#36;tab_".$request->field_table[$key]."=".$request->field_table[$key]."::all();";
                        if(!empty($perseDataConcatParam)){
                            $perseDataConcatParam .=",'dataRow_".$request->field_table[$key]."'=>&#36;tab_".$request->field_table[$key]."";
                        }
                        else
                        {
                            $perseDataConcatParam .="'dataRow_".$request->field_table[$key]."'=>&#36;tab_".$request->field_table[$key]."";
                        }
                        
                    }
                    
                }
            }
        }

        if(!empty($perseDataConcatParam)){
            $perseDataConcat=",[".$perseDataConcatParam.",'dataRow'=>&#36;tab,'edit'=>true]";
        }
        else{
            $perseDataConcat=",['dataRow'=>&#36;tab,'edit'=>true]";
        }

    $controllerContent .="     
        return view('admin.pages.".$this->modelResourceDirectory($modelFileName).".".$this->modelResourceDirectory($modelFileName)."_edit'".$perseDataConcat."); ";

        $controllerContent .="
        }
        ";

    }else{

        $perseDataConcat="";
        $perseDataConcatParam="";

        $contentValidation="";


        foreach($request->field_name as $key=>$field){

            //$field=$_POST['field_validation_'.($key+1)];

            if(isset($_POST['field_validation_'.($key+1)]))
            {
                    $contentValidation .="
                '".$this->genarateFieldName($field)."'=>'required',";
            }

        }

        foreach($request->field_name as $key=>$field){
            if(isset($request->field_type[$key]))
            {
                if($request->field_type[$key]==5){
                    if($request->field_table[$key]!=1){

                        $controllerContent .="
        &#36;tab_".$request->field_table[$key]."=".$request->field_table[$key]."::all();";
                        if(!empty($perseDataConcatParam)){
                            $perseDataConcatParam .=",'dataRow_".$request->field_table[$key]."'=>&#36;tab_".$request->field_table[$key]."";
                        }
                        else
                        {
                            $perseDataConcatParam .="'dataRow_".$request->field_table[$key]."'=>&#36;tab_".$request->field_table[$key]."";
                        }
                        
                    }
                    
                }
            }
        }

        if(!empty($perseDataConcatParam)){
            $perseDataConcat=",[".$perseDataConcatParam."]";
        }


        $storeSuccess="return redirect('".strtolower($modelFileName)."')->with('status','Added Successfully !');";
        $storeUpdateSuccess="return redirect('".strtolower($modelFileName)."')->with('status','Updated Successfully !');";

    $controllerContent .="           
        return view('admin.pages.".$this->modelResourceDirectory($modelFileName).".".$this->modelResourceDirectory($modelFileName)."_create'".$perseDataConcat.");";

    }


    $controllerContent .='
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  &#36;request
     * @return \Illuminate\Http\Response
     */

    private function SystemAdminLog(&#36;module_name="",&#36;action="",&#36;details=""){
        &#36;tab=new AdminLog();
        &#36;tab->module_name=&#36;module_name;
        &#36;tab->action=&#36;action;
        &#36;tab->details=&#36;details;
        &#36;tab->admin_id=&#36;this->sdc->admin_id();
        &#36;tab->admin_name=&#36;this->sdc->UserName();
        &#36;tab->save();
    }


    public function store(Request &#36;request)
    {
        &#36;this->validate(&#36;request,[
                '.$contentValidation.'
        ]);

        &#36;this->SystemAdminLog("'.$request->page_name.'","Save New","Create New");

        ';


    
        $contentSaveString="";
        foreach($request->field_name as $key=>$field){       

            if($request->field_type[$key]=="6" || $request->field_type[$key]=="7"){

                $controllerContent .="

        &#36;filename_".strtolower($modelFileName)."_".$key."='';
        if (&#36;request->hasFile('".$this->genarateFieldName($field)."')) {
            &#36;img_".strtolower($modelFileName)." = &#36;request->file('".$this->genarateFieldName($field)."');
            &#36;upload_".strtolower($modelFileName)." = 'upload/".strtolower($modelFileName)."';
            &#36;filename_".strtolower($modelFileName)."_".$key." = env('APP_NAME').'_'.time() . '.' . &#36;img_".strtolower($modelFileName)."->getClientOriginalExtension();
            &#36;img_".strtolower($modelFileName)."->move(&#36;upload_".strtolower($modelFileName).", &#36;filename_".strtolower($modelFileName)."_".$key.");
        }

                ";


                $contentSaveString .="
        &#36;tab->".$this->genarateFieldName($field)."=&#36;filename_".strtolower($modelFileName)."_".$key.";";
            }
            elseif($request->field_type[$key]==5 && $request->field_table[$key]!=1){
                $controllerContent .="
        &#36;tab_".$key."_".$request->field_table[$key]."=".$request->field_table[$key]."::where('id',&#36;request->".$this->genarateFieldName($field).")->first();";

                $keyParam=$request->field_option[$key];
                $dataParam=explode(',',$request->field_option[$key]);
                if(count($dataParam)>1)
                {
                    $keyParam=$dataParam[1];
                }

                $controllerContent .="
        &#36;".$this->genarateFieldName($field)."_".$key."_".$request->field_table[$key]."=&#36;tab_".$key."_".$request->field_table[$key]."->".$keyParam.";";

                $contentSaveString .="
        &#36;tab->".$this->genarateFieldName($field)."_".$keyParam."=&#36;".$this->genarateFieldName($field)."_".$key."_".$request->field_table[$key].";";
                $contentSaveString .="
        &#36;tab->".$this->genarateFieldName($field)."=&#36;request->".$this->genarateFieldName($field).";";
            }
            else{
                $contentSaveString .="
        &#36;tab->".$this->genarateFieldName($field)."=&#36;request->".$this->genarateFieldName($field).";";
            }

            
        }

        

        $controllerContent .='
        &#36;tab=new '.$modelFileName.'();
        '.$contentSaveString.'
        &#36;tab->save();

        '.$storeSuccess.'

    }

    public function ajax(Request &#36;request)
    {
        &#36;this->validate(&#36;request,[
                '.$contentValidation.'
        ]);

        &#36;tab=new '.$modelFileName.'();
        '.$contentSaveString.'
        &#36;tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\&#$2$#;'.$modelFileName.'  &#36;'.strtolower($modelFileName).'
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount(&#36;search=""){';
        $controllerContent .="

        &#36;tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',&#36;this->sdc->storeID())->orderBy('id','DESC')
                     ->when(&#36;search, function (&#36;query) use (&#36;search) {
                        &#36;query->where('id','LIKE','%'.&#36;search.'%');";
                        foreach($request->field_name as $key=>$field){                         
                            $controllerContent .="
                            &#36;query->orWhere('".$this->genarateFieldName($field)."','LIKE','%'.&#36;search.'%');";
                        }


                        $controllerContent .="
                            &#36;query->orWhere('created_at','LIKE','%'.&#36;search.'%');

                        return &#36;query;
                     })
                     ->count();
        return &#36;tab;
    }


    private function methodToGetMembers(&#36;start, &#36;length,&#36;search=''){";
        $controllerContent .="

        &#36;tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',&#36;this->sdc->storeID())->orderBy('id','DESC')
                     ->when(&#36;search, function (&#36;query) use (&#36;search) {
                        &#36;query->where('id','LIKE','%'.&#36;search.'%');";
                        foreach($request->field_name as $key=>$field){                         
                            $controllerContent .="
                            &#36;query->orWhere('".$this->genarateFieldName($field)."','LIKE','%'.&#36;search.'%');";
                        }


                        $controllerContent .="
                            &#36;query->orWhere('created_at','LIKE','%'.&#36;search.'%');

                        return &#36;query;
                     })
                     ->skip(&#36;start)->take(&#36;length)->get();
        return &#36;tab;
    }";

    $controllerContent .="

    public function datatable(Request &#36;request){

        &#36;draw = &#36;request->get('draw');
        &#36;start = &#36;request->get('start');
        &#36;length = &#36;request->get('length');
        &#36;search = &#36;request->get('search');

        &#36;search = (isset(&#36;search['value']))? &#36;search['value'] : '';

        &#36;total_members = &#36;this->methodToGetMembersCount(&#36;search); // get your total no of data;
        &#36;members = &#36;this->methodToGetMembers(&#36;start, &#36;length,&#36;search); //supply start and length of the table data

        &#36;data = array(
            'draw' => &#36;draw,
            'recordsTotal' => &#36;total_members,
            'recordsFiltered' => &#36;total_members,
            'data' => &#36;members,
        );

        echo json_encode(&#36;data);

    }

    ";


    $controllerContent .="
    public function ".$modelFileName."Query(&#36;request)
    {
        &#36;".$modelFileName."_data=".$modelFileName."::orderBy('id','DESC')->get();

        return &#36;".$modelFileName."_data;
    }
    ";

    $dataDateTimeIns="'d-M-Y H:i:s a'";

    $controllerContent .="
   

    public function ExportExcel(Request &#36;request) 
    {
         &#36;dataDateTimeIns=formatDateTime(date(".$dataDateTimeIns."));
        &#36;data=array();
        &#36;array_column=array(
                                'ID',";

                                foreach($request->field_name as $key=>$field){       
                                        $controllerContent .="'".$field."',";
                                }

                                $controllerContent .="'Created Date');
        array_push(&#36;data, &#36;array_column);
        &#36;inv=&#36;this->".$modelFileName."Query(&#36;request);
        foreach(&#36;inv as &#36;voi):
            &#36;inv_arry=array(
                                &#36;voi->id,";
                                foreach($request->field_name as $key=>$field){ 
                                    $controllerContent .="&#36;voi->".$this->genarateFieldName($field).",";
                                }

                                

                                $controllerContent .="formatDate(&#36;voi->created_at));
            array_push(&#36;data, &#36;inv_arry);
        endforeach;

        &#36;excelArray=array(
            'report_name'=>'".$request->page_name." Report',
            'report_title'=>'".$request->page_name." Report',
            'report_description'=>'Report Genarated : '.&#36;dataDateTimeIns,
            'data'=>&#36;data
        );

        &#36;this->sdc->ExcelLayout(&#36;excelArray);
        
    }

    public function ExportPDF(Request &#36;request)
    {";

    $dataPullComma='"';

    $controllerContent .="

        &#36;html=".$dataPullComma."<table class='table table-bordered' style='width:100%;'>
                <thead>
                <tr>
                <th class='text-center' style='font-size:12px;'>ID</th>";

                foreach($request->field_name as $key=>$field){       
                        $controllerContent .="
                            <th class='text-center' style='font-size:12px;' >".$field."</th>
                        ";
                }

                $controllerContent .="
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>".$dataPullComma.";

                    &#36;inv=&#36;this->".$modelFileName."Query(&#36;request);
                    foreach(&#36;inv as &#36;voi):
                        &#36;html .=".$dataPullComma."<tr>
                        <td style='font-size:12px;' class='text-center'>".$dataPullComma.".&#36;voi->id.".$dataPullComma."</td>";

                        foreach($request->field_name as $key=>$field){ 
                            $controllerContent .="
                        <td style='font-size:12px;' class='text-center'>".$dataPullComma.".&#36;voi->".$this->genarateFieldName($field).".".$dataPullComma."</td>";
                        }
                        $controllerContent .="
                        <td style='font-size:12px; text-align:center;' class='text-center'>".$dataPullComma.".formatDate(&#36;voi->created_at).".$dataPullComma."</td>
                        </tr>".$dataPullComma.";

                    endforeach;


                &#36;html .=".$dataPullComma."</tbody>
                
                </table>


                ".$dataPullComma.";

                &#36;this->sdc->PDFLayout('".$request->page_name." Report',&#36;html);


    }";




    $controllerContent .='
    public function show('.$modelFileName.' &#36;'.strtolower($modelFileName).')
    {
        ';


        $controllerContent .="
        &#36;tab=".$modelFileName."::all();";


        $controllerContent .="return view('admin.pages.".$this->modelResourceDirectory($modelFileName).".".$this->modelResourceDirectory($modelFileName)."_list',['dataRow'=>&#36;tab]);";
    $controllerContent .='
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\&#$2$#;'.$modelFileName.'  &#36;'.strtolower($modelFileName).'
     * @return \Illuminate\Http\Response
     */
    public function edit('.$modelFileName.' &#36;'.strtolower($modelFileName).',&#36;id=0)
    {
        &#36;tab='.$modelFileName.'::find(&#36;id); ';
        $perseDataConcat="";
        $perseDataConcatParam="";
        foreach($request->field_name as $key=>$field){
            if(isset($request->field_type[$key]))
            {
                if($request->field_type[$key]==5){
                    if($request->field_table[$key]!=1){

                        $controllerContent .="
        &#36;tab_".$request->field_table[$key]."=".$request->field_table[$key]."::all();";
                        if(!empty($perseDataConcatParam)){
                            $perseDataConcatParam .=",'dataRow_".$request->field_table[$key]."'=>&#36;tab_".$request->field_table[$key]."";
                        }
                        else
                        {
                            $perseDataConcatParam .="'dataRow_".$request->field_table[$key]."'=>&#36;tab_".$request->field_table[$key]."";
                        }
                        
                    }
                    
                }
            }
        }

        if(!empty($perseDataConcatParam)){
            $perseDataConcat=",[".$perseDataConcatParam.",'dataRow'=>&#36;tab,'edit'=>true]";
        }
        else{
            $perseDataConcat=",['dataRow'=>&#36;tab,'edit'=>true]";
        }

    $controllerContent .="     
        return view('admin.pages.".$this->modelResourceDirectory($modelFileName).".".$this->modelResourceDirectory($modelFileName)."_edit'".$perseDataConcat."); ";




    $contentValidation="";
    foreach($request->field_name as $key=>$field){
        if($request->field_type[$key]=="6" || $request->field_type[$key]=="7"){
            
        }
        else
        {

            if(isset($_POST['field_validation_'.($key+1)]))
            {
                    $contentValidation .="
                '".$this->genarateFieldName($field)."'=>'required',";
            }

            /*if(isset($request->field_validation[$key]))
            {
                if($request->field_validation[$key]=="on"){
                    $contentValidation .="
                '".$this->genarateFieldName($field)."'=>'required',";
                }
            }*/
        }
    }

    $controllerContent .=' 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  &#36;request
     * @param  \App\&#$2$#;'.$modelFileName.'  &#36;'.strtolower($modelFileName).'
     * @return \Illuminate\Http\Response
     */
    public function update(Request &#36;request, '.$modelFileName.' &#36;'.strtolower($modelFileName).',&#36;id=0)
    {
        &#36;this->validate(&#36;request,[
                '.$contentValidation.'
        ]);

        &#36;this->SystemAdminLog("'.$request->page_name.'","Update","Edit / Modify");

        ';

        $contentSaveString="";
        foreach($request->field_name as $key=>$field){       

            if($request->field_type[$key]=="6" || $request->field_type[$key]=="7"){

                $controllerContent .="

        &#36;filename_".strtolower($modelFileName)."_".$key."=&#36;request->ex_".$this->genarateFieldName($field).";
        if (&#36;request->hasFile('".$this->genarateFieldName($field)."')) {
            &#36;img_".strtolower($modelFileName)." = &#36;request->file('".$this->genarateFieldName($field)."');
            &#36;upload_".strtolower($modelFileName)." = 'upload/".strtolower($modelFileName)."';
            &#36;filename_".strtolower($modelFileName)."_".$key." = env('APP_NAME').'_'.time() . '.' . &#36;img_".strtolower($modelFileName)."->getClientOriginalExtension();
            &#36;img_".strtolower($modelFileName)."->move(&#36;upload_".strtolower($modelFileName).", &#36;filename_".strtolower($modelFileName)."_".$key.");
        }

                ";


                $contentSaveString .="
        &#36;tab->".$this->genarateFieldName($field)."=&#36;filename_".strtolower($modelFileName)."_".$key.";";
            }
            elseif($request->field_type[$key]==5 && $request->field_table[$key]!=1){
                $controllerContent .="
        &#36;tab_".$key."_".$request->field_table[$key]."=".$request->field_table[$key]."::where('id',&#36;request->".$this->genarateFieldName($field).")->first();";

                $keyParam=$request->field_option[$key];
                $dataParam=explode(',',$request->field_option[$key]);
                if(count($dataParam)>1)
                {
                    $keyParam=$dataParam[1];
                }

                $controllerContent .="
        &#36;".$this->genarateFieldName($field)."_".$key."_".$request->field_table[$key]."=&#36;tab_".$key."_".$request->field_table[$key]."->".$keyParam.";";

                $contentSaveString .="
        &#36;tab->".$this->genarateFieldName($field)."_".$keyParam."=&#36;".$this->genarateFieldName($field)."_".$key."_".$request->field_table[$key].";";
                $contentSaveString .="
        &#36;tab->".$this->genarateFieldName($field)."=&#36;request->".$this->genarateFieldName($field).";";
            }
            else{
                $contentSaveString .="
        &#36;tab->".$this->genarateFieldName($field)."=&#36;request->".$this->genarateFieldName($field).";";
            }

            
        }


        $controllerContent .='
        &#36;tab='.$modelFileName.'::find(&#36;id);
        '.$contentSaveString.'
        &#36;tab->save();

        '.$storeUpdateSuccess.'
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\&#$2$#;'.$modelFileName.'  &#36;'.strtolower($modelFileName).'
     * @return \Illuminate\Http\Response
     */
    public function destroy('.$modelFileName.' &#36;'.strtolower($modelFileName).',&#36;id=0)
    {
        &#36;this->SystemAdminLog("'.$request->page_name.'","Destroy","Delete");

        &#36;tab='.$modelFileName.'::find(&#36;id);
        &#36;tab->delete();
        ';
        $controllerContent .="return redirect('".strtolower($modelFileName)."')->with('status','Deleted Successfully !');";
        
    $controllerContent .='}
}
';

        $this->GenarateWithLink($controllerPathFile,$controllerContent);
    }

    private function CoreCreateViewFileResource($modelFileName,$page_route,$request){
        $createfilename=$this->modelResourceDirectory($modelFileName)."_create.blade.php";
        $resourceViewPath_create = __DIR__."/../../../resources/views/admin/pages/".$this->modelResourceDirectory($modelFileName)."/".$createfilename;


        $postCreate="'".$page_route."'";
        $listRoute="'".$page_route."/list'";
        $excelDataRoute="'".$page_route."/export/excel'";
        $pdfDataRoute="'".$page_route."/export/pdf'";
        $CreateDataRoute="'".$page_route."/create'";
        $res_create_content='';
        $res_create_content.='
@extends("admin.layout.master")
@section("title","Create New '.$request->page_name.'")
@section("content")
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>'.$request->page_name.'</h1>
      </div>
      <div class="col-sm-6">';

        if($request->page_type=="Single"){
            $res_create_content .='
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Create New '.$request->page_name.'</li>
            </ol>';

        }
        else
        {
            $res_create_content .='
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('.$listRoute.')}}">'.$request->page_name.' Data</a></li>
              <li class="breadcrumb-item active">Create New '.$request->page_name.'</li>
            </ol>';

        }

$res_create_content .='
      </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @include("admin.include.msg")
        </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<section>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-8 offset-2">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Create New '.$request->page_name.'</h3>';
if($request->page_type!="Single"){
$res_create_content.='
            <div class="card-tools">
              <ul class="pagination pagination-sm float-right">
                <li class="page-item"><a class="page-link bg-primary" href="{{url('.$listRoute.')}}"> Data <i class="fas fa-table"></i></a></li>
                <li class="page-item">
                  <a class="page-link  bg-primary" target="_blank" href="{{url('.$pdfDataRoute.')}}">
                    <i class="fas fa-file-pdf" data-toggle="tooltip" data-html="true"title="Pdf"></i>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link  bg-primary" target="_blank" href="{{url('.$excelDataRoute.')}}">
                    <i class="fas fa-file-excel" data-toggle="tooltip" data-html="true"title="Excel"></i>
                  </a>
                </li>
              </ul>
            </div>';
}
$res_create_content.='            
        </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="{{url('.$postCreate.')}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          
            <div class="card-body">
                '.$this->genrateFormField($request).'       
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
              <a class="btn btn-danger" href="{{url('.$CreateDataRoute.')}}"><i class="far fa-times-circle"></i> Reset</a>
            </div>
          </form>
        </div>
        <!-- /.card -->

      </div>
      <!--/.col (left) -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
@endsection';


$selectTwoCssResource="'admin/plugins/select2/css/select2.min.css'";
$selectTwoJssResource="'admin/plugins/select2/js/select2.full.min.js'";
$fileUploadShowJssResource="'admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js'";

//$res_create_content .=
$resourceArray=array(
    'select_css'=>0,
    'select_js'=>0,
    'fileupload'=>0
);

$pageCSsFooterContent='';
if(count($request->field_name)>0)
{
    foreach($request->field_name as $key=>$field){
       if($request->field_type[$key]==5){
            
            if(empty($pageCSsFooterContent)){
                    $pageCSsFooterContent .='
@section("css")
    ';
            }

            if($resourceArray['select_css']==0)
            {
                    $pageCSsFooterContent .='
    <link rel="stylesheet" href="{{url('.$selectTwoCssResource.')}}">
    ';
                $resourceArray['select_css']=1;
            }
            
       }

    }

    if(!empty($pageCSsFooterContent))
    {
        $pageCSsFooterContent .='
@endsection
        ';
    }    
}


$pageJssFooterContent='';
if(count($request->field_name)>0)
{
    foreach($request->field_name as $key=>$field){
       if($request->field_type[$key]==5){
            if(empty($pageJssFooterContent)){
                $pageJssFooterContent .='
@section("js")
';
            }

            if($resourceArray['select_js']==0)
            {
                $pageJssFooterContent .='
    <script src="{{url('.$selectTwoJssResource.')}}"></script>
    <script>
    $(document).ready(function(){
        $(".select2").select2();
    });
    </script>
';
                $resourceArray['select_js']=1;
            }

       }
       elseif(in_array($request->field_type[$key],array(6,7))){
            if(empty($pageJssFooterContent)){
                $pageJssFooterContent .='
@section("js")
';
            }

            if($resourceArray['fileupload']==0)
            {
                $pageJssFooterContent .='
    <script src="{{url('.$fileUploadShowJssResource.')}}"></script>
    <script>
    $(document).ready(function(){
        bsCustomFileInput.init();
    });
    </script>
';
                $resourceArray['fileupload']=1;
            }

       }
    }
   

    if(!empty($pageJssFooterContent))
    {
        $pageJssFooterContent .='
@endsection
        ';
    }
}

$res_create_content .=$pageCSsFooterContent;
$res_create_content .=$pageJssFooterContent;


        $this->GenarateWithLink($resourceViewPath_create,$res_create_content);
    }

    private function CoreEditViewFileResource($modelFileName,$page_route,$request){
        $createfilename=$this->modelResourceDirectory($modelFileName)."_edit.blade.php";
        $resourceViewPath_create = __DIR__."/../../../resources/views/admin/pages/".$this->modelResourceDirectory($modelFileName)."/".$createfilename;


        $postCreate="'".$page_route."/update/'.&#36;dataRow->id";
        $res_create_content='';
        $listRoute="'".$page_route."/list'";
        $excelDataRoute="'".$page_route."/export/excel'";
        $pdfDataRoute="'".$page_route."/export/pdf'";
        $CreateDataRoute="'".$page_route."/create'";
        $edturl="'".strtolower($modelFileName)."/edit/'.&#36;dataRow->id";

        $res_create_content.='
@extends("admin.layout.master")
@section("title","Edit '.$request->page_name.'")
@section("content")
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>'.$request->page_name.'</h1>
      </div>
      <div class="col-sm-6">';

        if($request->page_type=="Single"){
            $res_create_content .='
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Update '.$request->page_name.'</li>
            </ol>';
        }
        else
        {
            $res_create_content .='
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('.$listRoute.')}}">Datatable </a></li>
              <li class="breadcrumb-item"><a href="{{url('.$CreateDataRoute.')}}">Create New </a></li>
              <li class="breadcrumb-item active">Edit / Modify</li>
            </ol>';
        }
        
$res_create_content .='
      </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @include("admin.include.msg")
        </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<section>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-8 offset-2">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Edit / Modify '.$request->page_name.'</h3>';

if($request->page_type!="Single"){

  $res_create_content.='
            <div class="card-tools">
              <ul class="pagination pagination-sm float-right">
                <li class="page-item">
                    <a class="page-link bg-primary" href="{{url('.$CreateDataRoute.')}}"> 
                        Create 
                        <i class="fas fa-plus"></i>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link bg-primary" href="{{url('.$listRoute.')}}"> 
                        Data 
                        <i class="fas fa-table"></i>
                    </a>
                </li>
                <li class="page-item">
                  <a class="page-link  bg-primary" target="_blank" href="{{url('.$pdfDataRoute.')}}">
                    <i class="fas fa-file-pdf" data-toggle="tooltip" data-html="true"title="Pdf"></i>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link  bg-primary" target="_blank" href="{{url('.$excelDataRoute.')}}">
                    <i class="fas fa-file-excel" data-toggle="tooltip" data-html="true"title="Excel"></i>
                  </a>
                </li>
              </ul>
            </div>';
            
}
$res_create_content.='
        </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="{{url('.$postCreate.')}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          
            <div class="card-body">
                '.$this->genrateEditFormField($request,1).'       
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> 
                Update
              </button>
              <a class="btn btn-danger" href="{{url('.$edturl.')}}">
                <i class="far fa-times-circle"></i> 
                Reset
              </a>
            </div>
          </form>
        </div>
        <!-- /.card -->

      </div>
      <!--/.col (left) -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
@endsection';


$selectTwoCssResource="'admin/plugins/select2/css/select2.min.css'";
$selectTwoJssResource="'admin/plugins/select2/js/select2.full.min.js'";
$fileUploadShowJssResource="'admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js'";


$resourceEditArray=array(
    'select_css'=>0,
    'select_js'=>0,
    'fileupload'=>0
);

$pageCSsFooterContent='';
if(count($request->field_name)>0)
{
    foreach($request->field_name as $key=>$field){
       if($request->field_type[$key]==5){
            
            if(empty($pageCSsFooterContent)){
                    $pageCSsFooterContent .='
@section("css")
    ';
            }

            if($resourceEditArray['select_css']==0)
            {
                    $pageCSsFooterContent .='
    <link rel="stylesheet" href="{{url('.$selectTwoCssResource.')}}">
    ';
                $resourceEditArray['select_css']=1;
            }
            
       }

    }

    if(!empty($pageCSsFooterContent))
    {
        $pageCSsFooterContent .='
@endsection
        ';
    }    
}


$pageJssFooterContent='';
if(count($request->field_name)>0)
{
    foreach($request->field_name as $key=>$field){
       if($request->field_type[$key]==5){
            if(empty($pageJssFooterContent)){
                $pageJssFooterContent .='
@section("js")
';
            }

            if($resourceEditArray['select_js']==0)
            {
                $pageJssFooterContent .='
    <script src="{{url('.$selectTwoJssResource.')}}"></script>
    <script>
    $(document).ready(function(){
        $(".select2").select2();
    });
    </script>
';
                $resourceEditArray['select_js']=1;
            }

       }
       elseif(in_array($request->field_type[$key],array(6,7))){
            if(empty($pageJssFooterContent)){
                $pageJssFooterContent .='
@section("js")
';
            }

            if($resourceEditArray['fileupload']==0)
            {
                $pageJssFooterContent .='
    <script src="{{url('.$fileUploadShowJssResource.')}}"></script>
    <script>
    $(document).ready(function(){
        bsCustomFileInput.init();
    });
    </script>
';
                $resourceEditArray['fileupload']=1;
            }

       }
    }
   

    if(!empty($pageJssFooterContent))
    {
        $pageJssFooterContent .='
@endsection
        ';
    }
}

$res_create_content .=$pageCSsFooterContent;
$res_create_content .=$pageJssFooterContent;

        $this->GenarateWithLink($resourceViewPath_create,$res_create_content);
    }

    private function CoreListViewFileResource($modelFileName,$page_route,$request){
        $createfilename=$this->modelResourceDirectory($modelFileName)."_list.blade.php";
        $resourceViewPath_create = __DIR__."/../../../resources/views/admin/pages/".$this->modelResourceDirectory($modelFileName)."/".$createfilename;


        $postCreate="'".$page_route."'";
        $res_create_content='';
        $listRoute="'".$page_route."/list'";
        $CreateDataRoute="'".$page_route."/create'";
        $excelDataRoute="'".$page_route."/export/excel'";
        $pdfDataRoute="'".$page_route."/export/pdf'";


        $res_create_content .='
@extends("admin.layout.master")
@section("title","'.$request->page_name.'")
@section("content")
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>'.$request->page_name.'</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{url('.$CreateDataRoute.')}}">Create New </a></li>
                  <li class="breadcrumb-item active">'.$request->page_name.' Data</li>
                </ol>
              </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @include("admin.include.msg")
                </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>
        
        <section class="content">
          <div class="row">
            <div class="col-12">
              <!-- /.card -->
              <div class="card">

                <div class="card-header">
                  <h3 class="card-title">'.$request->page_name.' Data</h3>

                    <div class="card-tools">
                      <ul class="pagination pagination-sm float-right">
                        <li class="page-item">
                            <a class="page-link bg-primary" href="{{url('.$CreateDataRoute.')}}"> 
                                Add New 
                                <i class="fas fa-plus"></i> 
                            </a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" target="_blank" href="{{url('.$pdfDataRoute.')}}">
                            <i class="fas fa-file-pdf" data-toggle="tooltip" data-html="true"title="Pdf"></i>
                          </a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" target="_blank" href="{{url('.$excelDataRoute.')}}">
                            <i class="fas fa-file-excel" data-toggle="tooltip" data-html="true"title="Excel"></i>
                          </a>
                        </li>
                      </ul>
                    </div>
                </div>


                
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>';
                                                $keyPlus=1;
                                    foreach($request->field_name as $key=>$field){       
                                        $fieldCHeckName="field_data_table_".$keyPlus;
                                                if(isset($_POST[$fieldCHeckName]))
                                                {

            if($request->field_type[$key]==5 && $request->field_table[$key]!=1){

                $keyParam=$request->field_option[$key];
                $dataParam=explode(',',$request->field_option[$key]);
                if(count($dataParam)>1)
                {
                    $keyParam=$dataParam[1];
                }

                $res_create_content .='
                            <th class="text-center">'.ucfirst($field).' '.ucfirst($keyParam).'</th>';

            }
            else
            {
                $res_create_content .='
                            <th class="text-center">'.$field.'</th>';
            }

                    


                                                }
                                        

                                                $keyPlus++;
                                    }
                                    
                    $res_create_content .='
                            <th class="text-center">Created At</th>
                            <th class="text-center">Actions</th>

                        </tr>
                    </thead>
                    <tbody>';
                    $res_create_content .='
                        @if(count(&#36;dataRow))
                            @foreach(&#36;dataRow as $row)  
                                <tr>';
                    $res_create_content .='
                                    <td class="text-center">{{&#36;row->id}}</td>';
                                    $keyPlus=1;
                                    foreach($request->field_name as $key=>$field){ 
                                        $fieldCHeckName="field_data_table_".$keyPlus;
                                        if(isset($_POST[$fieldCHeckName]))
                                        {
            if($request->field_type[$key]==5 && $request->field_table[$key]!=1){

                                            $keyParam=$request->field_option[$key];
                                            $dataParam=explode(',',$request->field_option[$key]);
                                            if(count($dataParam)>1)
                                            {
                                                $keyParam=$dataParam[1];
                                            }

                                            $res_create_content .='<td class="text-center">{{&#36;row->'.$this->genarateFieldName($field).'_'.$keyParam.'}}</td>';

            }
            else
            {
                                            $res_create_content .='<td class="text-center">{{&#36;row->'.$this->genarateFieldName($field).'}}</td>';
            }
                                        }
                                        $keyPlus++;
                                    }

                                    $edturl="'".strtolower($modelFileName)."/edit/'.&#36;row->id";
                                    $dlturl="'".strtolower($modelFileName)."/delete/'.&#36;row->id";
                    $res_create_content .='
                                    <td>{{formatDate(&#36;row->created_at)}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{url('.$edturl.')}}" type="button" class="btn btn-default">
                                                Edit 
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{url('.$dlturl.')}}" type="button" class="btn btn-default">
                                                Delete 
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                ';

                    $res_create_content .='
                                </tr>
                            @endforeach
                        @endif
                                        ';  
                                        
                    $res_create_content .='
                    </tbody>
                    <tfoot>
                    <tr>
                        <th class="text-center">ID</th>';
                                                $keyPlus=1;
                                    foreach($request->field_name as $key=>$field){       
                                        $fieldCHeckName="field_data_table_".$keyPlus;
                                                if(isset($_POST[$fieldCHeckName]))
                                                {

            if($request->field_type[$key]==5 && $request->field_table[$key]!=1){

                        $keyParam=$request->field_option[$key];
                        $dataParam=explode(',',$request->field_option[$key]);
                        if(count($dataParam)>1)
                        {
                            $keyParam=$dataParam[1];
                        }

                        $res_create_content .='
                        <th class="text-center">'.ucfirst($field).' '.ucfirst($keyParam).'</th>';

            }
            else
            {
                        $res_create_content .='
                        <th class="text-center">'.$field.'</th>';
            }
                                                }
                                        

                                                $keyPlus++;
                                    }
                                    
                        $res_create_content .='
                        <th class="text-center">Created At</th>
                        <th class="text-center">Actions</th>

                    </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </section>
@endsection
@section("css")
    @include("admin.include.lib.datatable.css")
@endsection

@section("js")
    @include("admin.include.lib.datatable.js")
@endsection
        ';

        
        $this->GenarateWithLink($resourceViewPath_create,$res_create_content);
    }

    private function CoreMigrationFileResource($request){

        $resourceMigPath_create = __DIR__."/../../../database/migrations/";

        $migFileName=str_replace(" ","_",$request->page_name);
        $getMigrationTableFile=$this->getPluralPrase(strtolower($migFileName),strlen($migFileName));

        $migFileClassName=str_replace(" ","",$request->page_name);
        $getMigrationTableFileCLass=$this->getPluralPrase($migFileClassName,strlen($migFileClassName));

        //echo $getMigrationTableFileCLass; die();
        $slashes=date('Y_m_d_his')."_create_".$getMigrationTableFile."_table";

        $finalMigrationFIle=$resourceMigPath_create."".$slashes.".php";


        $migContent="";
        $migContent .="<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create".$getMigrationTableFileCLass."Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('".$getMigrationTableFile."', function (Blueprint &#36;table) {
            &#36;table->increments('id');";

foreach($request->field_name as $key=>$field){     
    if($request->field_type[$key]==5 && $request->field_table[$key]!=1){

                $keyParam=$request->field_option[$key];
                $dataParam=explode(',',$request->field_option[$key]);
                if(count($dataParam)>1)
                {
                    $keyParam=$dataParam[1];
                }

        $migContent .="
            &#36;table->integer('".$this->genarateFieldName($field)."');";  

        $migContent .="
            &#36;table->string('".$this->genarateFieldName($field)."_".$keyParam."');";      

    }
    else
    {  
        $migContent .="
            &#36;table->string('".$this->genarateFieldName($field)."');";    
    }
}

$migContent .="
            &#36;table->integer('store_id');
            &#36;table->integer('created_by');
            &#36;table->integer('updated_by');
            
            &#36;table->softDeletes();
            &#36;table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('".$getMigrationTableFile."');
    }
}
";
        \DB::statement("INSERT INTO page_names (name,db_table,route_link,page_type) values ('".$migFileClassName."','".$getMigrationTableFile."','".$request->page_route."','".$request->page_type."')");
        $sqlCheckMax=\DB::table('migrations')->orderBy('batch','DESC')->first();
        \DB::statement("INSERT INTO migrations (migration,batch) values ('".$slashes."','".($sqlCheckMax->batch+1)."')");

        $laraTableDB="CREATE TABLE `".$getMigrationTableFile."` (
            `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,";
        foreach($request->field_name as $key=>$field){ 

    if($request->field_type[$key]==5 && $request->field_table[$key]!=1){

                $keyParam=$request->field_option[$key];
                $dataParam=explode(',',$request->field_option[$key]);
                if(count($dataParam)>1)
                {
                    $keyParam=$dataParam[1];
                }

        $laraTableDB .="
                `".$this->genarateFieldName($field)."` INT(11) NULL  DEFAULT 0 COLLATE 'utf8mb4_unicode_ci',";

        $laraTableDB .="
                `".$this->genarateFieldName($field)."_".$keyParam."` VARCHAR(191) NULL  DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',";    

    }
    else
    {      
                $laraTableDB .="
                `".$this->genarateFieldName($field)."` VARCHAR(191) NULL  DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',";
    }    
        }
            
        $laraTableDB.="    
            `store_id` INT(11) NULL DEFAULT NULL,
            `created_by` INT(11) NULL DEFAULT NULL,
            `updated_by` INT(11) NULL DEFAULT NULL,
            `deleted_at` TIMESTAMP NULL DEFAULT NULL,
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
        )
        COLLATE='utf8mb4_unicode_ci'
        ENGINE=InnoDB
        ;
        ";

        \DB::statement($laraTableDB);

        $this->GenarateWithLink($finalMigrationFIle,$migContent);
    }

    public function crudgenarate(Request $request)
    {

        //dd($request);

        $logPath = __DIR__;


        //Route Genaration Start
        $this->CoreRouteResource($request->page_route);
        //Route Genaration End

        //Model Genaration Start
        $modelFileName=$this->genarateModelName($request->page_name);
        $getMigrationTable=$this->getPluralPrase(strtolower($modelFileName),strlen($modelFileName));
        $this->CoreModelResource($modelFileName,$getMigrationTable,$request);
        //Model Genaration End


        //Controller Genaration Start
        $controllerPath = __DIR__."/";
        $controllerPathFile = __DIR__."/".ucfirst($request->page_route)."Controller.php";
        $this->CoreControllerResource($modelFileName,$controllerPathFile,$request);
        //Controller Genaration End

        //Resource Directory Genaration Start
        $resourcePath = __DIR__."/../../../resources/views/admin/pages/".$this->modelResourceDirectory($modelFileName);
        if($this->createDirectoryWithLocation($resourcePath))
        //Resource Directory Genaration End


        //Resource Create View Genaration Start
        $this->CoreCreateViewFileResource($modelFileName,$request->page_route,$request);
        $this->CoreEditViewFileResource($modelFileName,$request->page_route,$request);
        $this->CoreListViewFileResource($modelFileName,$request->page_route,$request);
        //Resource Create View Genaration End
        
        //Migration Create Genaration Start
        $this->CoreMigrationFileResource($request);
        //Migration Create Genaration End

        //dd($request);
        //echo $routePath; die();
        return redirect(url($request->page_route))->with('status',$request->page_name.' created successfully.');
    }
}

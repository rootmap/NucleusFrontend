@extends("admin.layout.index")
@section("title","Blank Form Page")
@section("page-name","Blank Form Page")
@section("content")
                <form action="page_forms_general.html" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onsubmit="return false;">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="example-text-input">Text Input</label>
                        <div class="col-md-9">
                            <input type="text" id="example-text-input" name="example-text-input" class="form-control" placeholder="Text">
                            <span class="help-block">This is a help text</span>
                        </div>
                    </div>
                    
                    <div class="form-group form-actions">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Submit</button>
                            <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                        </div>
                    </div>
                </form>
@endsection
@extends('admin.layout.master')
@section('title','CRUD Form Page')
@section('content')

        <div class="content add-details">
                <div class="in-content-wrapper">
                    <div class="box">
                        <div class="hotel-listing-form">
                            <form class="text-left">
                                <div class="form-row">
                                    <div class="col">
                                        <div class="details-text">
                                            <h4>CRUD Engine</h4>
                                        </div><!-- end details-text -->
                                    </div><!-- End column -->
                                    <div class="col-md-6">
                                        <div class="breadcrumb">
                                            <div class="breadcrumb-item"><i class="fas fa-angle-right"></i><a href="#">CRUD Listing</a>
                                            </div>
                                            <div class="breadcrumb-item active"><i class="fas fa-angle-right"></i>Create New Feature
                                            </div>
                                        </div><!-- end breadcrumb -->
                                    </div><!-- End column -->
                                </div><!-- end row -->
                            </form>
                        </div>


                        <div class="hotel-listing-form">
                            <form class="text-center" action="{{route('crudgenarate')}}" method="post">
                                {{csrf_field()}}
                                <div class="form-row">
                                    <div class="col-md ml-3">
                                        <div class="form-group">
                                            <label for="inputGroupSelect07" class="">Module:</label>
                                            <input type="text" name="page_name" class="form-control" required id="page_name">
                                        </div><!-- end form-group -->
                                    </div><!-- end column -->
                                    <div class="col-md mr-4">
                                        <div class="form-group">
                                            <label for="inputGroupSelect07" class="">Route:</label>
                                            <input type="text" readonly="readonly" class="form-control" name="page_route" required id="page_route">
                                        </div><!-- end form-group -->
                                    </div><!-- end column -->                                    
                                    <div class="col-md mr-4">
                                        <div class="form-group">
                                            <label for="inputGroupSelect07" class="">Type:</label>
                                            <select name="page_type" class="form-control">
                                                <option value="CRUD">CRUD</option>
                                                <option value="Single">Single</option>
                                                <option value="Report">Report</option>
                                            </select>
                                        </div><!-- end form-group -->
                                    </div><!-- end column -->
                                </div><!-- end form-row -->
                                
                                <div class="form-group">
                                    
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>SL</th>
                                                        <th>Field Name</th>
                                                        <th>Field Type</th>
                                                        <th>Related Table</th>
                                                        <th>Option Field</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id="tr1" class="crud-item">
                                                        <td>1</td>
                                                        <td>
                                                            <input type="text" id="example-text-input" class="form-control" placeholder="Field Name" name="field_name[]"><br />
                                                            <input type="text" id="example-text-input" class="form-control" placeholder="place Holder" name="field_name_placeholder[]">
                                                        </td>
                                                        <td>
                                                            <select id="example-select" name="field_type[]" class="form-control" size="1">
                                                                <option value="0">Select Type</option>
                                                                <option value="1">Input Field</option>
                                                                <option value="2">Text Area</option>
                                                                <option value="3">Check Box</option>
                                                                <option value="4">Radio Button</option>
                                                                <option value="5">Select Option</option>
                                                                <option value="6">Upload Image</option>
                                                                <option value="7">Upload File</option>
                                                            </select> 
                                                            <br />
                                                            <label>
                                                                <input type="checkbox" id="example-text-input" value="1"  name="field_validation_1"> Validation
                                                            </label>
                                                            
                                                        </td>
                                                        <td>
                                                            <select id="example-select" name="field_table[]" class="form-control" size="1">
                                                                <option value="1">Static Option</option>
                                                                <option value="0">Select Table</option>
                                                                @foreach($table as $tab)
                                                                    <option value="{{$tab->name}}">{{$tab->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <br />
                                                            <label class="show_in_table">
                                                                <input type="checkbox" id="example-text-input" value="1"  name="field_data_table_1"> Show in Table
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <input type="text" id="example-text-input" class="form-control" placeholder="Text" name="field_option[]">
                                                            <br />
                                                            <label class="show_in_filter" style="display: none;">
                                                                <input type="checkbox" id="example-text-input" value="1"  name="field_data_filter_1"> Show in Filter
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <button onclick="deleteRow(this)" class="btn btn-warning deleteRow btn-alt btn-default"><i class="fa fa-times fa-fw"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                    
                                </div><!-- end form-row -->

                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <button type="button" onclick="javascript:addmore();" class="btn btn-info"><i class="fas fa-plus"></i> Add More Field</button>
                                    </li>
                                    <li class="list-inline-item">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-angle-right"></i> Submit</button>
                                    </li>
                                    <li class="list-inline-item">
                                        <button type="reset" class="btn btn-warning"><i class="fas fa-backspace"></i> Reset</button>
                                    </li>
                                </ul>

                            </form>
                        </div><!-- end hotel-listing-form -->
                    </div><!-- end box -->
                </div><!-- end in-content-wrapper -->
            </div><!-- end add-details -->
        </section>


@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script type="text/javascript">
        $(".show_in_table").show();
        $(".show_in_filter").hide();

        $(document).ready(function(){
            $("select[name=page_type]").change(function(){
                var page_type=$(this).val();
                $(".show_in_table").show();
                $(".show_in_filter").hide();
                if(page_type=="CRUD"){
                    $(".show_in_table").show();
                    $(".show_in_filter").hide();
                }
                else if(page_type=="Single"){
                    $(".show_in_table").hide();
                    $(".show_in_filter").hide();
                }
                else if(page_type=="Report"){
                    $(".show_in_table").show();
                    $(".show_in_filter").show();
                }
            });
        });

        function refreshSerial(){
            var r=1;
            $.each($(".crud-item"),function(key,row){
                $(this).attr("id","tr"+r);
                $(this).find("td:first").html(r);
                $(this).find("td:eq(2)").find("input").attr("name","field_validation_"+r);
                $(this).find("td:eq(3)").find("input").attr("name","field_data_table_"+r);
                $(this).find("td:eq(4)").find("input:eq(1)").attr("name","field_data_filter_"+r);
                r++;
            });
        }

        $('tbody').sortable({
            stop: function (event, ui) {
                refreshSerial(); // re-number rows after sorting
            }
        });

        function addmore(){
            $("tr[class^='crud-item']:last").after($("tr[class^='crud-item']:last").clone());
            var item=$(".crud-item").length;
            refreshSerial();
        }

        function deleteRow(place){
            var item=$(".crud-item").length;
            if(item>1)
            {
                var itemID=$(place).parent().parent().attr("id");
                $("#"+itemID).remove()
            }
            refreshSerial(); 
        }
        var rootURL="{{url('/')}}";
        $(document).ready(function(){
            $("#page_name").keyup(function(){
                var getPageName=$(this).val();
                var getPageName=$.trim(getPageName);
                var getPageName=getPageName.replace(/\s/g,"");
                var getPageName=getPageName.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '');
                var getPageName=getPageName.toLowerCase();
                console.log(getPageName);
                //page_route
                $("#page_route").val(getPageName);
            });
        });
    </script>
@endsection

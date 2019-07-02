<?php
include('class/auth.php');
if (isset($_GET['del'])) {
    $obj->delete("tutorial_video", array("id" => $_GET['del']));
    unlink("vd/server/php/files/" . $_GET['delfile']);
    $obj->Success("Video Deleted Successfully", $obj->filename());
}

if (isset($_GET['pub'])) {
    $obj->update("tutorial_video", array("id" => $_GET['pub'], "status" => $_GET['pubst']));
    if ($_GET['pubst'] == 1) {
        $obj->Success("File Info Successfully Published.", $obj->filename());
    } else {
        $obj->Success("File Info Successfully Unpublished.", $obj->filename());
    }
}

if (isset($_POST['upd'])) {
    extract($_POST);
    if (!empty($title) && !empty($name)) {
        $obj->update("tutorial_video", array("id" => $id, "title" => $title, "name" => $name, "date" => date('Y-m-d')));
        $obj->Success("File Info Successfully Updated.", $obj->filename());
    } else {
        $obj->Error("Please Fillup All Fields", $obj->filename());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
                <?php
        include './plugin/plugin.php';
        $cms = new CmsRootPlugin();
        echo $cms->GeneralCss(array("kendo"));
        ?>
        <?php //echo $obj->bodyhead(); ?>        
    </head>
    <body>
        <?php include('include/header.php'); ?>
        <!-- Main wrapper -->
        <div class="wrapper three-columns">
            <!-- Left sidebar -->
        <?php include('include/sidebar_left.php'); ?>
            <!-- /left sidebar -->
            <!-- Main content -->
            <div class="content">

                <!-- Info notice -->
<?php echo $obj->ShowMsg(); ?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <h5><i class="font-film"></i> 
<?php if (!isset($_GET['edit'])) { ?>
                                    Video List <?php if ($input_status == 1) { ?>| <a href="helpdesk_upload.php">Upload Videos</a> <?php } ?>
<?php } else { ?>
                                    Edit Video File Info
                                <?php } ?>
                            </h5>
                        </div><!-- /page header -->

                        <div class="body">
<?php //include('include/quicklink.php');    ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">
                                <!-- Content Start from here customized -->
                                <!-- General form elements -->
                                <div class="row-fluid span12" style="padding-top: 5px;">     
                                        <?php if (!isset($_GET['edit'])) { ?>
                                        <div class="table-overflow">
                                            
                                            <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>

                                        
                                            <script id="Comment" type="text/x-kendo-template">
                                            <a class="k-button k-button-icontext k-grid-delete" href="video_list.php?edit=#=id#"><i class="icon-edit"></i> Manage Comment</a> 
                                                
                                            </script>
                                            <script id="action_template" type="text/x-kendo-template">
                                                <a class="k-button k-button-icontext k-grid-delete" href="video_list.php?edit=#=id#"><i class="icon-edit"></i> Edit</a> 
                                                <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id#);" ><span class="k-icon k-delete"></span> Delete</a>
                                            </script>
                                            <script type="text/javascript">
                                                function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                        if (c === true) {
                                                $.ajax({
                                                type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/video_list.php",
                                                        data: {id: id},
                                                        success: function (result) {
                                                        $(".k-i-refresh").click();
                                                        }
                                                });
                                                }
                                                }

                                            </script>
                                            <script type="text/javascript">
                                                jQuery(document).ready(function () {
                                                var dataSource = new kendo.data.DataSource({
                                                transport: {
                                                read: {
                                                url: "./controller/video_list.php",
                                                        type: "GET",
                                                        datatype: "json"

                                                }
                                                },
                                                        autoSync: false,
                                                        schema: {
                                                        data: "data",
                                                                total: "total",
                                                                model: {
                                                                id: "id",
                                                                        fields: {
                                                                        id: {type: "number"},
                                                                        title: {type: "string"},
                                                                        name: {type: "string"},
                                                                        status: {type: "string"}
                                                                        }
                                                                }
                                                        },
                                                        pageSize: 10,
                                                        serverPaging: true,
                                                        serverFiltering: true,
                                                        serverSorting: true
                                                });
                                                        jQuery("#grid").kendoGrid({
                                                dataSource: dataSource,
                                                        filterable: true,
                                                        pageable: {
                                                        refresh: true,
                                                                input: true,
                                                                numeric: false,
                                                                pageSizes: true,
                                                                pageSizes:[10, 20, 50, 100, 200, 400]
                                                        },
                                                        sortable: true,
                                                        groupable: true,
                                                        columns: [
                                                        {field: "id", title: "#", width: "40px", filterable: false},
                                                        {field: "title", title: "Title", width: "100px"},
                                                        {field: "name", title: "File Name", width: "100px"},
                                                        {
                                                        title: "Comment", width: "120px",
                                                                template: kendo.template($("#Comment").html())
                                                        },
                                                        {field: "status", title: "Status", width: "50px"},
                                                        {
                                                        title: "Action", width: "90px",
                                                                template: kendo.template($("#action_template").html())
                                                        }
                                                        ],
                                                });
                                                });

                                            </script>






    <?php /* <table class="table table-bordered" id="data-table">
      <thead>
      <tr>
      <th>#</th>
      <th>Title</th>
      <th>File Name </th>
      <th>Comment </th>
      <th>Status </th>
      <th>Action</th>
      </tr>
      </thead>
      <tbody>
      <?php
      $sqlv = $obj->FlyQuery("SELECT * FROM `tutorial_video` ORDER BY id DESC");
      if (!empty($sqlv)) {
      $i = 1;
      foreach ($sqlv as $vid):
      ?>
      <tr>
      <td><?php echo $i; ?></td>
      <td><?php echo $vid->title; ?></td>
      <td>
      <?php echo $vid->name; ?>
      </td>
      <td>
      <a class="btn btn-info" href="comment_list.php?video_id=<?php echo $vid->id; ?>"><i class="icon-comment"></i> Manage Comments</a>
      </td>
      <td>
      <?php
      if($vid->status==0)
      {
      ?>
      <a class="btn btn-danger" href="<?php echo $obj->filename(); ?>?pub=<?php echo $vid->id; ?>&pubst=1">Unpublish</a>
      <?php
      }
      else
      {
      ?>
      <a class="btn btn-success" href="<?php echo $obj->filename(); ?>?pub=<?php echo $vid->id; ?>&pubst=0">Publish</a>
      <?php
      }

      ?>
      </td>
      <td>
      <a class="btn btn-info" href="<?php echo $obj->filename(); ?>?edit=<?php echo $vid->id; ?>"><i class="icon-edit"></i></a>
      <a class="btn btn-danger" href="<?php echo $obj->filename(); ?>?del=<?php echo $vid->id; ?>&delfile=<?php echo $vid->name; ?>"><i class="icon-trash"></i></a>
      </td>
      </tr>
      <?php
      $i++;
      endforeach;
      }
      ?>
      </tbody>
      </table> */ ?>
                                        </div>
                                            <?php
                                        } else {
                                            ?>
                                        <form class="form-horizontal" method="post" name="invoice" action="">
                                            <fieldset>
                                                <div class="row-fluid  span12 well">
                                                    <!-- Selects, dropdowns -->
                                                    <!-- General form elements -->
                                                    <input type="hidden" name="id" value="<?php echo $_GET['edit']; ?>" />
                                                    <div class="control-group">
                                                        <label class="control-label">* Video Title</label>
                                                        <div class="controls"><input  value="<?php echo $obj->SelectAllByVal("tutorial_video", "id", $_GET['edit'], "title"); ?>"  class="span12 k-textbox" type="text" name="title" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label"> File Name </label>
                                                        <div class="controls">
                                                            <input type="text"  value="<?php echo $obj->SelectAllByVal("tutorial_video", "id", $_GET['edit'], "name"); ?>"   name="name" class="span12 k-textbox"  />
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">&nbsp;</label>
                                                        <div class="controls"><button type="submit" name="upd" class="k-button"><i class="icon-edit"></i> Update File Info </button></div>
                                                    </div>

                                                </div>
                                                <!-- /selects, dropdowns -->



                                                <!-- Selects, dropdowns -->

                                                <!-- /selects, dropdowns -->


                                                <!-- /general form elements -->


                                                <div class="clearfix"></div>

                                                <!-- Default datatable -->

                                                <!-- /default datatable -->
                                            </fieldset>

                                        </form>    
    <?php
}
?>
                                </div>
                                <!-- /general form elements -->     


                                <div class="clearfix"></div>

                                <!-- Default datatable -->

                                <!-- /default datatable -->





                                <!-- Content End from here customized -->




                                <div class="separator-doubled"></div> 



                            </div>
                            <!-- /content container -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- /main content -->
            <?php
            include('include/footer.php');
            echo $cms->KendoFotter();
            ?>
            <?php //include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');        ?>
            <!-- /right sidebar -->
        </div>
        <!-- /main wrapper -->

    </body>
</html>

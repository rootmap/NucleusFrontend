<?php
include('class/auth.php');
if (isset($_GET['del'])) {
    $obj->delete("video_comment", array("id" => $_GET['del']));
    $obj->Success("Video Comment Deleted Successfully", $obj->filename()."?video_id=".$_GET['video_id']);
}

if (isset($_GET['pub'])) {
    $obj->update("video_comment", array("id" => $_GET['pub'], "status" => $_GET['pubst']));
    if ($_GET['pubst'] == 1) {
        $obj->Success("Comment Successfully Active.", $obj->filename()."?video_id=".$_GET['video_id']);
    } else {
        $obj->Success("Comment Successfully Inactive.", $obj->filename()."?video_id=".$_GET['video_id']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $obj->bodyhead(); ?>        
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
                            <h5><i class="icon-comment"></i> 
                                Manage Comment For Video
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

                                    <div class="table-overflow">
                                        <table class="table table-bordered" id="data-table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Comment</th>
                                                    <th>Posted By </th>
                                                    <th>User Type </th>
                                                    <th>Status </th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sqlcomments = $obj->FlyQuery("SELECT a.*,s.name,IFNULL(s.image,'avater.png') as image,s.status as user_type FROM video_comment as a
                                                                            LEFT JOIN store as s ON s.id=a.user_id
                                                                            WHERE a.video_id='" . $_GET['video_id'] . "' ORDER BY a.id DESC LIMIT 30");
                                                if (!empty($sqlcomments)) {
                                                    $i=1;
                                                    foreach ($sqlcomments as $comm):

                                                        if ($comm->user_type == 1) {
                                                            $user_label = "System Admin";
                                                        } elseif ($comm->user_type == 2) {
                                                            $user_label = "Store Admin";
                                                        } elseif ($comm->user_type == 3) {
                                                            $user_label = "Store Cashier";
                                                        } elseif ($comm->user_type == 4) {
                                                            $user_label = "Store Manager";
                                                        } elseif ($comm->user_type == 5) {
                                                            $user_label = "Store Chain Admin";
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td><?php echo $comm->comment; ?></td>
                                                            <td>
                                                                <?php echo $comm->name; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $user_label; ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if ($comm->status == 0) {
                                                                    ?>
                                                                    <a class="btn btn-danger" href="<?php echo $obj->filename(); ?>?pub=<?php echo $comm->id; ?>&pubst=1&video_id=<?php echo $_GET['video_id']; ?>">Inactive</a>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <a class="btn btn-success" href="<?php echo $obj->filename(); ?>?pub=<?php echo $comm->id; ?>&pubst=0&video_id=<?php echo $_GET['video_id']; ?>">Active</a>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-danger" href="<?php echo $obj->filename(); ?>?del=<?php echo $comm->id; ?>&video_id=<?php echo $_GET['video_id']; ?>"><i class="icon-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    endforeach;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

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
            <?php include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');          ?>
            <!-- /right sidebar -->
        </div>
        <!-- /main wrapper -->

    </body>
</html>

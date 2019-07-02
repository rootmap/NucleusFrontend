
<!--page loading--bar-->
<div id="amsit_loading">
    <span style="margin-top:190px; display:block;">
        <div class="span3">
            <img src="images/load.gif" style="width:100px;" />

        </div>
        <div class="span8">
            <h1 class="label label-info pull-center">Loading Please Wait...</h1>
        </div>
    </span>
</div>
<!--page loading-->    
<div id="top">
    <div class="top-wrapper">
        <a href="index.php" title=""><div style="height:48px; margin-left:50px; float:left; overflow:hidden; width:150px;"><img src="pos_image/nucleusfinal.png" style="margin-top:-35px;" class="logo" alt="" /></div></a>
        <ul class="topnav">
            <li class="topuser" style="color:#fff;">
                <a href="javascript:history.go(-1)">
                    <i class="icon-backward"></i>
                    Logged As A 
                    <?php
                    if ($input_status == 1) {
                        echo "Super Admin";
                    } elseif ($input_status == 2) {
                        echo "Shop Admin";
                    } elseif ($input_status == 3) {
                        echo "Cashier";
                    } elseif ($input_status == 4) {
                        echo "Shop Manager";
                    } elseif ($input_status == 5) {
                        echo "Store Chain Admin";
                    }
                    ?>
                </a>
            </li>
            <?php if ($obj->filename() != 'index.php') { ?>
                <li class="topuser" style="color:#fff;">
                    <a href="javascript:history.go(-1)">
                        <i class="icon-backward"></i>
                        Back
                    </a>
                </li>
            <?php } ?>
            <li class="topuser">
                <a title="" href="view_profile.php?edit=<?php echo $_SESSION['SESS_AMSIT_APPS_ID']; ?>" data-toggle="dropdown"><img src="store/<?php echo $obj->SelectAllByVal("store", "id", $_SESSION['SESS_AMSIT_APPS_ID'], "image"); ?>" alt="" /><span><?php echo $_SESSION['SESS_AMSIT_APPS_SHOP_NAME']; ?></span></a>
            </li>

            <!--added for currency by shanto-->
            <li class="topuser" id="currency">
                <a title="" data-toggle="dropdown"><i class="font-money" style="color: #FFF;"></i> <span>Currency</span><i class="caret"></i></a>
                <ul class="dropdown-menu">
                    <?php
                    $sqlcdata = $obj->FlyQuery("SELECT sc.*,
                                                c.name,
                                                c.sign
                                                FROM store_currency AS sc
                                                LEFT JOIN currency AS c ON c.id=sc.currency_id
                                                WHERE sc.store_id='$input_by' ORDER BY sc.currency_id DESC");

                    if (!empty($sqlcdata))
                        foreach ($sqlcdata as $row):
                            ?>
                            <li <?php if($row->status==1){?>class="active"<?php } ?>>
                                <a href="javascript:currency('<?php echo $row->id; ?>');" title="" <?php if($row->status==1){?>style="color: #7AA745 !important; font-weight: bold !important;"<?php } ?>>
                                    <?php echo $row->name; ?> 
                                    <strong><?php echo $row->sign; ?></strong>
                                </a>
                            </li>
                            <?php
                        endforeach;
                    ?> 
                </ul>
            </li>
            <script type="text/javascript">
                $("#currency").click(function () {
                    $(this).toggleClass("open");
                });
            </script>
            <!--./added for currency by shanto-->

            <?php
            if ($input_status == 3) {
                if ($obj->filename() == "pos.php") {

                    if ($cashiers_id != 0) {
                        $chkopenstore = $obj->exists_multiple("store_open", array("sid" => $input_by, "status" => 1));
                        if ($chkopenstore != 0) {
                            ?>

                            <script>
                                function logoutfromwholesystem(vall)
                                {
                                    url = "pos.php?lfwspcs=" + vall;
                                    window.location.replace(url);
                                }
                            </script>
                            <!--<li><a onclick="logoutfromwholesystem(document.getElementById('stcv').value)" href="#" title="Logout From Whole System"><span class="user-logout"></span>Logout</a></li>-->
                            <li class="topuser" style="color:#fff;">    
                                <a href="logout.php"><i  style="color:#fff;" class="icon-lock"></i> <span class="user-logout"></span> Logout </a>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li class="topuser" style="color:#fff;">    
                                <a href="logout.php"><i  style="color:#fff;" class="icon-lock"></i> <span class="user-logout"></span> Logout </a>
                            </li>
                            <?php
                        }
                    } else {
                        ?>
                        <li class="topuser" style="color:#fff;">    
                            <a href="logout.php"><i  style="color:#fff;" class="icon-lock"></i> <span class="user-logout"></span> Logout </a>
                        </li>
                        <?php
                    }
                } else {
                    ?>
                    <li class="topuser" style="color:#fff;">    
                        <a href="logout.php"><i style="color:#fff;" class="icon-lock"></i> <span class="user-logout"></span> Logout </a>
                    </li>
                    <?php
                }
            } else {
                ?>
                <li class="topuser" style="color:#fff;">    
                    <a href="logout.php"><i  style="color:#fff;" class="icon-lock"></i> <span class="user-logout"></span> Logout </a>
                </li>
            <?php } ?>

            <li class="search">
                <a title=""><b class="search"></b></a>
                <form class="top-search" method="get" action="search_report.php" >
                    <input type="text" name="search" placeholder="IMEI Number..." />
                    <input type="submit" value="" />
                </form>
            </li>
        </ul>
    </div>
</div>
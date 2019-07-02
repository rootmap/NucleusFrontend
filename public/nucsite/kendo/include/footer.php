<div class="outer" style="padding-bottom: 5px; padding-top: 5px; background: none; box-shadow: none;">
    <h5 class="subtitle semi-block align-center" style="margin-top: 0px; margin-bottom: 0px;">
        <a  href="http://neutrix.systems/" style="display:block; margin-left:250px;" target="_blank"><img width="300" style="margin-top:-60px; clear:both;" style="margin-left:auto; margin-right:auto;" src="images/poweredbyneutrix3.png"></a>
    </h5>
</div>
<script src="js/jquery.min.js"></script>
<script>

    var nucleus = $.noConflict();
    
    function currency(cid)
    {
        if(cid!='')
        {
            $.post("ajax/currency.php",{'cid':cid},function(data){
                if(data)
                {
                    window.location.href="<?php echo $obj->filename(); ?>";
                }
                console.log(data);
            });
        }
           
    }
    
    nucleus(document).ready(function () {
        var page_name = "<?php
                        $expagear = array("checkin_verience.php",
                            "phone_verience.php",
                            "maintain_stock_varience.php",
                            "other_inventory_verience.php",
                            "checkin_inventory_list.php",
                            "create_verience.php",
                            "phone_inventory_v_list.php",
                            "create_phone_verience.php",
                            "inventory_v_maintain_list.php",
                            "create_maintain_stock_verience.php",
                            "other_inventory_list.php",
                            "create_other_inventory_verience.php");
                        
                        $expagearpurchase = array("purchase_list_order.php",
                            "purchase.php");
                        
                        if (in_array($obj->filename(), $expagear)) {
                            echo "startaverience.php";
                        }elseif(in_array($obj->filename(), $expagearpurchase)){  
                            echo "purchase.php";
                        } else {
                            echo $obj->filename();
                        }

                        ?>";
        var dd = nucleus("li a[href='" + page_name + "']").parent().parent().parent().children().add("first-child").prop("tagName");
        if (dd == "A")
        {
            //var nn=nucleus("li a[href='" + page_name + "']").parent().parent().parent().attr("class","active");
            nucleus("li a[href='" + page_name + "']").parent().parent().parent().addClass("active");
            nucleus("li a[href='" + page_name + "']").parent().parent().parent().children('a').attr("class", "expand subOpened");
            nucleus("li a[href='" + page_name + "']").parent().parent().parent().children('ul').css("display", "block");
            nucleus("li a[href='" + page_name + "']").css("color", "#3498db");
            nucleus("li a[href='" + page_name + "']").css("font-weight", "bolder");
        }
        else
        {
            nucleus("li a[href='" + page_name + "']").parent().addClass("active");
        }

    });
</script>
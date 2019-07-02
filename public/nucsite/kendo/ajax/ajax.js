
$.ajaxSetup({cache: false});// JavaScript Document
/*$(document).ready(function(){
 $("button").click(function(){
 $("#div1").fadeOut(200);
 $("#div2").fadeOut("slow");
 $("#div3").fadeOut(3000);
 });
 });*/

function auto_sales(pid, sales_id) {
    
    if (pid == "") {
        document.getElementById("msg").innerHTML = "";
        return;
    }
    
    $("#searchResult").fadeOut();
    $("#searchBResult").fadeOut();
    
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            //load sales list	
            xmlhttps = new XMLHttpRequest();
            xmlhttps.onreadystatechange = function () {
                if (xmlhttps.readyState == 4 && xmlhttps.status == 200) {

                    $("#sales_list").fadeOut();
                    $("#sales_list").fadeIn();
                    document.getElementById("sales_list").innerHTML = xmlhttps.responseText;
                }
            }
            xmlhttps.open("GET", "ajax/load_sales_list.php?sales_id=" + sales_id, true);
            xmlhttps.send();
            //load sales list


            //load sales subtotal list	
            xmlhttpss = new XMLHttpRequest();
            xmlhttpss.onreadystatechange = function () {
                if (xmlhttpss.readyState == 4 && xmlhttpss.status == 200) {

                    $("#subtotal_list").fadeOut();
                    $("#subtotal_list").fadeIn();
                    document.getElementById("subtotal_list").innerHTML = xmlhttpss.responseText;
                }
            }
            xmlhttpss.open("GET", "ajax/load_sales_list_cal.php?sales_id=" + sales_id, true);
            xmlhttpss.send();
            //load sales subtotal list

            $("#msg").fadeOut();
            $("#msg").fadeIn();
            
            document.getElementById("msg").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "ajax/auto_sales.php?pid=" + pid + "&sales_id=" + sales_id, true);
    xmlhttp.send();
}

function barcode_sales(barcode, sales_id) {
    if (barcode == "") {
        document.getElementById("msg").innerHTML = "";
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            //load sales list	
            xmlhttps = new XMLHttpRequest();
            xmlhttps.onreadystatechange = function () {
                if (xmlhttps.readyState == 4 && xmlhttps.status == 200) {

                    $("#sales_list").fadeOut();
                    $("#sales_list").fadeIn();
                    document.getElementById("sales_list").innerHTML = xmlhttps.responseText;
                    document.getElementById("barcode_reader_place").value = "";
                    //$("#barcode_reader_place").val()="";
                }
            }
            xmlhttps.open("GET", "ajax/load_sales_list.php?sales_id=" + sales_id, true);
            xmlhttps.send();
            //load sales list


            //load sales subtotal list	
            xmlhttpss = new XMLHttpRequest();
            xmlhttpss.onreadystatechange = function () {
                if (xmlhttpss.readyState == 4 && xmlhttpss.status == 200) {

                    $("#subtotal_list").fadeOut();
                    $("#subtotal_list").fadeIn();
                    document.getElementById("subtotal_list").innerHTML = xmlhttpss.responseText;
                }
            }
            xmlhttpss.open("GET", "ajax/load_sales_list_cal.php?sales_id=" + sales_id, true);
            xmlhttpss.send();
            //load sales subtotal list

            $("#msg").fadeOut();
            $("#msg").fadeIn();
            document.getElementById("msg").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "ajax/barcode_sales.php?barcode=" + barcode + "&sales_id=" + sales_id, true);
    xmlhttp.send();
}


function inventory_sales(sales_id) {
    if (sales_id == "") {
        document.getElementById("msg").innerHTML = "";
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            //load sales list	
            xmlhttps = new XMLHttpRequest();
            xmlhttps.onreadystatechange = function () {
                if (xmlhttps.readyState == 4 && xmlhttps.status == 200) {

                    $("#sales_list").fadeOut();
                    $("#sales_list").fadeIn();
                    document.getElementById("sales_list").innerHTML = xmlhttps.responseText;
                }
            }
            xmlhttps.open("GET", "ajax/load_sales_list.php?sales_id=" + sales_id, true);
            xmlhttps.send();
            //load sales list


            //load sales subtotal list	
            xmlhttpss = new XMLHttpRequest();
            xmlhttpss.onreadystatechange = function () {
                if (xmlhttpss.readyState == 4 && xmlhttpss.status == 200) {

                    $("#subtotal_list").fadeOut();
                    $("#subtotal_list").fadeIn();
                    document.getElementById("subtotal_list").innerHTML = xmlhttpss.responseText;
                }
            }
            xmlhttpss.open("GET", "ajax/load_sales_list_cal.php?sales_id=" + sales_id, true);
            xmlhttpss.send();
            //load sales subtotal list

            $("#msg").fadeOut();
            $("#msg").fadeIn();
            document.getElementById("msg").innerHTML = xmlhttp.responseText;
        }
    }
    pid = document.getElementById('pids').value;

    quantity = document.getElementById('quan').value;
    if (quantity != '')
    {
        xmlhttp.open("GET", "ajax/inventory_sales.php?pid=" + pid + "&sales_id=" + sales_id + "&quantity=" + quantity, true);
        xmlhttp.send();
    }
    else
    {
        $("#msg").fadeOut();
        $("#msg").fadeIn();
        document.getElementById("msg").innerHTML = "Check Quantity Field";
    }
}

function snd_inventory_sales(sales_id) {
    if (sales_id == "") {
        document.getElementById("msg").innerHTML = "";
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            //load sales list	
            xmlhttps = new XMLHttpRequest();
            xmlhttps.onreadystatechange = function () {
                if (xmlhttps.readyState == 4 && xmlhttps.status == 200) {

                    $("#sales_list").fadeOut();
                    $("#sales_list").fadeIn();
                    document.getElementById("sales_list").innerHTML = xmlhttps.responseText;
                }
            }
            xmlhttps.open("GET", "ajax/load_sales_list.php?sales_id=" + sales_id, true);
            xmlhttps.send();
            //load sales list


            //load sales subtotal list	
            xmlhttpss = new XMLHttpRequest();
            xmlhttpss.onreadystatechange = function () {
                if (xmlhttpss.readyState == 4 && xmlhttpss.status == 200) {

                    $("#subtotal_list").fadeOut();
                    $("#subtotal_list").fadeIn();
                    document.getElementById("subtotal_list").innerHTML = xmlhttpss.responseText;
                }
            }
            xmlhttpss.open("GET", "ajax/load_sales_list_cal.php?sales_id=" + sales_id, true);
            xmlhttpss.send();
            //load sales subtotal list

            $("#msg").fadeOut();
            $("#msg").fadeIn();
            document.getElementById("msg").innerHTML = xmlhttp.responseText;
        }
    }
    pid = document.getElementById('snd_pids').value;

    quantity = document.getElementById('snd_quan').value;
    if (quantity != '')
    {
        xmlhttp.open("GET", "ajax/inventory_sales.php?pid=" + pid + "&sales_id=" + sales_id + "&quantity=" + quantity, true);
        xmlhttp.send();
    }
    else
    {
        $("#msg").fadeOut();
        $("#msg").fadeIn();
        document.getElementById("msg").innerHTML = "Check Quantity Field";
    }
}

function fst_inventory_sales(sales_id) {
    if (sales_id == "") {
        document.getElementById("msg").innerHTML = "";
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            //load sales list	
            xmlhttps = new XMLHttpRequest();
            xmlhttps.onreadystatechange = function () {
                if (xmlhttps.readyState == 4 && xmlhttps.status == 200) {

                    $("#sales_list").fadeOut();
                    $("#sales_list").fadeIn();
                    document.getElementById("sales_list").innerHTML = xmlhttps.responseText;
                }
            }
            xmlhttps.open("GET", "ajax/load_sales_list.php?sales_id=" + sales_id, true);
            xmlhttps.send();
            //load sales list


            //load sales subtotal list	
            xmlhttpss = new XMLHttpRequest();
            xmlhttpss.onreadystatechange = function () {
                if (xmlhttpss.readyState == 4 && xmlhttpss.status == 200) {

                    $("#subtotal_list").fadeOut();
                    $("#subtotal_list").fadeIn();
                    document.getElementById("subtotal_list").innerHTML = xmlhttpss.responseText;
                }
            }
            xmlhttpss.open("GET", "ajax/load_sales_list_cal.php?sales_id=" + sales_id, true);
            xmlhttpss.send();
            //load sales subtotal list

            $("#msg").fadeOut();
            $("#msg").fadeIn();
            document.getElementById("msg").innerHTML = xmlhttp.responseText;
        }
    }
    pid = document.getElementById('fst_pids').value;

    quantity = document.getElementById('fst_quan').value;
    if (quantity != '')
    {
        xmlhttp.open("GET", "ajax/inventory_sales.php?pid=" + pid + "&sales_id=" + sales_id + "&quantity=" + quantity, true);
        xmlhttp.send();
    }
    else
    {
        $("#msg").fadeOut();
        $("#msg").fadeIn();
        document.getElementById("msg").innerHTML = "Check Quantity Field";
    }
}

function phone_inventory_sales(sales_id) {
    if (sales_id == "") {
        document.getElementById("msg").innerHTML = "";
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            //load sales list	
            xmlhttps = new XMLHttpRequest();
            xmlhttps.onreadystatechange = function () {
                if (xmlhttps.readyState == 4 && xmlhttps.status == 200) {

                    $("#sales_list").fadeOut();
                    $("#sales_list").fadeIn();
                    document.getElementById("sales_list").innerHTML = xmlhttps.responseText;
                }
            }
            xmlhttps.open("GET", "ajax/load_sales_list.php?sales_id=" + sales_id, true);
            xmlhttps.send();
            //load sales list


            //load sales subtotal list	
            xmlhttpss = new XMLHttpRequest();
            xmlhttpss.onreadystatechange = function () {
                if (xmlhttpss.readyState == 4 && xmlhttpss.status == 200) {

                    $("#subtotal_list").fadeOut();
                    $("#subtotal_list").fadeIn();
                    document.getElementById("subtotal_list").innerHTML = xmlhttpss.responseText;
                }
            }
            xmlhttpss.open("GET", "ajax/load_sales_list_cal.php?sales_id=" + sales_id, true);
            xmlhttpss.send();
            //load sales subtotal list

            $("#msg").fadeOut();
            $("#msg").fadeIn();
            document.getElementById("msg").innerHTML = xmlhttp.responseText;
        }
    }
    pid = document.getElementById('phone_pids').value;

    quantity = document.getElementById('phone_quan').value;
    if (quantity != '')
    {
        xmlhttp.open("GET", "ajax/inventory_sales.php?pid=" + pid + "&sales_id=" + sales_id + "&quantity=" + quantity, true);
        xmlhttp.send();
    }
    else
    {
        $("#msg").fadeOut();
        $("#msg").fadeIn();
        document.getElementById("msg").innerHTML = "Check Quantity Field";
    }
}


function manual_sales(sales_id) {
    if (sales_id == "") {
        document.getElementById("msg").innerHTML = "";
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            //load sales list	
            xmlhttps = new XMLHttpRequest();
            xmlhttps.onreadystatechange = function () {
                if (xmlhttps.readyState == 4 && xmlhttps.status == 200) {

                    $("#sales_list").fadeOut();
                    $("#sales_list").fadeIn();
                    document.getElementById("sales_list").innerHTML = xmlhttps.responseText;
                }
            }
            xmlhttps.open("GET", "ajax/load_sales_list.php?sales_id=" + sales_id, true);
            xmlhttps.send();
            //load sales list


            //load sales subtotal list	
            xmlhttpss = new XMLHttpRequest();
            xmlhttpss.onreadystatechange = function () {
                if (xmlhttpss.readyState == 4 && xmlhttpss.status == 200) {

                    $("#subtotal_list").fadeOut();
                    $("#subtotal_list").fadeIn();
                    document.getElementById("subtotal_list").innerHTML = xmlhttpss.responseText;
                }
            }
            xmlhttpss.open("GET", "ajax/load_sales_list_cal.php?sales_id=" + sales_id, true);
            xmlhttpss.send();
            //load sales subtotal list

            $("#msg").fadeOut();
            $("#msg").fadeIn();
            document.getElementById("msg").innerHTML = xmlhttp.responseText;
        }
    }
    pid = document.getElementById('pid').value;
    price = document.getElementById('price').value;
    quantity = document.getElementById('quantity').value;
    xmlhttp.open("GET", "ajax/manual_sales.php?pid=" + pid + "&sales_id=" + sales_id + "&price=" + price + "&quantity=" + quantity, true);
    xmlhttp.send();
}

function recurring_sales(sales_id) {
    if (sales_id == "") {
        document.getElementById("msg").innerHTML = "";
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            //load sales list	
            xmlhttps = new XMLHttpRequest();
            xmlhttps.onreadystatechange = function () {
                if (xmlhttps.readyState == 4 && xmlhttps.status == 200) {

                    $("#sales_list").fadeOut();
                    $("#sales_list").fadeIn();
                    document.getElementById("sales_list").innerHTML = xmlhttps.responseText;
                }
            }
            xmlhttps.open("GET", "ajax/load_sales_list.php?sales_id=" + sales_id, true);
            xmlhttps.send();
            //load sales list


            //load sales subtotal list	
            xmlhttpss = new XMLHttpRequest();
            xmlhttpss.onreadystatechange = function () {
                if (xmlhttpss.readyState == 4 && xmlhttpss.status == 200) {

                    $("#subtotal_list").fadeOut();
                    $("#subtotal_list").fadeIn();
                    document.getElementById("subtotal_list").innerHTML = xmlhttpss.responseText;
                }
            }
            xmlhttpss.open("GET", "ajax/load_sales_list_cal.php?sales_id=" + sales_id, true);
            xmlhttpss.send();
            //load sales subtotal list

            $("#msg").fadeOut();
            $("#msg").fadeIn();
            if (xmlhttp.responseText == '0')
            {
                $.jGrowl('Please Select a Customer.', {sticky: false, theme: 'growl-warning', header: 'Error!'});
            }
            else if (xmlhttp.responseText == 'emt')
            {
                $.jGrowl('Please Fillup All Required (*) Field.', {sticky: false, theme: 'growl-warning', header: 'Error!'});
            }
            else
            {
                document.getElementById("msg").innerHTML = xmlhttp.responseText;
            }
        }
    }
    pid = document.getElementById('pidi').value;
    //des = document.getElementById('des').value;
    frequency = document.getElementById('frequency').value;
    startdate = document.getElementById('startdate').value;
    des = document.getElementById('descc').value;
    notes = document.getElementById('notes').value;
    cid = document.getElementById('customername').value;
    if (document.getElementById('auto_charged').checked == true)
    {
        var auto_charged = 1;
    }
    else
    {
        var auto_charged = 0;
    }

    xmlhttp.open("GET", "ajax/reccurring_sales_invoice.php?pid=" + pid + "&sales_id=" + sales_id + "&des=" + des + "&frequency=" + frequency + "&startdate=" + startdate + "&notes=" + notes + "&auto_charged=" + auto_charged + "&cid=" + cid+ "&des=" + des, true);
    xmlhttp.send();
}

function delete_sales(pid, sales_id) {
    if (pid == "") {
        document.getElementById("msg").innerHTML = "";
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            //load sales list	
            xmlhttps = new XMLHttpRequest();
            xmlhttps.onreadystatechange = function () {
                if (xmlhttps.readyState == 4 && xmlhttps.status == 200) {

                    $("#sales_list").fadeOut();
                    $("#sales_list").fadeIn();
                    document.getElementById("sales_list").innerHTML = xmlhttps.responseText;
                }
            }
            xmlhttps.open("GET", "ajax/load_sales_list.php?sales_id=" + sales_id, true);
            xmlhttps.send();
            //load sales list


            //load sales subtotal list	
            xmlhttpss = new XMLHttpRequest();
            xmlhttpss.onreadystatechange = function () {
                if (xmlhttpss.readyState == 4 && xmlhttpss.status == 200) {

                    $("#subtotal_list").fadeOut();
                    $("#subtotal_list").fadeIn();
                    document.getElementById("subtotal_list").innerHTML = xmlhttpss.responseText;
                }
            }
            xmlhttpss.open("GET", "ajax/load_sales_list_cal.php?sales_id=" + sales_id, true);
            xmlhttpss.send();
            //load sales subtotal list

            $("#msg").fadeOut();
            $("#msg").fadeIn();
            document.getElementById("msg").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "ajax/delete_sales.php?pid=" + pid + "&sales_id=" + sales_id, true);
    xmlhttp.send();
}

/*function paytotal(sales_id,dd)
 {
 if(sales_id=="") 
 {
 document.getElementById("ss").innerHTML="";
 return;
 }
 if (window.XMLHttpRequest) {
 // code for IE7+, Firefox, Chrome, Opera, Safari
 xmlhttp=new XMLHttpRequest();
 } else { // code for IE6, IE5
 xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 }
 xmlhttp.onreadystatechange=function() {
 if (xmlhttp.readyState==4 && xmlhttp.status==200) {
 
 //load buttons
 xmlhttps=new ActiveXObject("Microsoft.XMLHTTP");
 xmlhttps.onreadystatechange=function() {
 if (xmlhttps.readyState==4 && xmlhttps.status==200) {
 $("#buttonshow").fadeOut();
 $("#buttonshow").fadeIn();
 document.getElementById("buttonshow").innerHTML=xmlhttps.responseText;
 }
 }
 xmlhttps.open("GET","ajax/buttons_pay.php?cart="+sales_id+"&dd="+dd,true);
 xmlhttps.send();
 //load buttons
 
 
 $("#ss").fadeOut();
 $("#ss").fadeIn();
 document.getElementById("ss").innerHTML=xmlhttp.responseText;
 
 }
 }
 xmlhttp.open("GET","ajax/load_sales_list_cal_total.php?sales_id="+sales_id+"&dd="+dd,true);
 xmlhttp.send();
 }*/



function paytotal(sales_id, dd)
{
    if (sales_id == "")
    {
        document.getElementById("ss").innerHTML = "";
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            //load buttons
            xmlhttps = new XMLHttpRequest();
            xmlhttps.onreadystatechange = function () {
                if (xmlhttps.readyState == 4 && xmlhttps.status == 200) {
                    $("#buttonshow").fadeOut();
                    $("#buttonshow").fadeIn();
                    document.getElementById("buttonshow").innerHTML = xmlhttps.responseText;
                }
            }
            xmlhttps.open("GET", "ajax/buttons_pay.php?cart=" + sales_id + "&dd=" + dd, true);
            xmlhttps.send();
            //load buttons

            $("#ss").fadeOut();
            $("#ss").fadeIn();
            document.getElementById("ss").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "ajax/load_sales_list_cal_total.php?sales_id=" + sales_id + "&dd=" + dd, true);
    xmlhttp.send();
}

function store_close_confirm2(loginid, df)
{
    var butt = "<a  data-toggle='modal' href='#myModal3'  onClick='store_close_report()' class='btn btn-warning'><i class='icon-off'></i> Close Store Detail </a>";
    var gdd = "<label class='label label-success'>Cashier Confirmed You Can Close Store Now</label>";
    var wrong = "<label class='label label-danger'>Login Failed, Retry Login Again</label>";
    var wrongs = "<label class='label label-danger'>You Are a Cashier but not for Authorized to closed this store, Retry to authorized</label>";
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            //$("#store_close_message").fadeOut();
            //$("#store_close_message").fadeIn();
            //document.getElementById("store_close_message").innerHTML=xmlhttp.responseText;
            var fgf = '';
            if (df == 1)
            {
                fgf = 'mss';
            }
            else
            {
                fgf = 'mss_n_p';
            }

            if (xmlhttp.responseText == 1)
            {
                $.jGrowl('Cashier Confirmed To Close Store.', {sticky: false, theme: 'growl-warning', header: 'success!'});
                if (df == 1)
                {

                    $('#logout_store_close').modal('hide');
                    $('#myModal3').modal('show');
                    //$('a[href=#myModal3]').click();
                    $('#dfgd').hide();
                    $('#clstst').show();
                    $('button[name=storecloseing]').click();
                    $.jGrowl('Please wait data is processing for further record.', {sticky: false, theme: 'growl-warning', header: 'Processing!'});
                }
                else
                {

                    $('#logout_store_close_n_p').modal('hide');
                    $('#myModal3').modal('show');
                    $('#dfgd').hide();
                    $('#clstst').show();
                    $('button[name=storecloseing_print]').click();
                    $.jGrowl('Please wait data is processing for further record.', {sticky: false, theme: 'growl-warning', header: 'Processing!'});
                }
                //stccash
                document.getElementById("stccash").innerHTML = butt;
                document.getElementById("store_close_message").innerHTML = gdd;


                //document.getElementById("store_close_message").innerHTML=xmlhttp.responseText;  
            }
            else if (xmlhttp.responseText == 2)
            {

                document.getElementById(fgf).innerHTML = wrongs;
            }
            else if (xmlhttp.responseText == 3)
            {
                document.getElementById(fgf).innerHTML = wrong;
            }
        }
    }
    str = 1;
    if (df == 1)
    {
        var username = document.getElementById('strurs').value;
        var password = document.getElementById('strpass').value;
    }
    else
    {
        var username = document.getElementById('strurs_n_p').value;
        var password = document.getElementById('strpass_n_p').value;
        //
    }


    xmlhttp.open("GET", "ajax/store_close_confirm.php?str=" + str + "&loginid=" + loginid + "&username=" + username + "&password=" + password, true);
    xmlhttp.send();
}


function hideex(dxd)
{
    $('#' + dxd).modal('hide');
}

function store_close_confirm(loginid)
{
    var butt = "<a  data-toggle='modal' href='#myModal3'  onClick='store_close_report()' class='btn btn-warning'><i class='icon-off'></i> Close Store Detail </a>";
    var gdd = "<label class='label label-success'>Cashier Confirmed You Can Close Store Now</label>";
    var wrong = "<label class='label label-danger'>Login Failed, Retry Login Again</label>";
    var wrongs = "<label class='label label-danger'>You Are a Cashier but not for Authorized to closed this store, Retry to authorized</label>";
    document.getElementById("stccash").innerHTML = butt;
    $('a[href=#myModal3]').click();
}


//function store_open_confirm(loginid)
//{
//  var butt="<a data-toggle='modal' href='#myModal3' class='btn btn-info'><i class='icon-inbox'></i> Open Store Now </a>";
//  var gdd="<label class='label label-success'>Cashier Confirmed You Can Open Store Now</label>";	
//  var wrong="<label class='label label-danger'>Login Failed, Retry Login Again to open Store</label>";
//  var wrongs="<label class='label label-danger'>You Are a Cashier but not for Authorized to Open this store, Retry to authorized</label>";	
//  if (window.XMLHttpRequest) {
//    // code for IE7+, Firefox, Chrome, Opera, Safari
//    xmlhttp=new XMLHttpRequest();
//  } else { // code for IE6, IE5
//    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
//  }
//  xmlhttp.onreadystatechange=function() {
//    if (xmlhttp.readyState==4 && xmlhttp.status==200) {	  
//	  //$("#store_close_message").fadeOut();
//	  //$("#store_close_message").fadeIn();
//      //document.getElementById("store_close_message").innerHTML=xmlhttp.responseText;
//		  if(xmlhttp.responseText==1)
//		  {
//			  //stccash
//			 document.getElementById("oopencash").innerHTML=butt; 
//			 document.getElementById("store_close_message").innerHTML=gdd;
//			 $('#login_store_open').modal('hide');
//			 //document.getElementById("store_close_message").innerHTML=xmlhttp.responseText;  
//		  }
//		  else if(xmlhttp.responseText==2)
//		  {
//			 document.getElementById("tss").innerHTML=wrongs;
//			 //$('#logout_store_close').modal('hide'); 
//		  }
//		  else if(xmlhttp.responseText==3)
//		  {
//			 document.getElementById("tss").innerHTML=wrong;
//			 //$('#logout_store_close').modal('hide'); 
//		  }
//    }
//  }
//  
//  str=1;
//  
//  var username=document.getElementById('stturs').value;
//  var password=document.getElementById('sttpass').value;
//  
//xmlhttp.open("GET","ajax/store_close_confirm.php?str="+str+"&loginid="+loginid+"&username="+username+"&password="+password,true);
//xmlhttp.send();
//}


function store_open_confirm(loginid)
{
    var butt = "<a data-toggle='modal' href='#myModal3' class='btn btn-info'><i class='icon-inbox'></i> Open Store Now </a>";
    var gdd = "<label class='label label-success'>Cashier Confirmed You Can Open Store Now</label>";
    var wrong = "<label class='label label-danger'>Login Failed, Retry Login Again to open Store</label>";
    var wrongs = "<label class='label label-danger'>You Are a Cashier but not for Authorized to Open this store, Retry to authorized</label>";

    //stccash
    document.getElementById("oopencash").innerHTML = butt;
    //document.getElementById("store_close_message").innerHTML=gdd;
    $('#myModal3').modal('show');
    //document.getElementById("store_close_message").innerHTML=xmlhttp.responseText;
    $.jGrowl('Please Give Opening Store Balance.', {sticky: false, theme: 'growl-info', header: 'Required!'});

}


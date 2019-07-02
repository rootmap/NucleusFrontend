$.ajaxSetup({ cache: false });
// JavaScript Document
/*$(document).ready(function(){
  $("button").click(function(){
    $("#div1").fadeOut(200);
    $("#div2").fadeOut("slow");
    $("#div3").fadeOut(3000);
  });
});*/

function printDiv(divID,amount,total_collection_cash_credit_card,cash_collected_plus,credit_card_collected_plus,opening_cash_plus,opening_credit_card_plus,payout_plus_min,buyback_min,tax_min,current_cash,current_credit_card)
	{
            var divElements = document.getElementById(divID).innerHTML;
            var oldPage = document.body.innerHTML;
            document.body.innerHTML = "<html><head><title></title></head><body>" + divElements + "</body>";
			window.open("pos.php?storecloseingmm="+amount+"&total_collection_cash_credit_card="+total_collection_cash_credit_card+"&cash_collected_plus="+cash_collected_plus+"&credit_card_collected_plus="+credit_card_collected_plus+"&opening_cash_plus="+opening_cash_plus+"&opening_credit_card_plus="+opening_credit_card_plus+"&payout_plus_min="+payout_plus_min+"&buyback_min="+buyback_min+"&tax_min="+tax_min+"&current_cash="+current_cash+"&current_credit_card="+current_credit_card);
            window.print();
        }

function new_customer(pid,cart) {
  
  //$('#myModal').modal({ show: 'false' }); 
  //$("#myModal1").dialog('modal');
  if(pid==0)
  {
//	$("#cus_sel").css("padding-top","20px");  
//	$("#newcus_block").show(); 
//	$("#newcus_block").css("padding-bottom","10px;");
//	$("#newcus_label").show();
//	document.getElementById('newcus_label').innerHTML="Full Name : ";
//	$("#newcus").show();  
//	if (pid=="") {
//		document.getElementById('newcus').innerHTML="";
//		return;
//	  }
//	  if (window.XMLHttpRequest) {
//		// code for IE7+, Firefox, Chrome, Opera, Safari
//		xmlhttp=new XMLHttpRequest();
//	  } else { // code for IE6, IE5
//		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
//	  }
//	  xmlhttp.onreadystatechange=function() {
//		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
//		  document.getElementById('newcus').innerHTML=xmlhttp.responseText;
//		}
//	  }  
//	  
//	st=1;  
//  	xmlhttp.open("GET","ajax/new_customer.php?name="+pid+"&st="+st,true);
//  	xmlhttp.send();
        $("#NcM").click();
  }
  else
  {
	$("#new_business").css("padding-top","10px"); 
	$("#newcus_block").hide();
	if (pid=="") {
		document.getElementById('cus_sel').innerHTML="";
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
                  location.reload();
		  document.getElementById('cus_sel').innerHTML=xmlhttp.responseText;
		}
	  }  
	  
	st=101;
	xmlhttp.open("GET","ajax/new_customer.php?name="+pid+"&st="+st+"&cart="+cart,true);
  	xmlhttp.send();
  }
}


function save_customer() {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      //document.getElementById('newcus').innerHTML=xmlhttp.responseText;
	  url="invoice.php";
	  window.location.replace(url);
    }
  }
  st=2;
  pid=document.getElementById('name').value;
  if(pid!='')
  {
  xmlhttp.open("GET","ajax/new_customer.php?name="+pid+"&st="+st,true);
  xmlhttp.send();
  }
}


function get_data_cus_invoice(table,id,val,uf,uff,cid) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		url="create_invoice.php?cid="+cid;
	    window.location.replace(url);
      //document.getElementById(uff).innerHTML=xmlhttp.responseText;
    }
  }
  st=44;

  xmlhttp.open("GET","ajax/new_customer.php?table="+table+"&id="+id+"&val="+val+"&uf="+uf+"&st="+st+"&uff="+uff,true);
  xmlhttp.send();
}



function get_data_cus(table,id,val,uf) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById(uf).innerHTML=xmlhttp.responseText;
    }
  }
  st=4;

  xmlhttp.open("GET","ajax/new_customer.php?table="+table+"&id="+id+"&val="+val+"&uf="+uf+"&st="+st,true);
  xmlhttp.send();


}

function get_data_cus_two(table,id,val,uf) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById(uf).innerHTML=xmlhttp.responseText;
    }
  }
  st=8;

  xmlhttp.open("GET","ajax/new_customer.php?table="+table+"&id="+id+"&val="+val+"&uf="+uf+"&st="+st,true);
  xmlhttp.send();
}




function update_two(table,id,val,uf) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } 
  else 
  { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById(uf).innerHTML=xmlhttp.responseText;
    }
  }
  st=9;
  paid=document.getElementById("paid").checked;
  if(paid==true)
  {
	uvv=2;
	xmlhttp.open("GET","ajax/new_customer.php?table="+table+"&id="+id+"&val="+val+"&uf="+uf+"&uv="+uvv+"&st="+st,true);
	xmlhttp.send();
  }
  else
  {
	  uv=document.getElementById("name").checked;
	  if(uv==true)
	  {
		uvv=1;
		xmlhttp.open("GET","ajax/new_customer.php?table="+table+"&id="+id+"&val="+val+"&uf="+uf+"&uv="+uvv+"&st="+st,true);
		xmlhttp.send();
	  }
	  else
	  {
		uvv=0;
		xmlhttp.open("GET","ajax/new_customer.php?table="+table+"&id="+id+"&val="+val+"&uf="+uf+"&uv="+uvv+"&st="+st,true);
		xmlhttp.send();
	  }
  }

}

function update(table,id,val,uf) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById(uf).innerHTML=xmlhttp.responseText;
    }
  }
  st=5;
  uv=document.getElementById('name').value;
  if(uv!='')
  {
  xmlhttp.open("GET","ajax/new_customer.php?table="+table+"&id="+id+"&val="+val+"&uf="+uf+"&uv="+uv+"&st="+st,true);
  xmlhttp.send();
  }

}


function invoice_creator(cart) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById('creator').innerHTML=xmlhttp.responseText;
    }
  }
  st=6;

  xmlhttp.open("GET","ajax/new_customer.php?st="+st+"&cart="+cart,true);
  xmlhttp.send();


}

function save_invoice_creator(invoice_id) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById('creator').innerHTML=xmlhttp.responseText;
    }
  }
  st=7;
  creators=document.getElementById('creators').value;
  if(creators!='')
  {
	  xmlhttp.open("GET","ajax/new_customer.php?st="+st+"&creator="+creators+"&invoice_id="+invoice_id,true);
	  xmlhttp.send();
  }


}


function pos_tax(invoice_id,status) 
{
  if(window.XMLHttpRequest)
  {
    xmlhttp=new XMLHttpRequest();
  } else {
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
		url="pos.php";
	    window.location.replace(url);
		//document.getElementById('pos_tax').innerHTML=xmlhttp.responseText;
    }
  }
  st=1;
  xmlhttp.open("GET","ajax/pos.php?st="+st+"&invoice_id="+invoice_id+"&status="+status,true);
  xmlhttp.send();
}

function punchin()
{
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	  //$("#punchtime").fadeOut();
	  //$("#punchtime").fadeIn();
          $(".k-i-refresh").click();
            //document.getElementById("punchtime").innerHTML=xmlhttp.responseText;
    }
  }
  indate=document.getElementById('indate').value;
  if(indate=='')
  {
  	document.getElementById("punchtime").innerHTML="Please Select A Date";
  }
  else
  {
	st=3;
  	xmlhttp.open("GET","ajax/pos.php?st="+st+"&date="+indate,true);
  	xmlhttp.send();  
  }
}
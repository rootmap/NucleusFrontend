// JavaScript Document
/*$(document).ready(function(){
  $("button").click(function(){
    $("#div1").fadeOut(200);
    $("#div2").fadeOut("slow");
    $("#div3").fadeOut(3000);
  });
});*/

function auto_sales(pid,sales_id) {
  if (pid=="") {
    document.getElementById("msg").innerHTML="";
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
	  //load sales list	
	  xmlhttps=new XMLHttpRequest();
	  xmlhttps.onreadystatechange=function() {
		if (xmlhttps.readyState==4 && xmlhttps.status==200) {
		  
		  $("#sales_list").fadeOut();
		  $("#sales_list").fadeIn();
		  document.getElementById("sales_list").innerHTML=xmlhttps.responseText;
		}
	  }
	  xmlhttps.open("GET","ajax/load_sales_list_invoice.php?sales_id="+sales_id,true);
	  xmlhttps.send();
	  //load sales list
	  
	  
	  //load sales subtotal list	
	  xmlhttpss=new XMLHttpRequest();
	  xmlhttpss.onreadystatechange=function() {
		if (xmlhttpss.readyState==4 && xmlhttpss.status==200) {
		  
		  $("#subtotal_list").fadeOut();
		  $("#subtotal_list").fadeIn();
		  document.getElementById("subtotal_list").innerHTML=xmlhttpss.responseText;
		}
	  }
	  xmlhttpss.open("GET","ajax/load_sales_list_cal_invoice.php?sales_id="+sales_id,true);
	  xmlhttpss.send();
	  //load sales subtotal list
	  
	  $("#msg").fadeOut();
	  $("#msg").fadeIn();
      document.getElementById("msg").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","ajax/auto_sales_invoice.php?pid="+pid+"&sales_id="+sales_id,true);
  xmlhttp.send();
}

function barcode_sales(barcode,sales_id) {
  if (barcode=="") {
    document.getElementById("msg").innerHTML="";
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
	  //load sales list	
	  xmlhttps=new XMLHttpRequest();
	  xmlhttps.onreadystatechange=function() {
		if (xmlhttps.readyState==4 && xmlhttps.status==200) {
		  
		  $("#sales_list").fadeOut();
		  $("#sales_list").fadeIn();
		  document.getElementById("sales_list").innerHTML=xmlhttps.responseText;
		}
	  }
	  xmlhttps.open("GET","ajax/load_sales_list_invoice.php?sales_id="+sales_id,true);
	  xmlhttps.send();
	  //load sales list
	  
	  
	  //load sales subtotal list	
	  xmlhttpss=new XMLHttpRequest();
	  xmlhttpss.onreadystatechange=function() {
		if (xmlhttpss.readyState==4 && xmlhttpss.status==200) {
		  
		  $("#subtotal_list").fadeOut();
		  $("#subtotal_list").fadeIn();
		  document.getElementById("subtotal_list").innerHTML=xmlhttpss.responseText;
		}
	  }
	  xmlhttpss.open("GET","ajax/load_sales_list_cal_invoice.php?sales_id="+sales_id,true);
	  xmlhttpss.send();
	  //load sales subtotal list
	  
	  $("#msg").fadeOut();
	  $("#msg").fadeIn();
      document.getElementById("msg").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","ajax/barcode_sales_invoice.php?barcode="+barcode+"&sales_id="+sales_id,true);
  xmlhttp.send();
}


function inventory_sales(sales_id) {
  if (sales_id=="") {
    document.getElementById("msg").innerHTML="";
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
	  //load sales list	
	  xmlhttps=new XMLHttpRequest();
	  xmlhttps.onreadystatechange=function() {
		if (xmlhttps.readyState==4 && xmlhttps.status==200) {
		  
		  $("#sales_list").fadeOut();
		  $("#sales_list").fadeIn();
		  document.getElementById("sales_list").innerHTML=xmlhttps.responseText;
		}
	  }
	  xmlhttps.open("GET","ajax/load_sales_list_invoice.php?sales_id="+sales_id,true);
	  xmlhttps.send();
	  //load sales list
	  
	  
	  //load sales subtotal list	
	  xmlhttpss=new XMLHttpRequest();
	  xmlhttpss.onreadystatechange=function() {
		if (xmlhttpss.readyState==4 && xmlhttpss.status==200) {
		  
		  $("#subtotal_list").fadeOut();
		  $("#subtotal_list").fadeIn();
		  document.getElementById("subtotal_list").innerHTML=xmlhttpss.responseText;
		}
	  }
	  xmlhttpss.open("GET","ajax/load_sales_list_cal_invoice.php?sales_id="+sales_id,true);
	  xmlhttpss.send();
	  //load sales subtotal list
	  
	  $("#msg").fadeOut();
	  $("#msg").fadeIn();
      document.getElementById("msg").innerHTML=xmlhttp.responseText;
    }
  }
  pid=document.getElementById('pids').value;
  
  quantity=document.getElementById('quan').value;
  if(quantity!='')
  {
  xmlhttp.open("GET","ajax/inventory_sales_invoice.php?pid="+pid+"&sales_id="+sales_id+"&quantity="+quantity,true);
  xmlhttp.send();
  }
  else
  {
	  $("#msg").fadeOut();
	  $("#msg").fadeIn();
      document.getElementById("msg").innerHTML="Check Quantity Field";
  }
}



function manual_sales(sales_id) {
  if (sales_id=="") {
    document.getElementById("msg").innerHTML="";
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
	  //load sales list	
	  xmlhttps=new XMLHttpRequest();
	  xmlhttps.onreadystatechange=function() {
		if (xmlhttps.readyState==4 && xmlhttps.status==200) {
		  
		  $("#sales_list").fadeOut();
		  $("#sales_list").fadeIn();
		  document.getElementById("sales_list").innerHTML=xmlhttps.responseText;
		}
	  }
	  xmlhttps.open("GET","ajax/load_sales_list_invoice.php?sales_id="+sales_id,true);
	  xmlhttps.send();
	  //load sales list
	  
	  
	  //load sales subtotal list	
	  xmlhttpss=new XMLHttpRequest();
	  xmlhttpss.onreadystatechange=function() {
		if (xmlhttpss.readyState==4 && xmlhttpss.status==200) {
		  
		  $("#subtotal_list").fadeOut();
		  $("#subtotal_list").fadeIn();
		  document.getElementById("subtotal_list").innerHTML=xmlhttpss.responseText;
		}
	  }
	  xmlhttpss.open("GET","ajax/load_sales_list_cal_invoice.php?sales_id="+sales_id,true);
	  xmlhttpss.send();
	  //load sales subtotal list
	  
	  $("#msg").fadeOut();
	  $("#msg").fadeIn();
      document.getElementById("msg").innerHTML=xmlhttp.responseText;
    }
  }
  pid=document.getElementById('pid').value;
  price=document.getElementById('price').value;
  quantity=document.getElementById('quantity').value;
  xmlhttp.open("GET","ajax/manual_sales_invoice.php?pid="+pid+"&sales_id="+sales_id+"&price="+price+"&quantity="+quantity,true);
  xmlhttp.send();
}



function delete_sales(pid,sales_id) {
  if (pid=="") {
    document.getElementById("msg").innerHTML="";
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
	  //load sales list	
	  xmlhttps=new XMLHttpRequest();
	  xmlhttps.onreadystatechange=function() {
		if (xmlhttps.readyState==4 && xmlhttps.status==200) {
		  
		  $("#sales_list").fadeOut();
		  $("#sales_list").fadeIn();
		  document.getElementById("sales_list").innerHTML=xmlhttps.responseText;
		}
	  }
	  xmlhttps.open("GET","ajax/load_sales_list_invoice.php?sales_id="+sales_id,true);
	  xmlhttps.send();
	  //load sales list
	  
	  
	  //load sales subtotal list	
	  xmlhttpss=new XMLHttpRequest();
	  xmlhttpss.onreadystatechange=function() {
		if (xmlhttpss.readyState==4 && xmlhttpss.status==200) {
		  
		  $("#subtotal_list").fadeOut();
		  $("#subtotal_list").fadeIn();
		  document.getElementById("subtotal_list").innerHTML=xmlhttpss.responseText;
		}
	  }
	  xmlhttpss.open("GET","ajax/load_sales_list_cal_invoice.php?sales_id="+sales_id,true);
	  xmlhttpss.send();
	  //load sales subtotal list
	  
	  $("#msg").fadeOut();
	  $("#msg").fadeIn();
      document.getElementById("msg").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","ajax/delete_sales_invoice.php?pid="+pid+"&sales_id="+sales_id,true);
  xmlhttp.send();
}

function tax_invoice(str) {
  if (str=="") {
    document.getElementById("msg").innerHTML="";
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
      document.getElementById("msg").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","tax_sales_invoice.php?q="+str,true);
  xmlhttp.send();
}
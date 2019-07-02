// JavaScript Document
/*$(document).ready(function(){
  $("button").click(function(){
    $("#div1").fadeOut(200);
    $("#div2").fadeOut("slow");
    $("#div3").fadeOut(3000);
  });
});*/
function new_customer(pid) {
  if (pid=="") {
    document.getElementById('newcus').innerHTML="";
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
	  //load save
	  xmlhttps=new XMLHttpRequest();
	  xmlhttps.onreadystatechange=function() {
		if (xmlhttps.readyState==4 && xmlhttps.status==200) {
			
		  document.getElementById('but').innerHTML=xmlhttps.responseText;
		}
	  }
	  sts=3;
	  xmlhttps.open("GET","ajax/new_customer.php?name="+pid+"&st="+sts,true);
	  xmlhttps.send();
	  //load save
      document.getElementById('newcus').innerHTML=xmlhttp.responseText;
      
    }
  }
  st=1;
  
  if(pid==0)
  {
  xmlhttp.open("GET","ajax/new_customer.php?name="+pid+"&st="+st,true);
  xmlhttp.send();
  }
  else
  {
	  url="create_invoice.php?cid="+pid;
	  window.location.replace(url);
  }
}

function new_customer_estimate(pid) {
  if (pid=="") {
    document.getElementById('newcus').innerHTML="";
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
	  //load save
	  xmlhttps=new XMLHttpRequest();
	  xmlhttps.onreadystatechange=function() {
		if (xmlhttps.readyState==4 && xmlhttps.status==200) {
			
		  document.getElementById('but').innerHTML=xmlhttps.responseText;
		}
	  }
	  sts=3;
	  xmlhttps.open("GET","ajax/new_customer.php?name="+pid+"&st="+sts,true);
	  xmlhttps.send();
	  //load save
      document.getElementById('newcus').innerHTML=xmlhttp.responseText;
    }
  }
  st=1;
  
  if(pid==0)
  {
  xmlhttp.open("GET","ajax/new_customer.php?name="+pid+"&st="+st,true);
  xmlhttp.send();
  }
  else
  {
	  url="create_estimate.php?newsales=1&cid="+pid;
	  window.location.replace(url);
  }
}

function new_customer_checkin(pid) {
  if (pid=="") {
    document.getElementById('newcus').innerHTML="";
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
	  //load save
	  xmlhttps=new XMLHttpRequest();
	  xmlhttps.onreadystatechange=function() {
		if (xmlhttps.readyState==4 && xmlhttps.status==200) {
			
		  document.getElementById('but').innerHTML=xmlhttps.responseText;
		}
	  }
	  sts=3;
	  xmlhttps.open("GET","ajax/new_customer.php?name="+pid+"&st="+sts,true);
	  xmlhttps.send();
	  //load save
      document.getElementById('newcus').innerHTML=xmlhttp.responseText;
    }
  }
  st=102;
  xmlhttp.open("GET","ajax/new_customer.php?name="+pid+"&st="+st,true);
  xmlhttp.send();
}



function new_customer_ticket(pid) {
  if (pid=="") {
    document.getElementById('newcus').innerHTML="";
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
	  //load save
	  xmlhttps=new XMLHttpRequest();
	  xmlhttps.onreadystatechange=function() {
		if (xmlhttps.readyState==4 && xmlhttps.status==200) {
			
		  document.getElementById('but').innerHTML=xmlhttps.responseText;
		}
	  }
	  sts=3;
	  xmlhttps.open("GET","ajax/new_customer.php?name="+pid+"&st="+sts,true);
	  xmlhttps.send();
	  //load save
      document.getElementById('newcus').innerHTML=xmlhttp.responseText;
    }
  }
  st=1;
  
  if(pid==0)
  {
  xmlhttp.open("GET","ajax/new_customer.php?name="+pid+"&st="+st,true);
  xmlhttp.send();
  }
  else
  {
	  url="create_ticket.php?cid="+pid;
	  window.location.replace(url);
  }
}



function new_customer_unlock(pid) {
  if (pid=="") {
    document.getElementById('newcus').innerHTML="";
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
	  //load save
	  xmlhttps=new XMLHttpRequest();
	  xmlhttps.onreadystatechange=function() {
		if (xmlhttps.readyState==4 && xmlhttps.status==200) {
			
		  document.getElementById('but').innerHTML=xmlhttps.responseText;
		}
	  }
	  sts=3;
	  xmlhttps.open("GET","ajax/new_customer.php?name="+pid+"&st="+sts,true);
	  xmlhttps.send();
	  //load save
      document.getElementById('newcus').innerHTML=xmlhttp.responseText;
    }
  }
  st=1;
  
  if(pid==0)
  {
  xmlhttp.open("GET","ajax/new_customer.php?name="+pid+"&st="+st,true);
  xmlhttp.send();
  }
  else
  {
	  url="create_unlock.php?cid="+pid;
	  window.location.replace(url);
  }
}


function new_customer_buyback(pid) {
  if (pid=="") {
    document.getElementById('newcus').innerHTML="";
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
	  //load save
	  xmlhttps=new XMLHttpRequest();
	  xmlhttps.onreadystatechange=function() {
		if (xmlhttps.readyState==4 && xmlhttps.status==200) {
			
		  document.getElementById('but').innerHTML=xmlhttps.responseText;
		}
	  }
	  sts=3;
	  xmlhttps.open("GET","ajax/new_customer.php?name="+pid+"&st="+sts,true);
	  xmlhttps.send();
	  //load save
      document.getElementById('newcus').innerHTML=xmlhttp.responseText;
    }
  }
  st=1;
  
  if(pid==0)
  {
  xmlhttp.open("GET","ajax/new_customer.php?name="+pid+"&st="+st,true);
  xmlhttp.send();
  }
  else
  {
	  url="create_buyback.php?cid="+pid+"&newticket=1";
	  window.location.replace(url);
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
  var pid=document.getElementById('name').value;
  if(pid!='')
  {
  xmlhttp.open("GET","ajax/new_customer.php?name="+pid+"&st="+st,true);
  xmlhttp.send();
  }
}

function newcustomerticket(pid) {
  if (pid=="") {
    document.getElementById('newcus').innerHTML="";
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
	  //load save
	  xmlhttps=new XMLHttpRequest();
	  xmlhttps.onreadystatechange=function() {
		if (xmlhttps.readyState==4 && xmlhttps.status==200) {
			
		  document.getElementById('but').innerHTML=xmlhttps.responseText;
		}
	  }
	  sts=303;
	  xmlhttps.open("GET","ajax/new_customer.php?name="+pid+"&st="+sts,true);
	  xmlhttps.send();
	  //load save
      document.getElementById('newcus').innerHTML=xmlhttp.responseText;
    }
  }
  st=301;
  
  if(pid==0)
  {
    xmlhttp.open("GET","ajax/new_customer.php?name="+pid+"&st="+st,true);
    xmlhttp.send();
  }
  else
  {
	  url="create_ticket.php?cid="+pid;
	  window.location.replace(url);
  }
}

function save_customer_from_ticket() {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      //document.getElementById('newcus').innerHTML=xmlhttp.responseText;
	  url="create_ticket.php?cid="+xmlhttp.responseText;
	  window.location.replace(url);
    }
  }
  st=302;
  var firstname=document.getElementById('firstname').value;
  var lastname=document.getElementById('lastname').value;
  var email=document.getElementById('email').value;
  var phone=document.getElementById('phone').value;
  if(firstname!='' && lastname!='' && email!='' && phone!='')
  {
      xmlhttp.open("GET","ajax/new_customer.php?firstname="+firstname+"&lastname="+lastname+"&email="+email+"&phone="+phone+"&st="+st,true);
      xmlhttp.send();
      document.getElementById('mess').innerHTML="<label class='label label-info'>Processing please wait..</label>";
  }
  else
  {
      document.getElementById('mess').innerHTML="<label class='label label-warning'>Please fillup all field.</label>";
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
		url="create_estimate.php?cid="+cid;
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


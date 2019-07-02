function new_problem(pid,msg) {
  if (pid=="") {
    document.getElementById(msg).innerHTML="";
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
      document.getElementById(msg).innerHTML=xmlhttp.responseText;
    }
  }
  if(pid==0)
  {
  xmlhttp.open("GET","ajax/new_problem.php?pid="+pid,true);
  xmlhttp.send();
  }
}

function find_estimate(pid,msg) {

  nid=document.getElementById('nid').value;
  dtid=document.getElementById('dtid').value;
  cid=document.getElementById('cid').value;
  dtoid=document.getElementById('dtoid').value;
  wdid=document.getElementById('wdid').value;
  model=document.getElementById('model').value;
  msid=document.getElementById('msid').value;	
	
  if (pid=="") {
    document.getElementById(msg).innerHTML="";
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
      document.getElementById(msg).innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","ajax/find.php?id="+pid+"&nid="+nid+"&dtid="+dtid+"&cid="+cid+"&dtoid="+dtoid+"&wdid="+wdid+"&msid="+msid+"&model="+model,true);
  xmlhttp.send();
}


function pagerelocate(pagename) {
  window.location.replace(pagename);
}

function asset_type(id) 
{	
  if(id==0)
  {
  	  url="asset_type.php";
	  window.location.replace(url);
  }
}

function save_asset() 
{
  type_id=document.getElementById('type_id').value;
  asset_name=document.getElementById('asset_name').value;
  serial_number=document.getElementById('serial_number').value;
  make=document.getElementById('make').value;
  model=document.getElementById('model').value;
  service_tag=document.getElementById('service_tag').value;
  
  if (asset_name=="") {
    document.getElementById('msg_pros').innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	   //load saved asset
	   	 xmlhttps=new XMLHttpRequest();
	     xmlhttps.onreadystatechange=function() {
		if (xmlhttps.readyState==4 && xmlhttps.status==200) 
		{
		  $("#asset_list").fadeOut();
		  $("#asset_list").fadeIn();	
		  document.getElementById('asset_list').innerHTML=xmlhttps.responseText;
		}
	  }
	  st=2;
	  xmlhttps.open("GET","ajax/asset.php?st="+st,true);
	  xmlhttps.send();
	  
	  xmlhttpss=new XMLHttpRequest();
	     xmlhttpss.onreadystatechange=function() {
		if (xmlhttpss.readyState==4 && xmlhttpss.status==200) 
		{
		  $("#allexasset").fadeOut();
		  $("#allexasset").fadeIn();	
		  document.getElementById('allexasset').innerHTML=xmlhttpss.responseText;
		}
	  }
	  st=22;
	  xmlhttpss.open("GET","ajax/asset.php?st="+st,true);
	  xmlhttpss.send();
	   //load saved asset	
		
	  $("#msg_pros").fadeOut();
	  $("#msg_pros").fadeIn();	
      document.getElementById('msg_pros').innerHTML=xmlhttp.responseText;
    }
  }
  st=1;
  xmlhttp.open("GET","ajax/asset.php?st="+st+"&type_id="+type_id+"&asset_name="+asset_name+"&serial_number="+serial_number+"&make="+make+"&model="+model+"&service_tag="+service_tag,true);
  xmlhttp.send();
}

function delete_asset(id) {
  if (id=="") {
    document.getElementById("msg_pros").innerHTML="";
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
	  //load saved asset
	   	 xmlhttps=new XMLHttpRequest();
	     xmlhttps.onreadystatechange=function() {
		if (xmlhttps.readyState==4 && xmlhttps.status==200) 
		{
		  $("#asset_list").fadeOut();
		  $("#asset_list").fadeIn();	
		  document.getElementById('asset_list').innerHTML=xmlhttps.responseText;
		}
	  }
	  st=2;
	  xmlhttps.open("GET","ajax/asset.php?st="+st,true);
	  xmlhttps.send();
	  
	  xmlhttpss=new XMLHttpRequest();
	     xmlhttpss.onreadystatechange=function() {
		if (xmlhttpss.readyState==4 && xmlhttpss.status==200) 
		{
		  $("#allexasset").fadeOut();
		  $("#allexasset").fadeIn();	
		  document.getElementById('allexasset').innerHTML=xmlhttpss.responseText;
		}
	  }
	  st=22;
	  xmlhttpss.open("GET","ajax/asset.php?st="+st,true);
	  xmlhttpss.send();
	   //load saved asset	
		
	  $("#msg_pros").fadeOut();
	  $("#msg_pros").fadeIn();	
      document.getElementById("msg_pros").innerHTML=xmlhttp.responseText;
    }
  }
  st=3;
  xmlhttp.open("GET","ajax/asset.php?st="+st+"&id="+id,true);
  xmlhttp.send();
}

function edit_asset(id) {
  if (id=="") {
    document.getElementById("create_asset").innerHTML="";
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
	  $("#create_asset").fadeOut();
	  $("#create_asset").fadeIn();	
      document.getElementById("create_asset").innerHTML=xmlhttp.responseText;
    }
  }
  st=4;
  xmlhttp.open("GET","ajax/asset.php?st="+st+"&id="+id,true);
  xmlhttp.send();
}

function update_asset(id) 
{
  type_id=document.getElementById('type_id').value;
  asset_name=document.getElementById('asset_name').value;
  serial_number=document.getElementById('serial_number').value;
  make=document.getElementById('make').value;
  model=document.getElementById('model').value;
  service_tag=document.getElementById('service_tag').value;
  
  if (asset_name=="") {
    document.getElementById('msg_pros').innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	   //load saved asset
	   	 xmlhttps=new XMLHttpRequest();
	     xmlhttps.onreadystatechange=function() {
		if (xmlhttps.readyState==4 && xmlhttps.status==200) 
		{
		  $("#asset_list").fadeOut();
		  $("#asset_list").fadeIn();	
		  document.getElementById('asset_list').innerHTML=xmlhttps.responseText;
		}
	  }
	  st=2;
	  xmlhttps.open("GET","ajax/asset.php?st="+st,true);
	  xmlhttps.send();
	  
	  xmlhttpss=new XMLHttpRequest();
	     xmlhttpss.onreadystatechange=function() {
		if (xmlhttpss.readyState==4 && xmlhttpss.status==200) 
		{
		  $("#allexasset").fadeOut();
		  $("#allexasset").fadeIn();	
		  document.getElementById('allexasset').innerHTML=xmlhttpss.responseText;
		}
	  }
	  st=22;
	  xmlhttpss.open("GET","ajax/asset.php?st="+st,true);
	  xmlhttpss.send();
	   //load saved asset	
		
	  $("#msg_pros").fadeOut();
	  $("#msg_pros").fadeIn();	
      document.getElementById('msg_pros').innerHTML=xmlhttp.responseText;
    }
  }
  st=5;
  xmlhttp.open("GET","ajax/asset.php?st="+st+"&type_id="+type_id+"&asset_name="+asset_name+"&serial_number="+serial_number+"&make="+make+"&model="+model+"&service_tag="+service_tag+"&id="+id,true);
  xmlhttp.send();
}

function ticket_asset(id,tid) 
{
  if (id=="") {
    document.getElementById('msg_pro').innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	   //load saved asset
	   	 xmlhttps=new XMLHttpRequest();
	     xmlhttps.onreadystatechange=function() {
		if (xmlhttps.readyState==4 && xmlhttps.status==200) 
		{
		  $("#asset_ticket_list").fadeOut();
		  $("#asset_ticket_list").fadeIn();	
		  document.getElementById('asset_ticket_list').innerHTML=xmlhttps.responseText;
		}
	  }
	  st=7;
	  xmlhttps.open("GET","ajax/asset.php?st="+st+"&tid="+tid,true);
	  xmlhttps.send();
	  
	   xmlhttpss=new XMLHttpRequest();
	     xmlhttpss.onreadystatechange=function() {
		if (xmlhttpss.readyState==4 && xmlhttpss.status==200) 
		{
		  $("#allexasset").fadeOut();
		  $("#allexasset").fadeIn();	
		  document.getElementById('allexasset').innerHTML=xmlhttpss.responseText;
		}
	  }
	  st=8;
	  xmlhttpss.open("GET","ajax/asset.php?st="+st+"&tid="+tid,true);
	  xmlhttpss.send();
	  //load asset
	  $("#msg_pro").fadeOut();
	  $("#msg_pro").fadeIn();	
      document.getElementById('msg_pro').innerHTML=xmlhttp.responseText;
    }
  }
  st=6;
  xmlhttp.open("GET","ajax/asset.php?st="+st+"&id="+id+"&tid="+tid,true);
  xmlhttp.send();
}

function delete_ticket_asset(id,tid) 
{
  if (id=="") {
    document.getElementById('msg_pro').innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	   //load saved asset
	   	 xmlhttps=new XMLHttpRequest();
	     xmlhttps.onreadystatechange=function() {
		if (xmlhttps.readyState==4 && xmlhttps.status==200) 
		{
		  $("#asset_ticket_list").fadeOut();
		  $("#asset_ticket_list").fadeIn();	
		  document.getElementById('asset_ticket_list').innerHTML=xmlhttps.responseText;
		}
	  }
	  st=7;
	  xmlhttps.open("GET","ajax/asset.php?st="+st+"&tid="+tid,true);
	  xmlhttps.send();
	  
	   xmlhttpss=new XMLHttpRequest();
	     xmlhttpss.onreadystatechange=function() {
		if (xmlhttpss.readyState==4 && xmlhttpss.status==200) 
		{
		  $("#allexasset").fadeOut();
		  $("#allexasset").fadeIn();	
		  document.getElementById('allexasset').innerHTML=xmlhttpss.responseText;
		}
	  }
	  st=8;
	  xmlhttpss.open("GET","ajax/asset.php?st="+st+"&tid="+tid,true);
	  xmlhttpss.send();
	  //load asset
	  $("#msg_pro").fadeOut();
	  $("#msg_pro").fadeIn();	
      document.getElementById('msg_pro').innerHTML=xmlhttp.responseText;
    }
  }
  st=9;
  xmlhttp.open("GET","ajax/asset.php?st="+st+"&id="+id+"&tid="+tid,true);
  xmlhttp.send();
}


function common_field_edit(table,field1,fval1,fetch1,fetchplace,id) 
{
  if (fetch1=="") 
  {
    document.getElementById(fetchplace).innerHTML="";
    return;
  }
  
  if (window.XMLHttpRequest) 
  {
    xmlhttp=new XMLHttpRequest();
  } 
  else 
  { 
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=1;
  xmlhttp.open("GET","ajax/common.php?st="+st+"&field="+field1+"&value="+fval1+"&fetch="+fetch1+"&table="+table+"&fetchplace="+fetchplace+"&id="+id,true);
  xmlhttp.send();
}

function common_field_done(table,field1,fval1,fetch1,fetchplace,id,idval,auto_id) 
{
  if (fetch1=="") 
  {
    document.getElementById(fetchplace).innerHTML="";
    return;
  }
  
  if (window.XMLHttpRequest) 
  {
    xmlhttp=new XMLHttpRequest();
  } 
  else 
  { 
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=2;
  fatval=document.getElementById(auto_id).value;
  xmlhttp.open("GET","ajax/common.php?st="+st+"&field="+field1+"&value="+fval1+"&fetch="+fetch1+"&table="+table+"&fetchplace="+fetchplace+"&id="+id+"&idval="+idval+"&auto_val="+fatval,true);
  xmlhttp.send();
}

function common_field_edit_check(table,field1,fval1,fetch1,fetchplace,id) 
{
  if (fetch1=="") 
  {
    document.getElementById(fetchplace).innerHTML="";
    return;
  }
  
  if (window.XMLHttpRequest) 
  {
    xmlhttp=new XMLHttpRequest();
  } 
  else 
  { 
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=3;
  xmlhttp.open("GET","ajax/common.php?st="+st+"&field="+field1+"&value="+fval1+"&fetch="+fetch1+"&table="+table+"&fetchplace="+fetchplace+"&id="+id,true);
  xmlhttp.send();
}

function common_field_done_check(table,field1,fval1,fetch1,fetchplace,id,idval,auto_id) 
{
  if (fetch1=="") 
  {
    document.getElementById(fetchplace).innerHTML="";
    return;
  }
  
  if (window.XMLHttpRequest) 
  {
    xmlhttp=new XMLHttpRequest();
  } 
  else 
  { 
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=4;
  fatval=document.getElementById(auto_id).checked;
  if(fatval==1){ fb=1; }else{ fb=0; }
  xmlhttp.open("GET","ajax/common.php?st="+st+"&field="+field1+"&value="+fval1+"&fetch="+fetch1+"&table="+table+"&fetchplace="+fetchplace+"&id="+id+"&idval="+idval+"&auto_val="+fb,true);
  xmlhttp.send();
}

function custom_field_select(ticket_id,fid,fetchplace,fetplace_two) 
{
  if (ticket_id=="") 
  {
    document.getElementById(fetchplace).innerHTML="";
    return;
  }
  
  if (window.XMLHttpRequest) 
  { xmlhttp=new XMLHttpRequest(); } 
  else 
  { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function() 
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
		//load all fetch place
		xmlhttps=new XMLHttpRequest();
		xmlhttps.onreadystatechange=function() 
		  {
			if (xmlhttps.readyState==4 && xmlhttps.status==200) 
			{
			  $("#"+fetplace_two).fadeOut();
			  $("#"+fetplace_two).fadeIn();	
			  document.getElementById(fetplace_two).innerHTML=xmlhttps.responseText;
			}
		  }
		  st=2;
		  xmlhttps.open("GET","ajax/ticket.php?st="+st+"&ticket_id="+ticket_id,true);
		  xmlhttps.send();
	   //load all fetch place
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=1;
  xmlhttp.open("GET","ajax/ticket.php?st="+st+"&ticket_id="+ticket_id+"&fid="+fid,true);
  xmlhttp.send();
  //window.alert('Ticket Id : '+ticket_id+" Fields ID : "+fid+" Fetchplace : "+fetchplace+" 2nd Place : "+fetplace_two);
}

function custom_field_select_delete(sid,ticket_id,fid,fetchplace,fetplace_two) 
{
  if (ticket_id=="") 
  {
    document.getElementById(fetchplace).innerHTML="";
    return;
  }
  
  if (window.XMLHttpRequest) 
  { xmlhttp=new XMLHttpRequest(); } 
  else 
  { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function() 
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
		//load all fetch place
		xmlhttps=new XMLHttpRequest();
		xmlhttps.onreadystatechange=function() 
		  {
			if (xmlhttps.readyState==4 && xmlhttps.status==200) 
			{
			  $("#"+fetplace_two).fadeOut();
			  $("#"+fetplace_two).fadeIn();	
			  document.getElementById(fetplace_two).innerHTML=xmlhttps.responseText;
			}
		  }
		  st=2;
		  xmlhttps.open("GET","ajax/ticket.php?st="+st+"&ticket_id="+ticket_id,true);
		  xmlhttps.send();
	   //load all fetch place
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=3;
  xmlhttp.open("GET","ajax/ticket.php?st="+st+"&ticket_id="+ticket_id+"&fid="+fid+"&sid="+sid,true);
  xmlhttp.send();
}

function SingleFieldEdit(table,field1,fval1,fetch1,fetchplace) 
{
	//window.alert("Hahah");
  if (fetch1=="") 
  {
    document.getElementById(fetchplace).innerHTML="";
    return;
	window.alert("Erro");
  }
  
  if (window.XMLHttpRequest) 
  {
    xmlhttp=new XMLHttpRequest();
  } 
  else 
  { 
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=5;
	xmlhttp.open("GET","ajax/common.php?st="+st+"&field="+field1+"&value="+fval1+"&fetch="+fetch1+"&table="+table+"&fetchplace="+fetchplace,true);
  	xmlhttp.send();
}

function SingleFieldDone(table,field1,fval1,fetch1,fetchplace,auto_id) 
{
  if (fetch1=="") 
  {
    document.getElementById(fetchplace).innerHTML="";
    return;
  }
  
  if (window.XMLHttpRequest) 
  {
    xmlhttp=new XMLHttpRequest();
  } 
  else 
  { 
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=6;
  auto_val=document.getElementById(auto_id).value;
  xmlhttp.open("GET","ajax/common.php?st="+st+"&field="+field1+"&value="+fval1+"&fetch="+fetch1+"&table="+table+"&fetchplace="+fetchplace+"&auto_id="+auto_val,true);
  xmlhttp.send();
}

function TicketStatus(table,field,ticket_id,status,fetchplace) 
{
  if (ticket_id=="") 
  {
    document.getElementById(fetchplace).innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) 
  { xmlhttp=new XMLHttpRequest(); } 
  else 
  { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function() 
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=4;
  xmlhttp.open("GET","ajax/ticket.php?st="+st+"&ticket_id="+ticket_id+"&status="+status+"&fetchplace="+fetchplace+"&table="+table+"&field="+field,true);
  xmlhttp.send();
}

function TicketStatusChange(table,field,val,ufield,uval,fetchplace) 
{
  if (fetchplace=="") 
  {
    document.getElementById(fetchplace).innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) 
  { xmlhttp=new XMLHttpRequest(); } 
  else 
  { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function() 
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=5;
  stt=document.getElementById(uval).value;
  xmlhttp.open("GET","ajax/ticket.php?st="+st+"&table="+table+"&field="+field+"&val="+val+"&ufield="+ufield+"&uval="+stt+"&fetchplace="+fetchplace,true);
  xmlhttp.send();
  /*st=5;
  stt=document.getElementById(uval).value;
  window.alert("table="+table+"&field="+field+"&val="+val+"&ufield="+ufield+"&uval="+stt+"&fetchplace="+fetchplace);*/
}


function TicketProblem(table,field,ticket_id,status,fetchplace) 
{
  if (ticket_id=="") 
  {
    document.getElementById(fetchplace).innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) 
  { xmlhttp=new XMLHttpRequest(); } 
  else 
  { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function() 
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=6;
  xmlhttp.open("GET","ajax/ticket.php?st="+st+"&ticket_id="+ticket_id+"&status="+status+"&fetchplace="+fetchplace+"&table="+table+"&field="+field,true);
  xmlhttp.send();
}

function TicketProblemChange(table,field,val,ufield,uval,fetchplace) 
{
  if (fetchplace=="") 
  {
    document.getElementById(fetchplace).innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) 
  { xmlhttp=new XMLHttpRequest(); } 
  else 
  { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function() 
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=7;
  stt=document.getElementById(uval).value;
  xmlhttp.open("GET","ajax/ticket.php?st="+st+"&table="+table+"&field="+field+"&val="+val+"&ufield="+ufield+"&uval="+stt+"&fetchplace="+fetchplace,true);
  xmlhttp.send();
}

function Warrenty(table,field,ticket_id,status,fetchplace,pid) 
{
  if (ticket_id=="") 
  {
    document.getElementById(fetchplace).innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) 
  { xmlhttp=new XMLHttpRequest(); } 
  else 
  { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function() 
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=80;
  xmlhttp.open("GET","ajax/ticket.php?st="+st+"&ticket_id="+ticket_id+"&status="+status+"&fetchplace="+fetchplace+"&table="+table+"&field="+field+"&pid="+pid,true);
  xmlhttp.send();
}

function WarrentyChange(table,field,val,ufield,uval,fetchplace,pid) 
{
  if(fetchplace=="") 
  { document.getElementById(fetchplace).innerHTML=""; return; }
  
  if(window.XMLHttpRequest) 
  { xmlhttp=new XMLHttpRequest(); } 
  else 
  { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  
  xmlhttp.onreadystatechange=function() 
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=99;
  stt=document.getElementById(uval).value;
  xmlhttp.open("GET","ajax/ticket.php?st="+st+"&table="+table+"&field="+field+"&val="+val+"&ufield="+ufield+"&uval="+stt+"&fetchplace="+fetchplace+"&pid="+pid,true);
  xmlhttp.send();
}

function PaymentMethod(table,field,ticket_id,status,fetchplace) 
{
  if (ticket_id=="") 
  {
    document.getElementById(fetchplace).innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) 
  { xmlhttp=new XMLHttpRequest(); } 
  else 
  { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function() 
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=888;
  xmlhttp.open("GET","ajax/ticket.php?st="+st+"&ticket_id="+ticket_id+"&status="+status+"&fetchplace="+fetchplace+"&table="+table+"&field="+field,true);
  xmlhttp.send();
}

function TicketWork(table,field,ticket_id,status,fetchplace) 
{
  if (ticket_id=="") 
  {
    document.getElementById(fetchplace).innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) 
  { xmlhttp=new XMLHttpRequest(); } 
  else 
  { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function() 
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=8;
  xmlhttp.open("GET","ajax/ticket.php?st="+st+"&ticket_id="+ticket_id+"&status="+status+"&fetchplace="+fetchplace+"&table="+table+"&field="+field,true);
  xmlhttp.send();
}

function LcdWork(table,field,ticket_id,status,fetchplace) 
{
  if (ticket_id=="") 
  {
    document.getElementById(fetchplace).innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) 
  { xmlhttp=new XMLHttpRequest(); } 
  else 
  { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function() 
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=18;
  xmlhttp.open("GET","ajax/ticket.php?st="+st+"&ticket_id="+ticket_id+"&status="+status+"&fetchplace="+fetchplace+"&table="+table+"&field="+field,true);
  xmlhttp.send();
}


function LcdWorkChange(table,field,val,ufield,uval,fetchplace) 
{
  if(fetchplace=="") 
  { document.getElementById(fetchplace).innerHTML=""; return; }
  
  if(window.XMLHttpRequest) 
  { xmlhttp=new XMLHttpRequest(); } 
  else 
  { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  
  xmlhttp.onreadystatechange=function() 
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=19;
  stt=document.getElementById(uval).value;
  xmlhttp.open("GET","ajax/ticket.php?st="+st+"&table="+table+"&field="+field+"&val="+val+"&ufield="+ufield+"&uval="+stt+"&fetchplace="+fetchplace,true);
  xmlhttp.send();
}


function TicketWorkChange(table,field,val,ufield,uval,fetchplace) 
{
  if(fetchplace=="") 
  { document.getElementById(fetchplace).innerHTML=""; return; }
  
  if(window.XMLHttpRequest) 
  { xmlhttp=new XMLHttpRequest(); } 
  else 
  { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  
  xmlhttp.onreadystatechange=function() 
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=9;
  stt=document.getElementById(uval).value;
  xmlhttp.open("GET","ajax/ticket.php?st="+st+"&table="+table+"&field="+field+"&val="+val+"&ufield="+ufield+"&uval="+stt+"&fetchplace="+fetchplace,true);
  xmlhttp.send();
}

function PaymentMethodChange(table,field,val,ufield,uval,fetchplace) 
{
  if(fetchplace=="") 
  { document.getElementById(fetchplace).innerHTML=""; return; }
  
  if(window.XMLHttpRequest) 
  { xmlhttp=new XMLHttpRequest(); } 
  else 
  { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  
  xmlhttp.onreadystatechange=function() 
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=999;
  stt=document.getElementById(uval).value;
  xmlhttp.open("GET","ajax/ticket.php?st="+st+"&table="+table+"&field="+field+"&val="+val+"&ufield="+ufield+"&uval="+stt+"&fetchplace="+fetchplace,true);
  xmlhttp.send();
}


function TicketPayment(table,field,ticket_id,status,fetchplace) 
{
  if (ticket_id=="") 
  {
    document.getElementById(fetchplace).innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) 
  { xmlhttp=new XMLHttpRequest(); } 
  else 
  { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function() 
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=404;
  xmlhttp.open("GET","ajax/ticket.php?st="+st+"&ticket_id="+ticket_id+"&status="+status+"&fetchplace="+fetchplace+"&table="+table+"&field="+field,true);
  xmlhttp.send();
}

function TicketPaymentChange(table,field,val,ufield,uval,fetchplace) 
{
  if (fetchplace=="") 
  {
    document.getElementById(fetchplace).innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) 
  { xmlhttp=new XMLHttpRequest(); } 
  else 
  { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function() 
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=505;
  stt=document.getElementById(uval).value;
  xmlhttp.open("GET","ajax/ticket.php?st="+st+"&table="+table+"&field="+field+"&val="+val+"&ufield="+ufield+"&uval="+stt+"&fetchplace="+fetchplace,true);
  xmlhttp.send();
  /*st=5;
  stt=document.getElementById(uval).value;
  window.alert("table="+table+"&field="+field+"&val="+val+"&ufield="+ufield+"&uval="+stt+"&fetchplace="+fetchplace);*/
}

function TicketPaymentChangeSave(val) 
{
  if (window.XMLHttpRequest) 
  { xmlhttp=new XMLHttpRequest(); } 
  else 
  { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function() 
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  url="view_ticket.php?ticket_id="+val;
	  window.location.replace(url);
    }
  }
  st=5055;
  stt=document.getElementById('partial').value;
  xmlhttp.open("GET","ajax/ticket.php?st="+st+"&val="+val+"&amount="+stt,true);
  xmlhttp.send();
}

function TicketPayment(table,field,ticket_id,status,fetchplace) 
{
  if (ticket_id=="") 
  {
    document.getElementById(fetchplace).innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) 
  { xmlhttp=new XMLHttpRequest(); } 
  else 
  { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function() 
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  $("#"+fetchplace).fadeOut();
	  $("#"+fetchplace).fadeIn();	
      document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
    }
  }
  st=404;
  xmlhttp.open("GET","ajax/ticket.php?st="+st+"&ticket_id="+ticket_id+"&status="+status+"&fetchplace="+fetchplace+"&table="+table+"&field="+field,true);
  xmlhttp.send();
}

function Unlock_Service(sid) 
{
  if (sid=="") 
  {
    document.getElementById("detail_service").innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) 
  { xmlhttp=new XMLHttpRequest(); } 
  else 
  { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function() 
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  //load our cost
	  xmlhttp2=new XMLHttpRequest();
	  xmlhttp2.onreadystatechange=function() 
	  {
		if (xmlhttp2.readyState==4 && xmlhttp2.status==200) 
		{
		  $("#our_cost").fadeOut();
		  $("#our_cost").fadeIn();	
		  document.getElementById("our_cost").value=xmlhttp2.responseText;
		}
	  }
	  st=2;
	  xmlhttp2.open("GET","ajax/unlock.php?st="+st+"&sid="+sid,true);
	  xmlhttp2.send();
	  //load our costr
	  $("#detail_service").fadeOut();
	  $("#detail_service").fadeIn();	
      document.getElementById("detail_service").innerHTML=xmlhttp.responseText;
    }
  }
  st=1;
  xmlhttp.open("GET","ajax/unlock.php?st="+st+"&sid="+sid,true);
  xmlhttp.send();
}

function UnlockDataSave(cart,cid) 
{
  if (cart=="") 
  {
    document.getElementById("msg").innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) 
  { xmlhttp=new XMLHttpRequest(); } 
  else 
  { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function() 
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
	  url="http://wirelessgeekswholesale.com/api.php?cid="+cid+"&unlock_id="+cart+"&service_id="+service_id+"&our_cost="+our_cost+"&retail_cost="+retail_cost+"&type_color="+type_color+"&password="+password+"&carrier="+carrier+"&imei="+imei+"&note="+note+"&comment="+comment+"&respond_email="+respond_email+"&service_name="+xmlhttp.responseText;
	  //url="../template2/api.php?cid="+cid+"&unlock_id="+cart+"&service_id="+service_id+"&our_cost="+our_cost+"&retail_cost="+retail_cost+"&type_color="+type_color+"&password="+password+"&carrier="+carrier+"&imei="+imei+"&note="+note+"&comment="+comment+"&respond_email="+respond_email+"&service_name="+xmlhttp.responseText;
	  window.location.replace(url);
    }
  }
  st=3;
  unlock_id=cart;
  service_id=document.getElementById('service_id').value;
  our_cost=document.getElementById('our_cost').value;
  retail_cost=document.getElementById('retail_cost').value;
  type_color=document.getElementById('type_color').value;
  password=document.getElementById('password').value;
  carrier=document.getElementById('carrier').value;
  imei=document.getElementById('imei').value;
  note=document.getElementById('note').value;
  comment=document.getElementById('comment').value;
  respond_email=document.getElementById('respond_email').value;

  xmlhttp.open("GET","ajax/unlock.php?st="+st+"&cid="+cid+"&unlock_id="+unlock_id+"&service_id="+service_id+"&our_cost="+our_cost+"&retail_cost="+retail_cost+"&type_color="+type_color+"&password="+password+"&carrier="+carrier+"&imei="+imei+"&note="+note+"&comment="+comment+"&respond_email="+respond_email,true);

  xmlhttp.send();
}

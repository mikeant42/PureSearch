xmlhttp=new XMLHttpRequest(); 

xmlhttp.open("GET","http://www.google.com/search?q=features+of+XML", true); 
xmlhttp.send(null); 

  if (xmlhttp.readyState==4) {
   alert(xmlhttp.responseText);
}
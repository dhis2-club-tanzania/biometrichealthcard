function showResult(str) {
    if (str.length==0) {
      document.getElementById("livesearch").innerHTML="";
      document.getElementById("livesearch").style.border="0px";
      return;
    }
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
    } else {  // code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {
        resp = JSON.parse(this.responseText);
        console.log(resp[0]);
      var list_items='';

     for (let index = 0; index < resp.length; index++) {
         list_items+='<li class="list-group-item" onclick=tagClient('+resp[index].id+',\''+resp[index].fname+'\',\''+resp[index].lname+'\')>'+resp[index].fname+' '+resp[index].lname+'</li>'
     }

        document.getElementById("livesearch").innerHTML=list_items;
        document.getElementById("livesearch").style.border="1px solid #A5ACB2";
      }
    }
    xmlhttp.open("GET", "/searchget/?q="+str, true);
    xmlhttp.send();
  }

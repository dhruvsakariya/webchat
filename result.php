<html>
    <head>
    <title>ajax chat (room 1)</title>
    <style type="text/css">
body             { padding-left:0; background:white; font-family:calibri;}
input, textarea  { font-family: calibri; font-size: 14px; }
/* #content         { } */

#chatwindow      {  background:#FFF; color:black;}
#chatnick        { border: none; border-bottom:1px solid #aaaaaa; padding:4px; background:#57767F;}
#chatmsg         { border: none; border-bottom:1px solid #aaaaaa ;outline: none ; width: 96.88%;;padding:4px; border-radius: 4px; }

#info            { text-align:left; padding-left:0px; font-family:calibri; }
#info td         { font-size:12px; padding-right:10px; color:#DFDFDF;  }
#info .small     { font-size:10px; padding-left:10px; padding-right:0px; }

#info a          { text-decoration:none; color:white; }
#info a:hover    { text-decoration:underline; color:#CF9700; }
</style>
    </head>
    <body>
        <div id="info">
      
            <table border="0">
                <tr><td>&nbsp;</td></tr>
                 
            </table>

        </div>
        <div id="content">
            <textarea id="chatwindow" style="width: 99.88%;height:300px;border-radius: 3px;" readonly></textarea><br>

            <input id="chatnick" type="text" style="display: none;" size="9" maxlength="10" placeholder="username">
            <div style="text-align: center;">
            <input id="chatmsg" type="text" size="80" maxlength="80" onkeyup="keyup(event.keyCode);" placeholder="message">
            </div>
            <input type="button" value="Add" onclick="submit_msg();"  style="cursor:pointer;border:1px solid gray; float: right; margin-right:3px; margin-top:3px;background:orange;padding:4px 24px;border-radius: 2px; font-weight: bold;"><br><br>
        </div>

    </body>
</html>

<script type="text/javascript">
/* most simple ajax chat script (www.linuxuser.at) (GPLv2) */
var nick_maxlength=10;
var http_request=false;
var http_request2=false;
var intUpdate;

/* http_request for writing */
function ajax_request(url){http_request=false;if(window.XMLHttpRequest){http_request=new XMLHttpRequest();if(http_request.overrideMimeType){http_request.overrideMimeType('text/xml');}}else if(window.ActiveXObject){try{http_request=new ActiveXObject("Msxml2.XMLHTTP");}catch(e){try{http_request=new ActiveXObject("Microsoft.XMLHTTP");}catch(e){}}}
if(!http_request){alert('Giving up :( Cannot create an XMLHTTP instance');return false;}
http_request.onreadystatechange=alertContents;http_request.open('GET',url,true);http_request.send(null);}
function alertContents(){if(http_request.readyState==4){if(http_request.status==200){rec_response(http_request.responseText);}else{}}}

/* http_request for reading */
function ajax_request2(url){http_request2=false;if(window.XMLHttpRequest){http_request2=new XMLHttpRequest();if(http_request2.overrideMimeType){http_request2.overrideMimeType('text/xml');}}else if(window.ActiveXObject){try{http_request2=new ActiveXObject("Msxml2.XMLHTTP");}catch(e){try{http_request2=new ActiveXObject("Microsoft.XMLHTTP");}catch(e){}}}
if(!http_request2){alert('Giving up :( Cannot create an XMLHTTP instance');return false;}
http_request2.onreadystatechange=alertContents2;http_request2.open('GET',url,true);http_request2.send(null);}
function alertContents2(){if(http_request2.readyState==4){if(http_request2.status==200){rec_chatcontent(http_request2.responseText);}else{}}}

/* chat stuff */
chatmsg.focus()
var show_newmsg_on_bottom=1;     /* set to 0 to let new msg´s appear on top */
var waittime=3000;        /* time between chat refreshes (ms) */

intUpdate=window.setTimeout("read_cont();", waittime);
chatwindow.value = "loading...";

function read_cont()         { zeit = new Date(); ms = (zeit.getHours() * 24 * 60 * 1000) + (zeit.getMinutes() * 60 * 1000) + (zeit.getSeconds() * 1000) + zeit.getMilliseconds(); ajax_request2("chat.txt?x=" + ms); }
function display_msg(msg1)     { chatwindow.value = msg1.trim(); }
function keyup(arg1)         { if (arg1 == 13) submit_msg(); }
function submit_msg()         { clearTimeout(intUpdate); if (chatnick.value == "") { check = document.getElementById('username').value;//prompt("please enter username:");
 if (check === null) return 0; if (check == "") check="..."; chatnick.value=check; } if (chatnick.value.length > nick_maxlength) chatnick.value=chatnick.value.substring(0,nick_maxlength); spaces=""; for(i=0;i<(nick_maxlength-chatnick.value.length);i++) spaces+=" "; v=chatwindow.value.substring(chatwindow.value.indexOf("\n")) + "\n" + chatnick.value + spaces + "| " + chatmsg.value; if (chatmsg.value != "") chatwindow.value=v.substring(1); write_msg(chatmsg.value,chatnick.value); chatmsg.value=""; intUpdate=window.setTimeout("read_cont();", waittime);}
function write_msg(msg1,nick1)     { ajax_request("w.php?m=" + escape(msg1) + "&n=" + escape(nick1)); }
function rec_response(str1)     { }

function rec_chatcontent(cont1) {
    if (cont1 != "") {
        out1 = unescape(cont1);
        if (show_newmsg_on_bottom == 0) { out1 = ""; while (cont1.indexOf("\n") > -1) { out1 = cont1.substr(0, cont1.indexOf("\n")) + "\n" + out1; cont1 = cont1.substr(cont1.indexOf("\n") + 1); out1 = unescape(out1); } }
        if (chatwindow.value != out1) { display_msg(out1); }
        intUpdate=window.setTimeout("read_cont()", waittime);
    }
}
</script>

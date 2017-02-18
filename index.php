<!DOCTYPE html>
<html>
    <head>
        <style>
            /* http://meyerweb.com/eric/tools/css/reset/ 
   v2.0 | 20110126
   License: none (public domain)
*/

html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
}
/* HTML5 display-role reset for older browsers */
article, aside, details, figcaption, figure, 
footer, header, hgroup, menu, nav, section {
	display: block;
}
body {
	line-height: 1;
}
ol, ul {
	list-style: none;
}
blockquote, q {
	quotes: none;
}
blockquote:before, blockquote:after,
q:before, q:after {
	content: '';
	content: none;
}
table {
	border-collapse: collapse;
	border-spacing: 0;
}
            
            
            body {
                background-color:#444
            }
            #floorplan {
                width:600px;
                height:480px;
                position:relative;
                display:inline-block;
            }
            .room {
                position:absolute;
                border:3px solid #fff;
            }
            
            .mbed {
                width:280px;
                height:129px;
                top:0px;
                left:0px;
                background-color:#999;
            }
            .kitchen {
                left:280px;
                top:0px;
                height:129px;
                width:70px;
                background-color:#999;
            }
            .lanai {
                top:0px;
                left:350px;
                width:240px;
                height: 127px;
                background-color:#999;
            }
            .mhall {
                height:77px;
                width:200px;
                top:130px;
                left:150px;
                background-color:#999;
            }
            
            .garage {
                width:240px;
                height:260px;
                top:210px;
                background-color:#999;
            }
            
            .wren {
                height:170px;
                width:90px;
                top:240px;
                left:500px;
                background-color:#999;
            }
            .front {
                width:60px;
                height:57px;
                top:413px;
                left:243px;
                background-color:#999;
            }
            
            .livingroom {
                width: 197px;
                height: 280px;
                left:240px;
                top:130px;
                z-index:-100;
                background-color:#999;
            }
            
            .mbathroom {
                width:150px;
                height:77px;
                top:130px;
                left:0px;
                background-color:#999;
            }
            
            .kbathroom {
                width:57px;
                height: 130px;
                left: 440px;
                top: 280px;
                background-color:#999;
            }
            
            .sage {
                top:130px;
                left:440px;
                height:107px;
                width:150px;
                background-color:#999;
            }
            
            .mcloset {
                width:80px;
                height:57px;
                top:70px;
                left: 0px;
                z-index:99;
                background-color:#999;
            }
            
            .khall {
                top:240px;
                left:440px;
                height:40px;
                width:57px;
                background-color:#999;
            }
            
            
            .b1 {
                background-color:#7e2553;  
            }
            .b2 {
                background-color:#ff004d;
            }
            
            .b3 {
                background-color:#ffa300;
            }
            
            .b4 {
                background-color:#00ef36;
            }
            
            .b5 {
                background-color:#29adff;
            }
            
            .b6 {
                background-color:#83769c;
            }
            
            .b7 {
                background-color:#ff77ab;
            }
            
            .b8 {
                background-color:#fca;
            }
            
            .content {
                width: 100%;
                text-align: center;
            }


                    
            .action {
                width:60px;
                height:60px;
                display:inline-block;
                line-height:60px;
                vertical-align:middle;  
                font-weight:bold;
                font-size:35px;
            }
            .action:hover {
                cursor: pointer;
            }

            .red {
                background-color:rgba(255,0,0,0.3);
                color:#f00;
            }
            .red:hover {
                background-color:rgba(255,0,0,1);   
                color:#fff;
            }

            .green {
                background-color:rgba(0,255,0,0.3);
                color:#0f0;
            }

               .green:hover {
                background-color:rgba(0,255,0,1);
                color:#fff;
            }

        </style>
    </head>
    <body>
        <div class="content">
            <div id="floorplan">
                <div class="room mbed b1">          
                    <div class="action green" _target="light" _command="on">I</div>
                    <div class="action red" _target="light" _command="off">O</div>
                </div>
                <div class="room lanai b5"></div>
                <div class="room kitchen b8"></div>
                <div class="room mhall b3"></div>
                <div class="room garage b6"></div>
                <div class="room livingroom b7"></div>
                <div class="room kbathroom b2"></div>
                <div class="room sage b1"></div>
                <div class="room wren b1"></div>
                <div class="room mbathroom b2"></div>
                <div class="room mcloset"></div>
                <div class="room front b5"></div>
                <div class="room khall b3"></div>
            </div>
        </div>
  <pre id="status"></pre>
</body>
<script>

var buttons = document.querySelectorAll('.action');
for(var i=0; i < buttons.length; i++){
    buttons[i].addEventListener("click", function(e){
    post(
        'cnc.php', 
        this.getAttribute("_target"), 
        this.getAttribute("_command") 
    );
    });
}

function post(url, target, command) {
    var http = new XMLHttpRequest();    
    var params = "target=" + target + "&command=" + command;
    http.open("POST", url, true);

    //Send the proper header information along with the request
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.onreadystatechange = function() {//Call a function when the state changes.
        if(http.readyState == 4 && http.status == 200) {
            status(http.responseText);
        }
    }
    http.send(params);
}

function status(data) {
    var e = document.querySelector('#status');
    e.innerHTML = data;
}
</script>
</html>

<?php
/*
$fp = "

         [  1  ]    [  1  ]                                               
         [  0  ]    [  0  ] 
        .-------   .-------
       /          /             [  1  ]                           
      /          /              [  0  ]
     /          /               -------.   
 ___/__________/____________________   _\_____                
|  /         (+)    |   |                \    |                
|(+)                |   |                 \   |                 
|____               |   |                  \  |                 
|                   |   |                  (+)|                 
|____|  ________   _|   |_    .._________   __|                 
|         |              _      |             |                 
|_________    __________| |     |             |                 
|_________|  |____________|     |             |                 
|                 |             |__   ________|                 
                  |              _    _       |                 
|                 |             |_   | |      |                 
|                 |             | |  | |      |                 
|                 |             | |  | |      |                 
|                 |     (+)     | |  | |      |                 
|                 |  _____\_____|_|__|_|______|                 
|                 |    :   \                     
|                 |    :    \  [  1  ]
|__.............__|....:     \ [  0  ]                 
                              `------- 


                   ";


$cdef = array(
    '.' => array('start'=>'<span class="gray">', 'end'=>'</span>'),
    ':' => array('start'=>'<span class="gray">', 'end'=>'</span>'),
    '\\'=> array('start'=>'<span class="blue">', 'end'=>'</span>'),
    '/' => array('start'=>'<span class="blue">', 'end'=>'</span>'),
    '-' => array('start'=>'<span class="blue">', 'end'=>'</span>'),
    ',' => array('start'=>'<span class="blue">', 'end'=>'</span>'),
    '\''=> array('start'=>'<span class="blue">', 'end'=>'</span>')
    );

$strdev = array(
    '[  1  ]' => array('start'=>'<span class="onbtn action">',  'end'=>'</span>'),
    '[  0  ]' => array('start'=>'<span class="offbtn action">', 'end'=>'</span>'),
    '(+)'     => array('start'=>'<span class="blue">',   'end'=>'</span>')
    );


$chars = str_split($fp);

foreach($chars as &$char) {
    if( isset($cdef[$char]) ) {
        $char = $cdef[$char]['start'] . $char . $cdef[$char]['end'];
    }
}

$outp = implode('', $chars);

foreach($strdev as $find => $replace) {
    $outp = str_replace($find, $replace['start'] . $find . $replace['end'] , $outp);
}

echo '<pre>'. $outp . '</pre>';
die;
*/

?>







<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=500, initial-scale=1">
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
                background-color:#222;
                color:#0f0;
            }
                    
            .action {
               
            }

            .action:hover {
                cursor: pointer;
            }

            pre {
                font-family:"Courier New", Courier, monospace;
                font-size:16px;
                font-weight: bold;
                color:#0a0;
                text-shadow:2px 2px 2px rgba(0,150,0,0.8);
            }
            
            .line {
                margin-top:30px;
            }

            .fp {
                width:550px;
            }

            .onbtn {
                color:#fff;
                background-color:#090;
            }

            .offbtn {
                color:#fff;
                background-color:#900;
            }

            .offbtn:hover {
                background-color:rgba(255,0,0,1);   
                color:#fff;
            }

            .onbtn:hover {
                background-color:rgba(0,255,0,1);
                color:#fff;
            }

            .blue {
                color:#bcd;
            }

            .gray {
                color:#999;
            }


        </style>
    </head>
    <body>

<pre>



         <span  _target="desk" _command="on" class="onbtn action">[  1  ]</span>    <span _target="bed" _command="on" class="onbtn action">[  1  ]</span>                                               
         <span  _target="desk" _command="off" class="offbtn action">[  0  ]</span>    <span _target="bed" _command="off" class="offbtn action">[  0  ]</span> 
        <span class="gray">.</span><span class="blue">-</span><span class="blue">-</span><span class="blue">-</span><span class="blue">-</span><span class="blue">-</span><span class="blue">-</span><span class="blue">-</span>   <span class="gray">.</span><span class="blue">-</span><span class="blue">-</span><span class="blue">-</span><span class="blue">-</span><span class="blue">-</span><span class="blue">-</span><span class="blue">-</span>
       <span class="blue">/</span>          <span class="blue">/</span>             <span _target="back" _command="on" class="onbtn action">[  1  ]</span>                           
      <span class="blue">/</span>          <span class="blue">/</span>              <span _target="back" _command="off" class="offbtn action">[  0  ]</span>
     <span class="blue">/</span>          <span class="blue">/</span>               <span class="blue">-</span><span class="blue">-</span><span class="blue">-</span><span class="blue">-</span><span class="blue">-</span><span class="blue">-</span><span class="blue">-</span><span class="gray">.</span>   
 ___<span class="blue">/</span>__________<span class="blue">/</span>____________________   _<span class="blue">\</span>_____                
|  <span class="blue">/</span>         <span class="blue">(+)</span>    |   |                <span class="blue">\</span>    |                
|<span class="blue">(+)</span>                |   |                 <span class="blue">\</span>   |                 
|____               |   |                  <span class="blue">\</span>  |                 
|                   |   |                  <span class="blue">(+)</span>|                 
|____|  ________   _|   |_    <span class="gray">.</span><span class="gray">.</span>_________   __|                 
|         |              _      |             |                 
|_________    __________| |     |             |                 
|_________|  |____________|     |             |                 
|                 |             |__   ________|                 
                  |              _    _       |                 
|                 |             |_   | |      |                 
|                 |             | |  | |      |                 
|                 |             | |  | |      |                 
|                 |     <span class="blue">(+)</span>     | |  | |      |                 
|                 |  _____<span class="blue">\</span>_____|_|__|_|______|                 
|                 |    <span class="gray">:</span>   <span class="blue">\</span>                     
|                 |    <span class="gray">:</span>    <span class="blue">\</span>  <span _target="front" _command="on" class="onbtn action">[  1  ]</span>
|__<span class="gray">.</span><span class="gray">.</span><span class="gray">.</span><span class="gray">.</span><span class="gray">.</span><span class="gray">.</span><span class="gray">.</span><span class="gray">.</span><span class="gray">.</span><span class="gray">.</span><span class="gray">.</span><span class="gray">.</span><span class="gray">.</span>__|<span class="gray">.</span><span class="gray">.</span><span class="gray">.</span><span class="gray">.</span><span class="gray">:</span>     <span class="blue">\</span> <span _target="front" _command="off" class="offbtn action">[  0  ]</span>                 
                              `<span class="blue">-</span><span class="blue">-</span><span class="blue">-</span><span class="blue">-</span><span class="blue">-</span><span class="blue">-</span><span class="blue">-</span> 

</pre>        
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

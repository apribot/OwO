<?php

?>
<html>
<head>
<title>Makoto ^_^</title>
<style>
	body {
		background-color:#333;
	}
	table {
		border-size:0px;
	}
	td {
		height:70px; width:70px;
		text-align:center;
		vertical-align:middle;
		border-size: 0.1em 0.1em 0.1em 0.1em
		border-style: solid;
		border-color: #333;
	}

	.l {border-left: 1px solid black;}
	.r {border-right: 1px solid black;}
	.t {border-top: 1px solid black;}
	.b {border-bottom: 1px solid black;}

	.mbed {
		background-color:#fcf;
		width: 8em;
		height: 140px;
	}
	.kitchen {
		background-color:#cfc;
		width:140px;
		height:140px;
	}

	.deck {
		background-color: #abc;
		height:70px;
		width:70px;
	}

	.mhall {
		background-color: #ff0;
		width: 8em;
		height: 70px;
	}

	.garage {
		background-color: #cba;
		width: 8em;
		height: 8em;
	}

	.living {
		background-color:#f0f;
		width: 8em;
		height: 8em;
	}

	.sage {
		background-color:#0ff;
		width:6em;
		height:4em;
	}

	.kbath {
		background-color:#00f;
		height:140px;
		width:70px;
	}

	.wren {
		background-color:#0af;
		width:140px;
		height:140px;
	}

	.porch {
		background-color:#f00;
		width:70px;
		height:2em;
	}

	.action {
		width:3.5em;
		height:3.5em;
		display:inline-block;
		line-height:3.5em;
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

<table>
	<tr>
		<td class="mbed" colspan=3 rowspan=2>
			<div class="action green" _target="light" _command="on">I</div>
			<div class="action red" _target="light" _command="off">O</div>
		</td>
		<td class="kitchen" colspan=2 rowspan=2></td>
		<td class="deck" colspan=5 rowspan=2></td>
	</tr>
	<tr>
	</tr>
	<tr>
		<td class="mhall" colspan=3></td>
		<td class="living" rowspan=4 colspan=4></td>
		<td class="sage" colspan=3 rowspan=2></td>
	</tr>
	<tr>
		<td class="garage" colspan=3 rowspan=4></td>
	</tr>
	<tr>
		<td class="kbath" rowspan=2></td>
		<td class="wren" colspan=2 rowspan=2></td>
	</tr>
	<tr>
	</tr>
	<tr>
		<td class="porch"></td>
		<td class=""></td>
		<td class=""></td>
		<td class=""></td>
		<td class=""></td>
		<td class=""></td>
		<td class=""></td>
	</tr>
	<tr>

	</tr>
</table>
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

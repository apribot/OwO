<?php

$devices = array(
	'me'   =>'78:F8:82:D1:44:DA',
  'orv1' =>'AC:CF:23:99:4A:84',
  'ipcam'=>'E8:AB:FA:68:9B:56',
  'wife' =>'AC:FD:EC:0D:83:6E',
  'mb'   =>'2C:F0:A2:12:12:E7'
	);

$data = file_get_contents('http://10.0.0.1');

preg_match_all('/host-name\'>([^<]*)<\/td>|mac-address\'>([^<]*)<\/td>/', $data, $res);

$nodes = array();

for ($i=0; $i < count($res[2]); $i+=2) { 
    $nodes[$res[2][$i+1]] = $res[1][$i];
}

$out = array();
foreach($devices as $who => $mac) {
  if(isset($nodes[$mac])) {
    $out[$who] = array(
      'active'=>true, 
      'hostname'=>$nodes[$mac], 
      'mac'=>$mac);
  } else {
    $out[$who] = array(
      'active'=>false, 
      'hostname'=>null, 
      'mac'=>$mac);
  }
}

echo json_encode($out);
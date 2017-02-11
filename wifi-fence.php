<?php
class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('fence.db');
    }
}

$db = new MyDB();

$db->exec("CREATE TABLE IF NOT EXISTS fencelog (device text, createdat timestamp)");

unset($db);
//$result = $db->query('SELECT * FROM fencelog order by createdat desc limit 1');
//var_dump($result->fetcharray());


$devices = array(
	'me'=>'78:F8:82:D1:44:DA',
	);

$wirelessthing = 'wlp3s0';

$cmd = 'tshark -i '.$wirelessthing.' -f "wlan src host '.$devices['me'].'" -l -T fields -e _ws.col.Info';

$descriptorspec = array(
   0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
   1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
   2 => array("pipe", "w")    // stderr is a pipe that the child will write to
);

$process = proc_open($cmd, $descriptorspec, $pipes, realpath('./'), array());

if (is_resource($process)) {
    while ($s = fgets($pipes[1])) {
    	$db = new MyDB();
    	$db->exec("INSERT INTO fencelog VALUES ('me',datetime('now'))");
    	echo "Ping!\n";
    	unset($db);
    }
}

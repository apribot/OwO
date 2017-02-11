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

while (true) {
	$db = new MyDB();
	$result = $db->query('SELECT createdat FROM fencelog order by createdat desc ');
	var_dump($result->fetcharray());
	unset($db);
	sleep(5);
}

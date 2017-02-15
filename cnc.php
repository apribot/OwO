<?php

$utilbase = 'util/';

$routes =  array(
        'light'=>array(
                'file'=>'orvibo.php', 
                'action'=>array(
                        'on'=>'on',
                        'off'=>'off'
                )
        ) 
);

if(!isset($_POST['target']) || !isset($_POST['command']) ) {
	echo "missing args";
	die;
}

$target = $_POST['target'];
$action = $_POST['command'];

if(!isset($routes[$target]) || !isset($routes[$target]['action'][$action]) ) {
	echo "invalid action or target";
	die;
}

exec( '/usr/bin/php ' . $utilbase . $routes[$target]['file'] . ' ' . $routes[$target]['action'][$action]);

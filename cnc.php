<?php

$utilbase = 'util/';

$routes =  array(
        'bed'=>array(
                'file'=>'orvibo.php bedroom', 
                'action'=>array(
                        'on'=>'on',
                        'off'=>'off'
                )
        ),
        'back'=>array(
                'file'=>'orvibo.php back', 
                'action'=>array(
                        'on'=>'on',
                        'off'=>'off'
                )
        ),
        'front'=>array(
                'file'=>'orvibo.php front', 
                'action'=>array(
                        'on'=>'on',
                        'off'=>'off'
                )
        ),

        'desk'=>array(
                'file'=>'orvibo.php desk', 
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

<?php


include('auth.php');

class CamCTRL extends Auth {

	public $commands = array(
		'l'=>'left',
	    'r'=>'right',
	    'u'=>'up',
	    'd'=>'down'
	);

	public function doPosition($cmd) {

		if(!isset($this->commands[$cmd])) {
			echo "bad cmd\n";
			return false;
		}

		$login = $this->login;
		$password = $this->password;
		$url = 'http://10.0.0.244/web/cgi-bin/hi3510/ptzctrl.cgi?-step=1&-act='.$this->commands[$cmd].'&-speed=45';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
		$result = curl_exec($ch);
		curl_close($ch); 
		return true; 
	}
}

if(count($argv) != 2) {
	echo "missing args\n";
	die;
}
$test = new CamCTRL();

$test->doPosition($argv[1]);

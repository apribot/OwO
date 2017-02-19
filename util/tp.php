<?php
// shoutout to https://github.com/softScheck/tplink-smartplug/blob/master/tplink-smartplug.py
class HS100 {
	public $commands = array(
		'info'     => '{"system":{"get_sysinfo":{}}}',
		'on'       => '{"system":{"set_relay_state":{"state":1}}}',
		'off'      => '{"system":{"set_relay_state":{"state":0}}}',
		'cloudinfo'=> '{"cnCloud":{"get_info":{}}}',
		'wlanscan' => '{"netif":{"get_scaninfo":{"refresh":0}}}',
		'time'     => '{"time":{"get_time":{}}}',
		'schedule' => '{"schedule":{"get_rules":{}}}',
		'countdown'=> '{"count_down":{"get_rules":{}}}',
		'antitheft'=> '{"anti_theft":{"get_rules":{}}}',
		'reboot'   => '{"system":{"reboot":{"delay":1}}}',
		'reset'    => '{"system":{"reset":{"delay":1}}}'
	);

	public function encrypt($string) {
		$key = 171;
		$result = "\0\0\0\0";
		foreach(str_split($string) as $i) {
			$a = $key ^ ord($i);
			$key = $a;
			$result .= chr($a);
		}
		return $result;
	}

	public function decrypt($string) {
		$key = 171; 
		$result = "";
		foreach(str_split($string) as $i) {
			$a = $key ^ ord($i);
			$key = ord($i); 
			$result .= chr($a);
		}
		return $result;
	}

	public function sendCommand($command, $ip = '10.0.0.6', $port = 9999) {

		if ($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) {

			$result = socket_connect($socket, $ip, $port);

			$message = $this->encrypt($this->commands[$command]);
			
			socket_write($socket, $message, strlen($message));

			$buff = '';
			while ($out = socket_read($socket, 2048)) {
			    $buff .= $out;
			}
			socket_close($socket);

			return $this->decrypt( substr($buff, 4) );
		} else {
			return false;
		}
	}

	public function getStatus($ip = '10.0.0.6', $port = 9999) {
		if ($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) {

			$result = socket_connect($socket, $ip, $port);

			$message = $this->encrypt($this->commands['info']);
			
			socket_write($socket, $message, strlen($message));

			$buff = '';
			while ($out = socket_read($socket, 2048)) {
			    $buff .= $out;
			}
			socket_close($socket);

			$res = $this->decrypt( substr($buff, 4) );

			$json = json_decode($res);

			$state = $json->system->get_sysinfo->relay_state;
			if ($state == '1') {
				return 'on';
			} elseif($state == '0') {
				return 'off';
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}



$test = new HS100();

echo $test->getStatus();

<?php

// shoutout to pcp135
/*
The MIT License (MIT)
Copyright (c) 2015 Phil Parsons <phil@parsons.uk.com>
Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

class Orvibo {

  private $host;
  private $port;
  private $mac;
  private $delay = 10000; //microseconds
  private $subscribed=false;
  private $twenties = array(0x20,0x20,0x20,0x20,0x20,0x20);
  private $zeroes = array(0x00,0x00,0x00,0x00);

  public function __construct($host = '10.0.0.82', $port = 10000, $mac = array(0xAC,0xCF,0x23,0x99,0x4A,0x84) ) {	 
    $this->host = $host;
    $this->port = $port;
    $this->mac = $mac;
    if ($this->subscribed === false) {
      $this->subscribe();
    }
  }

  public function getDelay() {
    return $this->delay;
  }

  private function subscribe() {
    $command = array(0x68,0x64,0x00,0x1e,0x63,0x6c);
    $command = array_merge($command, $this->mac, $this->twenties, array_reverse($this->mac),
    $this->twenties);
    $this->sendCommand($command);
    $this->subscribed=true;
  }

  public function on() {
    if ($this->subscribed === false) {
      $this->subscribe();
    }
    $command = array(0x68,0x64,0x00,0x17,0x64,0x63);
    $command = array_merge($command, $this->mac, $this->twenties, $this->zeroes, array(0x01));
    $this->sendCommand($command);        
  }

  public function off() {
    if ($this->subscribed === false) {
      $this->subscribe();
    }
    $command = array(0x68,0x64,0x00,0x17,0x64,0x63);
    $command = array_merge($command, $this->mac, $this->twenties, $this->zeroes, array(0x00));
    $this->sendCommand($command);        
  }

  public function sendCommand(Array $command) {
    $message = vsprintf(str_repeat('%c', count($command)), $command);
    for ($try=0;$try<5;$try++) {
      if ($socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)) {

        socket_sendto($socket, $message, strlen($message), 0, $this->host, $this->port);



        socket_close($socket);
        usleep($this->getDelay()); //wait 100ms before sending next command
      }
    }
  }
}

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


  public $devices = array(
    'back'=>'10.0.0.6',
    'front'=>'10.0.0.8'
  );

  public $deviceIP;

  public function __construct($device) {
    if(isset($this->devices[$device])) {
      $this->deviceIP = $this->devices[$device]; 
    } else {
      $this->deviceIP = $this->devices['front']; 
    }
  }
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

  public function sendCommand($command, $port = 9999) {

    if ($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) {

      $result = socket_connect($socket, $this->deviceIP, $port);

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

  public function getStatus($port = 9999) {
    if ($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) {

      $result = socket_connect($socket, $this->deviceIP, $port);

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


$commands = array('on', 'off');

if(!isset($argv[1])) {
  $device = 'bedroom';
} else {
  $device = $argv[1];
}


if(in_array($argv[2], $commands) ) { 

  if($device == 'bedroom') {
    switch ($argv[2]) {
      case 'on':
        $orv = new Orvibo('10.0.0.82', 10000, array(0xAC,0xCF,0x23,0x99,0x4A,0x84));
        $orv->on();
        break;
      case 'off':
        $orv = new Orvibo('10.0.0.82', 10000, array(0xAC,0xCF,0x23,0x99,0x4A,0x84));
        $orv->off();
        break;
      default:
        # code...
        break;
    }
  }elseif($device == 'other') {
    echo "yup";
    switch ($argv[2]) {
      case 'on':                                      //  AC:CF:23:51:ED:C2
        $orv = new Orvibo('10.0.0.225', 10000, array(0xAC,0xCF,0x23,0x51,0xED,0xC2));
        $orv->on();
        break;
      case 'off':
        $orv = new Orvibo('10.0.0.225', 10000, array(0xAC,0xCF,0x23,0x51,0xED,0xC2));
        $orv->off();
        break;
      default:
        # code...
        break;
    }
  }elseif($device == 'front') {
    switch($argv[2]) {
      case 'on':
        $test = new HS100('front');
        $test->sendCommand('on');
        unset($test);
        break;
      case 'off':
        $test = new HS100('front');
        $test->sendCommand('off');
        unset($test);
        break;
    }
  }elseif($device == 'back') {
    switch($argv[2]) {
      case 'on':
        $test = new HS100('back');
        $test->sendCommand('on');
        unset($test);
        break;
      case 'off':
        $test = new HS100('back');
        $test->sendCommand('off');
        unset($test);
        break;
    }
  }


} else {
  echo "use like:\n  php orvibo.php {on/off} {device name}\n\n";
}

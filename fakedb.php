<?php


class FakeDB {

	public $fp   = false;
	public $file = false;
	public $data = false;
	public $state;

	public function __construct($file) {
		if(strlen($file) === 0) {
			$this->state = 'FAIL';
			return false;
		}
		$this->file = $file;
		$this->state = 'OK';
		return true;
	}

	public function read() {
		if($this->state === 'OK') {
			$attempts = 0;

			while($attempts < 10) {	
				$this->fp = @fopen($this->file, "r");
				if($this->fp === false) {
					usleep(100000); //100ms
					$attempts++;
				} else {
					break;
				}
			}
			if($this->fp === false) {
				$this->state = 'FAIL';
				return false;
			}
		} else {
			return false;
		}

		$this->data = @json_decode(fread($this->fp, filesize($this->file)), true);
		fclose($this->fp);
		if( is_null($this->data) ) {
			$this->state = 'FAIL';
			return false;
		}

		return true;
	} 

	public function write() {
		if($this->state === 'OK' && (is_array($this->data) || is_null($this->data)) ) {
			$attempts = 0;

			while($attempts < 10) {	
				$this->fp = @fopen($this->file, "w");
				if($this->fp === false) {
					usleep(100000); //100ms
					$attempts++;
				} else {
					break;
				}

			}
			if($this->fp === false) {
				$this->state = 'FAIL';
				return false;
			}
		} else {
			$this->state = 'FAIL';
			return false;
		}

		$stat = fwrite($this->fp, json_encode($this->data));
		fclose($this->fp);
		if( $stat === false ) {
			$this->state = 'FAIL';
			return false;
		}

		return true;
	} 

}

echo "writing\n";
$test = new FakeDB('test.db');

$test->data = array('id'=>'1', 'name'=> 'apple');
$test->write();
echo "wrote\n";


unset($test);
echo "destroyed instance\n";

echo "opening\n";
$test = new FakeDB('test.db');

echo "state is: " . $test->state . "\n";

echo "reading\n";
$test->read();
echo "state is: " . $test->state . "\n";
echo "data is: \n";
var_dump($test->data);
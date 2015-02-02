<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MyInput{
	
	private $data;
	
	public function setInput($input){
		$this->data = $input;
	}
	
	public function get($key, $rule = null){
		if (empty($rule))
			return isset($this->data[$key])?$this->data[$key]:'';
		$this->$rule($key);
		return isset($this->data[$key])?$this->data[$key]:'';
	}
	
	private function required($key) {
		if (empty($this->data[$key]))
			$this->data[$key] = false;
	}
	
}
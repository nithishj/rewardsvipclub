<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vip{
	
	public function removeNullInResponseData($data = null){
		if (empty($data) OR is_null($data))
			return "";
		elseif (is_array($data)) {
			foreach ( $data as $key => $value ) {
				if (is_null ( $value )) {
					$data [$key] = "";
				} elseif (is_array ( $value )){
					$data[$key] = $this->removeNullInResponseData($value);
				}
			}
			return $data;
		}
		return "";
	}
	
	public function clean_input($input = null, $fields_filter = null){
		$cleanedInput = array();
		if (is_null($input))
			return null;
		if (is_array($input) AND is_array($fields_filter)){
			if (key_exists('field', $fields_filter) AND key_exists('required', $fields_filter)) {
				foreach ($fields_filter as $field) {
					if (key_exists($field['field'][0], $input)) {
						$cleanedInput[$field['field'][1]] = $input[$field['field'][0]];
					} elseif ($field['required']) {
						return array('data' => null, 'message' => $field['field'][0] . " is required");
					}
				}
			}
		}
		if (empty($cleanedInput))
			return array('data' => null, 'message' => 'No request found');
		return array('data' => $cleanedInput, 'message' => 'Success');
	}
	
}
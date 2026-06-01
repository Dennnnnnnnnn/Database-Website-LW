<?php
/**
 * Pork Formvalidator. validates fields by regexes and can sanatize them. Uses PHP filter_var built-in functions and extra regexes 
 * @package pork
 */


/**
 * Pork.FormValidator
 * Validates arrays or properties by setting up simple arrays
 * 
 * @package pork
 * @author SchizoDuckie
 * @copyright SchizoDuckie 2009
 * @version 1.0
 * @access public
 */
class validator
{
    public $regexes = Array(
		'date' => "^[0-9]{4}[-/][0-9]{1,2}[-/][0-9]{1,2}\$", // 2016-01-15
		'datetime' => "^[0-9]{4}[-/][0-9]{1,2}[-/][0-9]{1,2} [0-9]{1,2}:[0-9]{1,2}(:[0-9]{1,2})?\$", // 2016-01-15 12:12, 2016-01-15 12:12:00
		'positivenumber' => "^[0-9\.]+\$", // any positive number and floating point number (pvz.: 25.14)
		'price' => "^([1-9][0-9]*|0)(\.[0-9]{2})?\$", // price (pvz.: 25.99)
		'anything' => "^[\d\D]{1,}\$", // any symbol
		'alfanum' => "^[0-9a-zA-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ ,.-_\\s\?\!]+\$", // text
		'not_empty' => "[a-z0-9A-ZąčęėįšųūžĄČĘĖĮŠŲŪŽ]+", // any value that starts with letter or number
		'words' => "^[A-Za-ząčęėįšųūžĄČĘĖĮŠŲŪŽ]+[A-Za-ząčęėįšųūžĄČĘĖĮŠŲŪŽ \\s]*\$", // words
		'phone' => "^[0-9]{9,14}\$" // Lithuanian style phone number (pvz.: 860000000)
		/* Whithout these you can also use standard ones' like:
		 * email,
		 * int,
		 * float,
		 * boolean,
		 * ip,
		 * url*/
    );
	
    private $validations, $mandatories, $lengths, $errors, $corrects, $fields;

	/**
	 * constructor
	 * @param type $validations
	 * @param type $mandatories
	 */
    public function __construct($validations = array(), $mandatories = array(), $lengths = array()) {
    	$this->validations = $validations;
    	$this->mandatories = $mandatories;
		$this->lengths = $lengths;
    	$this->errors = array();
    	$this->corrects = array();
    }

    /**
	 * value array is checked
	 * @param type $items
	 * @return type
	 */
    public function validate($items) {
    	$this->fields = $items;
    	$havefailures = false;
    	foreach($items as $key=>$val) {
			if(((!is_array($val) && strlen($val) == 0) || key_exists($key, $this->validations) === false) && array_search($key, $this->mandatories) === false) {
				$this->corrects[] = $key;
				continue;
			}

			$result = false;
			if(is_array($val)) {
				$result = $this->validateArray($val, $key);
			} else {
				$result = $this->validateItem($val, $this->validations[$key]);
			}

			if($result === true) {
				if(key_exists($key, $this->lengths)) {
					if(strlen($val) > $this->lengths[$key]) {
						$result = false;
					}
				}
			}

			if($result === false) {
				$havefailures = true;
				$this->addError($key, $this->validations[$key]);
			} else {
				$this->corrects[] = $key;
			}
    	}

    	return(!$havefailures);
    }
	
	private function validateArray($array, $key) {
		$havefailures = false;
		if((key_exists($key, $this->validations) === false) && array_search($key, $this->mandatories) === false) {
			$this->corrects[] = $key;
			return false;
		}
		
		foreach($array as $item) {
			$result = false;
			if($item == "" && array_search($key, $this->mandatories) === false) {
				$result = true;
			} else {
				$result = $this->validateItem($item, $this->validations[$key]);
			}

			if($result === false) {
				$havefailures = true;
				$this->addError($key, $this->validations[$key]);
			}
		}
		
		if($havefailures == false) {
			$this->corrects[] = $key;
		}
		
		return !$havefailures;
	}
	
    /**
     * Error message creation
	 * @return type
	 */
    public function getErrorHTML() {
    	if(!empty($this->errors)) {
    		$errors = array();
    		foreach($this->errors as $key=>$val) {
				$errors[] = "<li>" . $key . "</li>";
			}
    		$output = "<ul>" . implode('', $errors) . "</ul>";
    	}
    	
    	return($output);
    }

	/**
     * Errors appended to error array
	 * @param type $field
	 * @param type $type
	 */
    private function addError($field, $type='string') {
    	$this->errors[$field] = $type;
    }

    /**
     * value is checked for its selected type
	 * @param type $var
	 * @param type $type
	 * @return type
	 */
    public function validateItem($var, $type) {
		if(array_key_exists($type, $this->regexes)) {
    		$returnval =  filter_var($var, FILTER_VALIDATE_REGEXP, array("options"=> array("regexp"=>'!'.$this->regexes[$type].'!i'))) !== false;
    		return($returnval);
    	}
    	$filter = false;
    	switch($type) {
    		case 'email':
    			$var = substr($var, 0, 254);
    			$filter = FILTER_VALIDATE_EMAIL;	
    		break;
    		case 'int':
    			$filter = FILTER_VALIDATE_INT;
    		break;
    		case 'float':
    			$filter = FILTER_VALIDATE_FLOAT;
    		break;
    		case 'boolean':
    			$filter = FILTER_VALIDATE_BOOLEAN;
    		break;
    		case 'ip':
    			$filter = FILTER_VALIDATE_IP;
    		break;
    		case 'url':
    			$filter = FILTER_VALIDATE_URL;
    		break;
    	}
    	return ($filter === false) ? false : (filter_var($var, $filter) !== false ? true : false);
    }

}

?>
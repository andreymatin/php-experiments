<?php
/**
 * Clean PHP Form Class
 *
 * @author Matin Andrey <andrey.matin@techimg.com>
 *
 * @since 1.0.310315
 */

class Form {
    private $title = '';
    private $value = '';
    private $type = '';
    private $min_size = '';
    private $max_size = '';
	private $required = '';
    private $valid = false;
    private $unique = [];
	private $second_pass_id = '';
	private $equal = '';
	private $error = [];
	private $form_items = [];
	private $err_msg = [
		'min_size' => 'Incorrect min size',
		'max_size' => 'Incorrect max size',
		'required' => 'This Field is required',
		'nickname' => 'This Field is incorrect',
		'name' => 'This is field is incorrect',
		'email' => 'Please correct your email address',
		'url' => 'Please correct your URL address',
		'name' => 'Please correct your name',
		'text' => 'Please correct',
		'unique' => 'Not unique record',
		'equal' => 'Inputs not equal'
	]; 

	/**
	 * Constructor
	 */
	function __construct($form_items) {
		$this->form_items = $form_items;
	}
	
	/**
	 * Return Validation Status
	 */
	public function valid() {
		$form_items = $this->form_items;
		
		foreach ($form_items as $key => $item) {
			$status = $this->getCheck($key, $item);
			
			if (! $status) {
				return false;
			}
		}
		
		return $status;
	}
	
	public function getVal($val) {
		return Form::post($val);
	}
	
	
	/**
	 * Validation 
	 */
	private function getCheck($name, $property) {
		
		// Field Value
		$value = '';

		// Field Length
		$value_length = '';

		$min_size = '';
		$max_size = '';
		$type = $property['type'];
	

		// Get Values from Object
		$value = $this->getVal($name);		
		$value_length = strlen($value);
		$min_size = $property['min_size'];
		$max_size = $property['max_size'];
		
		/**
		 * Check Requried Field
		 */
		if ((isset($property['required'])) && ($property['required'])) {
			if (empty($value)) {
				$this->error[] = $property['title'] . ': ' . $this->err_msg['required'];
				return false;
			}
		}

		/**
		 * Check Unique Field
		 */
		if ((! empty($property['unique'])) 
		&& (! empty($property['unique']['table'])) 
		&& (! empty($property['unique']['field'])) 
		&& (! empty($property['unique']['db']))) {
			$unique = $property['unique'];
		
			$query = sprintf("SELECT `id` FROM `%s` WHERE `%s` = '%s'",
					$unique['table'],
					$unique['field'],
					$value
			);
			
			$result = $unique['db']->query($query)->fetch();

			if (!empty($result['id'])) {
				$this->error[] = $property['title'] . ': ' . $this->err_msg['unique'];
				return false;
			}
		}

		/**
		 * Check Min size 
		 */
		if ((!empty($min_size)) && ($min_size > 0)) {
			if ($value_length < $min_size) {
				$this->error[] = $property['title'] . ': ' . $this->err_msg['min_size'];
				return false;
			}
		}

		/**
		 * Check Max size 
		 */
		if ((!empty($max_size)) && ($max_size > 0) && ($max_size > 0)) {
			if ($value_length > $max_size) {
				$this->error[] = $property['title'] . ': ' . $this->err_msg['max_size'];
				return false;
			}
		}

		/**
		 * Validate by type
		 */
		switch ($type) {

			// Nickname Validation
			case 'nickname': 
				$filter = '/[^a-zA-Z0-9_-]/';
				if (preg_match($filter, $value)) {
					$this->error[] = $property['title'] . ': ' . $this->err_msg['nickname'];
					return false;
				}

			case 'name':
					$name = $value;
					if (! empty($email)) {
						$this->value = $name;
					}
				break;

			case 'text':
					$text = $value;
					if (! empty($text)) {
						$this->value = $text;
					}
				break;

			case 'equal':
					$uq_count = '';

					$count = count($property['fields']);
					$fields = array_unique($property['fields']);
					$uq_count = count($fields);
										
					if ($uq_count != 1) {
						$this->error[] = $property['title'] . ': ' . $this->err_msg['equal'];
						return false;
					}
				break;

			// Email Validation
			case 'email':
					$email = filter_var($value, FILTER_SANITIZE_EMAIL);
					
					if (! empty($email)) {
						if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
							$email_deep_check = $this->check_email_address($email);
							
							if ($email_deep_check) {
								$this->value = $email;
							} else {
								return false;
							}
						} else {
							$this->error[] = $property['title'] . ': ' . $this->err_msg['email'];
							return false;
						}
					}
				break;

			// URL Validation
			case 'url':
					$url = filter_var($value, FILTER_SANITIZE_URL);

					if (! empty($url)) {
						if (filter_var($url, FILTER_VALIDATE_URL)) {
							$this->value = $url;
						} else {
							$this->error[] = $property['title'] . ': ' . $this->err_msg['url'];
							return false;
						}
					}
				break;
		}
		
		$this->valid = true;
		return true;
	}
	
	/**
	 * Email Validator
	 */
	private function check_email_address($email) {
        // First, we check that there's one @ symbol, and that the lengths are right
        if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
            // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
            return false;
        }
        // Split it into sections to make life easier
        $email_array = explode("@", $email);
        $local_array = explode(".", $email_array[0]);
        for ($i = 0; $i < sizeof($local_array); $i++) {
            if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
                return false;
            }
        }
        if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
            $domain_array = explode(".", $email_array[1]);
            if (sizeof($domain_array) < 2) {
                return false; // Not enough parts to domain
            }
            for ($i = 0; $i < sizeof($domain_array); $i++) {
                if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
                    return false;
                }
            }
        }

        return true;
	}
	
	/**
	 * Get Error
	 */
	public function getError() {
		return $this->error;
	}
	
    /**
     * Return true if form is submited
     */
    static public function submit($val) {
		if (empty ($val)) {
			if (isset($_REQUEST) && !empty($_REQUEST)) return true;
			else return false;
		} else {
			if (isset($_REQUEST[$val])) return true;
			else return false;
		}
    }

    /**
     * Return true if form is submited
     */
    static public function submit_post($val) {
		if (empty ($val)) {
			if (isset($_POST) && !empty($_POST)) return true;
			else return false;
		} else {
			if (isset($_POST[$val])) return true;
			else return false;
		}
    }

    /**
     * Return true if form is submited
     */
    static public function submit_get($val) {
		if (empty ($val)) {
			if (isset($_GET) && !empty($_GET)) return true;
			else return false;
		} else {
			if (isset($_GET[$val])) return true;
			else return false;
		}
    }

    /**
     * Save version of the $_POST
     */
    static public function post($var) {
		if (! empty($_POST[$var])) {
			$result = filter_var($_POST[$var], FILTER_SANITIZE_STRING);

			if (! $result) {
				$_POST[$var] = '';
				return '';
			} else {
				return $result;
			}
		} else {
			return '';
		}
    }
    
    /**
     * Save version of the $_GET
     */
    static public function get($var) {
		return filter_var($_GET[$var], FILTER_SANITIZE_STRING); 
    }

    /**
     * Format input date dd/mm/yyyy to mysql format yyyy-mm-dd
     */
    static public function date2MySQL($date) {
        if (! empty($date)) {
            $pattern = '/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})/';
            preg_match($pattern, $date, $matches);
            $date = $matches['3'] . '-' . $matches['1'] . '-' . $matches['2'];
            
            return $date;
        }
    }
}
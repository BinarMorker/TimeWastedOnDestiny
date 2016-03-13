<?php

/**
 * ExternalURIRequest exception
 * @author Fran�ois Allard <binarmorker@gmail.com>
 * @version 1.8
 */
class ExternalURIRequestException extends Exception {
	
	public function __construct($uri, $context) {
		$message = "URI: " . $uri . 
				   "\nContext: ";
		$options = stream_context_get_options($context);
		
		foreach ($options as $name => $option) {
			if (is_array($option)) {
				$message .= "\n- " . $name . ": ";
				
				foreach ($option as $i_name => $i_option) {
					$message .= "\n--- " . $i_name . ": " . $i_option;
				}
			} else {
				$message .= "\n- " . $name . ": " . $option;
			}
		}
		
		parent::__construct($message);
	}
	
}
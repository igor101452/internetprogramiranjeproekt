<?php
	/**
	  *validacija na podatoci 
	  *-data = pole,tekst za validacija,
	  *-rule = string, edno pravilo ili povekje oddeleni so | pr:('required|email')
	*/
	function validateData($data,$rule)
	{
		//$GLOBALS['validation_errors']  = array();

		if(strpos($rule,'|')!==FALSE)
		{
			$rules = explode('|',$rule);

			foreach($rules as $rule)
			{
				switch($rule)
				{
					case 'required': if(strlen($data)==0 || $data=="")
									  {
										$GLOBALS['validation_errors'][] = "Полето е задолжително";
									  } 
									break;
					case 'email': 	 if (!filter_var($data, FILTER_VALIDATE_EMAIL))
									{
										$GLOBALS['validation_errors'][] = "Ова не е валиден емаил";
									}
									break;
					case 'number':  if(!ctype_digit($data))
									{
										$GLOBALS['validation_errors'][] = "Внесете број";
									}
									break;
					case 'alpha':	if(!ctype_alpha($data))
									{
										$GLOBALS['validation_errors'][] = "Полето може да се состои само од букви";
									}
									break;
				}
			}
		}
		else
		{
			switch($rule)
			{

				case 'required':  if(strlen($data)==0 || $data=="")
									  {

										$GLOBALS['validation_errors'][] = "Полето е задолжително";
									  } 
									break;
					case 'email': 	if (!filter_var($data, FILTER_VALIDATE_EMAIL))
									{
										$GLOBALS['validation_errors'][] = "Ова не е валиден емаил";
									}
									break;
					case 'number':  if(!ctype_digit($data))
									{
										$GLOBALS['validation_errors'][] = "Внесете број";
									}
									break;
					case 'alpha':	if(!ctype_alpha($data))
									{
										$GLOBALS['validation_errors'][] = "Полето може да се состои само од букви";
									}
									break;
			}
		}

	}
?>
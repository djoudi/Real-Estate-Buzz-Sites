<?

class contact_form {

	function __construct()
	{
		add_action('wp_loaded', array(&$this, 'process_form'));
	}
	
	function contact_form()
	{
		$this->__construct();
	}
	
	function process_form()
	{
		if(count($_POST) > 0 && isset($_POST['send-form-trigger']))
		{
			// We are going to do this!
			$message = 'Contact from SanLuisRealEstateBuzz.com'."\r\n\r\n";
			
			foreach($_POST as $key => $value)
			{
				if($key != '_form_submit' && $key != 'send-form-trigger')
				{
					$message .= ucwords(str_replace('_form_', '', $key)).": ".$value."\r\n\r\n";
				}
			}
			
			$headers = 'From: '.$_POST['_form_name'].' <'.$_POST['_form_email'].'>' . "\r\n";
			
			wp_mail('info@sanluisrealestatebuzz.com', 'San Luis Real Estate Buzz Contact', $message,$headers );
			
			global $show_message;
			
			$show_message = true;
			
		}
	}

}
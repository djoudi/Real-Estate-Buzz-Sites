<?

class contact_form {

	function __construct()
	{
		add_action('wp_loaded', array(&$this, 'process_form'));
		add_action('wp_head', array(&$this, 'add_captcha_script'));
	}
	
	function contact_form()
	{
		$this->__construct();
	}
	
	function process_form()
	{
		if(count($_POST) > 0 && isset($_POST['send-form-trigger']))
		{
			// We need to check us some captcha crap!
			
			if(is_null($this->ch))
			{
				$this->ch = curl_init();
			}
			
			$fields = array(
				'privatekey' 	.'='.	'6LdCb8YSAAAAAHH3pc0YsG_WExSdELfS1N1T6Dll',
				'remoteip' 	.'='.	$_SERVER["REMOTE_ADDR"],
				'challenge' 	.'='.	$_POST['recaptcha_challenge_field'],
				'response' 	.'='.	$_POST['recaptcha_response_field']
			);
			
			curl_setopt($this->ch, CURLOPT_URL, 'http://www.google.com/recaptcha/api/verify'); 
			
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($this->ch, CURLOPT_HEADER, 0);
			curl_setopt($this->ch, CURLOPT_TIMEOUT, 5);
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, implode('&',$fields));
			$curl_output = curl_exec($this->ch);
			
			//die(nl2br($curl_output)); //--Debug Die
			// Check us out here... see how we did
			
			$resp = explode("\n", $curl_output);
			
			if($resp[0] == 'true')
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
				
				unset($_POST);
				
				global $show_message;
				
				$show_message = true;
			} else {
				
				$err[] = 'The characters you entered we\'re incorrect. Please try again.';
				global $error_message;
				
				$error_message = $err;
				
			}
			
			
			
		}
	}
	
	function add_captcha_script()
	{
		?>
		<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
		<script>
			$(document).ready(function(){
			Recaptcha.create("6LdCb8YSAAAAAMPai-Bllk4fNrn-ZStG9FQ5OCug",
				"recaptcha_div",
				{
					theme: "white",
					callback: Recaptcha.focus_response_field
				}
			);
			
			});
			
		</script>
		
		<?
	}

}
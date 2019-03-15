<?
class Aes256_lib
{       
	var $key = '237151dc3f4a942b33d998362b9c5143'; // ifamily4112 
	function AES_Encode($plain_text)
	{
		return base64_encode(openssl_encrypt($plain_text, "aes-256-cbc", $this->key, true, str_repeat(chr(0), 16)));
	}

	function AES_Decode($base64_text)
	{
		return openssl_decrypt(base64_decode($base64_text), "aes-256-cbc", $this->key, true, str_repeat(chr(0), 16));
	}
}
?>
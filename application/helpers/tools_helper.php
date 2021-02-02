<?php

function generate_two_factor_auth_key(){
    $key  = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));
    for ($i = 0; $i < 16; $i++) {
        $key .= $keys[array_rand($keys)];
    }
    $key .= uniqid();
    return $key;
}


function generator(){
	$str = "abcdefghijklmnpqrstuvwxyz";
	$num = "12345678900987654321234567890";
	return  substr(str_shuffle(strtoupper($num.$str)), 0,12);
}

function last_four_digit_credit_card($card_num){
	$num_chars = strlen($card_num);
	$num_stars = $num_chars - 4;
	$last_four = substr($card_num, -4);
	$stars[] = '';
	for ($i=10; $i < $num_stars; $i++) { 
		$stars[] = 'XXXX-';
	}
	$stars_now = implode("", $stars);
	$display = $stars_now.$last_four;
	// return $num_stars;
	return $display;
}  

function four_digit_pin($card_num){
	$num_chars = strlen($card_num);
	$num_stars = $num_chars - 4;
	$last_four = substr($card_num, -4);
	$display = $last_four;
	return $display;
}

// secure Crytp
function crypto_rand_secure($min, $max) {
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd >= $range);
    return $min + $rnd;
}

function get_otp($length,$type,$case) {
    $token = "";
    $codeAlphabet = '';
    if ($type == 'alpha') {
         $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    } elseif ($type == 'num') {
        $codeAlphabet.= "0123456789";
    } elseif ($type == 'alphanum') {
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
    }
    if ($case == 'lower') {
        $codeAlphabet = strtolower($codeAlphabet);
    } elseif ($case == 'upper') {
        $codeAlphabet = strtoupper($codeAlphabet);
    }

    $max = strlen($codeAlphabet) - 1;
    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(1, $max)];
    }
    return $token;
}

function get_token($length) {
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet) - 1;
    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max)];
    }
    return $token;
}

// url Encr
function skey(){
	$skey = "$b@bl2I@?%%4K*mC6r273~8l3|6@>D"; // you can change it
	return $skey;
}

function safe_b64encode($param) {

    $data = base64_encode($param);
    $data = str_replace(array('+','/','='),array('-','_',''),$data);
    return $data;
}

function safe_b64decode($param) {
    $data = str_replace(array('-','_'),array('+','/'),$param);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
        $data .= substr('====', $mod4);
    }
    return base64_decode($data);
}

function url_encrypt_decrypt($action, $param){
	$skey = "~08b@bl2I@?%%4K*mC6r273~8l3|6@>D";
	if($action=='encrypt'){
		if(!$param){return false;}
	    $text = $param;
	    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	    $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $skey, $text, MCRYPT_MODE_ECB, $iv);
	    return trim(safe_b64encode($crypttext)); 
	}
	if($action=='decrypt'){
		if(!$param){return false;}
	    $crypttext = safe_b64decode($param); 
	    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	    $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $skey, $crypttext, MCRYPT_MODE_ECB, $iv);
	    return trim($decrypttext);		
	}
}

function is_url_encrypted($param){
	$pid = url_encrypt_decrypt('decrypt',$param);
	$check_is_encrypt = url_encrypt_decrypt('encrypt',$pid);
	return $check_is_encrypt;
}

function generate_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0C2f ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0x2Aff ), mt_rand( 0, 0xffD3 ), mt_rand( 0, 0xff4B )
    );
}

function genGUID(){
    if (function_exists('com_create_guid') === true)
        return trim(com_create_guid(), '{}');
    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return vsprintf('%s%s%s%s%s%s%s%s', str_split(bin2hex($data), 4));
}

function encrypt_password($pass){
    $salt = sha1($pass);   
    return md5(sha1($pass)).sha1(hash('sha256',$salt. $pass));
}


function simple_encode($action, $data){

    if($action == 'encode'){
       return base64_encode(base64_encode($data));
    }

    if($action == 'decode'){
       return base64_decode(base64_decode($data));
    }    
}


function url_end($action = '', $data) {
     
    if($action == 'encode'){
        $ciphering = "AES-128-CTR"; 
        $iv_length = openssl_cipher_iv_length($ciphering); 
        $options = 0; 
        $encryption_iv = 'BadBioRajiBoss00';
        $encryption_key = openssl_digest(php_uname(), 'MD5', TRUE); 
        $encryption = openssl_encrypt($data, $ciphering, 
                    $encryption_key, $options, $encryption_iv); 
        return base64_encode($encryption);            
    }

    if($action == 'decode'){
        $value = base64_decode($data);
        $ciphering = "AES-128-CTR";  
        $decryption_iv = 'BadBioRajiBoss00'; 
        $decryption_key = openssl_digest(php_uname(), 'MD5', TRUE); 
        $options = 0; 
        $decryption = openssl_decrypt ($value, $ciphering, 
                $decryption_key, $options, $decryption_iv); 
        return $decryption; 
    }    
}

// This phone number extraction
function extract_multiple_nigerian_phonenumber($gsm, $return_array = false) {
    // $ci=>
    $gsm = static_extract_valid_gsm($gsm);
    $gsm = static_extract_from_invalid($gsm);
    $gsm = preg_replace("~\D~", " ", $gsm);
    $gsm = static_extract_with_spaces($gsm);
    $gsm = preg_replace("~\s+~",",",$gsm);  
    $gsm = static_format_phonenumber_prefix($gsm);
    if ($return_array == true) {
        return explode(', ', $gsm);
    } else return $gsm;    
}

function static_extract_valid_gsm($phone) {
    $phone = preg_replace("~(234|0)([\s+]|[\-])([7-9][0-1][0-9])([\s+]|[\-])(\d{3})([\s+]|[\-])(\d{4})~", "$1$3$5$7", $phone);
    $phone = preg_replace("~(234|0)([7-9][0-1][0-9])([\s+]|[\-])(\d{3})([\s+]|[\-])(\d{4})~", "$1$2$4$6", $phone);
    return $phone;
}

function static_extract_from_invalid ($phone) {
    $phone = preg_replace("~(234|0)([7-9][0-1][0-9])(\d{7})~", " $1$2$3 ", $phone);
    return $phone;
}

function static_extract_with_spaces($phone) {
    $phone = preg_replace("~(0)(\s)([7-9])(\s)([0-1])(\s)([0-9])(\s)(\d)(\s)(\d)(\s)(\d)(\s)(\d)(\s)(\d)(\s)(\d)(\s)(\d)(\s)~", " $1$3$5$7$9$11$13$15$17$19$21 ", $phone);
    $phone = preg_replace("~(2)(\s)(3)(\s)(4)(\s)([7-9])(\s)([0-1])(\s)([0-9])(\s)(\d)(\s)(\d)(\s)(\d)(\s)(\d)(\s)(\d)(\s)(\d)(\s)(\d)(\s)~", " $1$3$5$7$9$11$13$15$17$19$21$23$25 ", $phone);
    $phone = preg_replace("~(0)([7-9])([0-1])([\s]+|[\-])(\d{4})([\s]+|[\-])(\d{4})~", "$1$2$3$5$7", $phone);
    $phone = preg_replace("~(234)([\s]+|[\-])([7-9][0-1][\d])([\s]+|[\-])(\d{4})([\s]+|[\-])(\d{4})~", "$1$3$5$7", $phone);
    $phone = preg_replace("~([0][7-9][0-1][\d])([\s]+|[\-])(\d{3})([\s]+|[\-])(\d{4})~", "$1$3$5", $phone);
    $phone = preg_replace("~([7-9][0-1][\d])([\s]+|[\-])(\d{3})([\s]+|[\-])(\d{4})~", "$1$3$5", $phone);
    $phone = preg_replace("~(234)([\s]+|[\-])([\(][0][\)])([\s]+|[\-])([7-9][0-1][\d])(\d{7})~", "$1$5$6", $phone);
    $phone = preg_replace("~(234)([\(][0][\)])([7-9][0-1][\d])(\d{7})~", "$1$3$4", $phone);
    $phone = preg_replace("~(234)([\s]+|[\-])([\(][0][\)])([\s]+|[\-])([7-9][0-1][\d])([\s]+|[\-])(\d{3})([\s]+|[\-])(\d{4})~", "$1$5$7$9", $phone);
    return $phone;
}

function static_format_phonenumber_prefix($phones) {
    $phones = explode(',', $phones);
    $gsm = '';
    $x = array(7, 8, 9);
    $y = array('07', '08', '09');
    foreach ($phones as $p) {
        $p = trim($p);
        if (in_array(substr($p, 0, 1), $x) && (strlen($p) == 10)) {
            $gsm .= '234'.$p.',';
        } elseif (in_array(substr($p, 0, 2), $y) && (strlen($p) == 11)) {
            $gsm .= str_replace_once('0', '234', $p).',';                
        } elseif (substr($p, 0, 3) == '234' && (strlen($p) == 13)) {
            $gsm .= $p.',';
        }
    }
    $gsm = explode(',', $gsm);
    $gsm = array_filter(array_unique($gsm));
    $gsm = implode(', ', $gsm);
    return $gsm;
}

function str_replace_once($str_pattern, $str_replacement, $string) {
    if (strpos($string, $str_pattern) !== false){
        $occurrence = strpos($string, $str_pattern);
        return substr_replace($string, $str_replacement, strpos($string, $str_pattern), strlen($str_pattern));
    }
    

    return $string;
}

function detectNetwork($phoneNo){
    $phoneNo = (substr($phoneNo, 0, 1) == "+") ? substr($phoneNo, 1) : $phoneNo;// don't change - it removes +
    // don't change - it replaces 234 with 0
    $phoneNo = (substr($phoneNo, 0, 3) == "234") ? "0".substr($phoneNo, 3) :  $phoneNo;
    // remove one '0' in case a number starts with 00
    $phoneNo = (substr($phoneNo, 0, 2) == "00") ? substr($phoneNo, 1) : $phoneNo; 

    $get4Prefix = substr($phoneNo, 0, 4);//0806
    $get5Prefix = substr($phoneNo, 0, 5);//08060 because of some of the networks

    $query = get_instance()->db->get_where(db_prefix().'prefixes',['prefix'=>$get5Prefix,'prefix'=>$get4Prefix]);

    if($query->num_rows())
        return $query->row()->network;
    else
        return FALSE;
}

function filter_phone($phoneNo){
    $phoneNo = (substr($phoneNo, 0, 3) == "234") ? "0".substr($phoneNo, 3) :  $phoneNo;
    return $phoneNo;
}



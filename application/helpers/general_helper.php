<?php

function user_rdir($controller, $sub_controller){
	$CI	=&	get_instance();
	$CI->Crud->is_user();
	redirect(base_url().'bank/in/'.$controller.'/'.strtolower($CI->session->userdata('firstname')).'/'.$sub_controller.'/', 'refresh');
}

function user_url($controller, $sub_controller){
    $CI =&  get_instance();
    $CI->Crud->is_user();
    redirect(base_url().'bank/in/'.$controller.'/'.strtolower($CI->session->userdata('firstname')).'/'.$sub_controller.'/', 'refresh');
}

function control_url($controller){
	$CI	=&	get_instance();
	redirect(base_url().'control/'.$controller.'/'.strtolower($CI->session->userdata('username')).'/'.$CI->session->userdata('eid').'/', 'refresh');
}

function sales_url($controller){
    $CI =&  get_instance();
    redirect(base_url().'sales/'.$controller.'/'.strtolower($CI->session->userdata('username')).'/'.$CI->session->userdata('eid').'/', 'refresh');
}

function admin_nav($controller, $sub_controller){
	$CI	=&	get_instance();
	$CI->Crud->is_admin();
	return base_url().'admin/control/'.$controller.'/'.strtolower($CI->session->userdata('firstname')).'/'.$sub_controller.'/';
}

function rdir($param = Null){
	if($param != Null){
        redirect(base_url($param),'refresh');
    }else{
        redirect(base_url(),'refresh');
    }
}

function rdir_login(){
    redirect(base_url().'login','refresh');
}

if(!function_exists('nav_url')){
	function nav_url($controller,$sub_controller){
		$CI	=&	get_instance();
		return base_url().'bank/in/'.$controller.'/'.strtolower($CI->session->userdata('firstname')).'/'.$sub_controller.'/';
	}
}

function ip_address(){
	if (!empty($_SERVER["REMOTE_ADDR"])){
        $ip_address = $_SERVER["REMOTE_ADDR"];
    }
    elseif(!empty($_SERVER["HTTP_CLIENT_IP"])){
        $ip_address = $_SERVER["HTTP_CLIENT_IP"];
    }else{
        $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    if(!empty($ip_address)){
            $handle = fopen("approved_ips.txt", 'a');
            fwrite($handle, $ip_address.',');
            // implode(',', $ip_address);
    }  

    return $ip_address; 
}

function set_alert($type, $message){
    get_instance()->session->set_flashdata('message-' . $type, $message);
}

function set_sweetalert($type, $message = []){
    get_instance()->session->set_flashdata('alert-' . $type, $message['msg']);
    get_instance()->session->set_flashdata('alert-title', $message['title']);
}
  
function blank_page($message = '', $alert = 'danger'){
    set_alert($alert, $message);
    redirect(admin_url('not_found'));
}

function set_lastpage($page){
   get_instance()->session->set_userdata('last_page',$page);
}

if (!function_exists('is_active')){
	function is_active($selected_page_name = "") {
        $CI	=&	get_instance();
        if ($CI->session->userdata('last_page') == $selected_page_name){
            return "active";
        }else {
            return "";
        }
	}
}

if (!function_exists('is_multi_level_active')){
    function is_multi_level_active($selected_pages = "", $item = "") {
        $CI	=&	get_instance();
		for ($i = 0; $i < sizeof($selected_pages); $i++) {
			if ($CI->session->userdata('last_page') == $selected_pages[$i]) {
	            if ($item == 1) {
	                return "opened active";
	            }else {
	                return "opened";
	            }
	        }
		}
		return "";
    }
}


function set_date(){
    $CI =&  get_instance();
	if($CI->session->userdata('uid')){
        date_default_timezone_set(getUser()->timezone);
	    $DateTime = date('Y-m-d - h:i:s A', time());
    }
    date_default_timezone_set('Africa/Lagos');
	$DateTime = date('Y-m-d - h:i:s A', time());
	return $DateTime;
}

function date_expire($today = '', $expire=''){
    date_default_timezone_set('Africa/Lagos');
    if($today != '' && $expire != ''){
        return date("Y-m-d", strtotime($today . $expire));
    }
    if($today==''){
        return date("Y-m-d", strtotime(date("Y-m-d") . $expire));
    }
}

function unset_data($uid) {
    $CI =&  get_instance();
	if($CI->session->userdata($uid)) {
	    $CI->session->unset_userdata($uid);
	    return TRUE;
	}
	return FALSE;
}

function getUser($uid = NULL, $eid = NULL){
    $CI =&  get_instance();
    if(!$uid){ $uid = $CI->session->userdata('uid'); $eid = $CI->session->userdata('eid'); }
    $q = $CI->db
        ->where('userid',$uid)
        ->where('eid',$eid)
        ->get(db_prefix().'users');
    if ($q->num_rows() > 0) {
       $data = $q->row();
        return $data;
    }
    return FALSE;
}


function convert_number_to_words($number){
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' ';
    $dictionary  = array(
        0                   => '',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
    
    if (!is_numeric($number)) {
        return FALSE;
    }
    
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return FALSE;
    }

    if ($number < 0) {
        return $negative . $this->convert_number_to_words(abs($number));
    }
    
    $string = $fraction = null;
    
    if (strpos($number, '.') !== FALSE) {
        list($number, $fraction) = explode('.', $number);
    }
    
    switch (TRUE) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . $this->convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= $this->convert_number_to_words($remainder);
            }
            break;
    }
    
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    
    return $string;
}

function settings($type){

    $query =  get_instance()->db->get_where(db_prefix().'settings',['type' => $type]);
    if($query->num_rows()>0){
        return $query->row()->description;
    }
    return FALSE;
}



function show() {
    $CI =& get_instance();
    $CI->load->library('session');
    $show = '';
    if ($CI->session->flashdata('e_msg')) {
        $er_msg = $CI->session->flashdata('e_msg');
        $show .= '<div class="uk-alert-danger" uk-alert>';
        foreach ($er_msg as $e) {
            $show .= '<a class="uk-alert-close" uk-close></a>';
            $show .= '<p>';
            $show .= $e;
            $show .= '</p>';
        }
        $show .= '</div>';

    } elseif ($CI->session->flashdata('s_msg')) {
        $sc_msg = $CI->session->flashdata('s_msg');
        $show .= '<div class="uk-alert-success" uk-alert>';
        foreach ($sc_msg as $s) {
            $show .= '<p>';
            $show .= '<a class="uk-alert-close" uk-close></a>';
            $show .= $s;
            $show .= '</p>';
        }
        $show .= '</div>';
    }

    echo $show;
}

function set($response) {
    $CI =& get_instance();
    $CI->load->library('session');
    $show = '';
    if (strpos($response[0], 'successfully') > 0) {
        $msg = $CI->session->set_flashdata('s_msg',$response);
    } else {
        $msg = $CI->session->set_flashdata('e_msg',$response);
    }
}

function setback_response($alert_type='', $alert_message='', $last_page=''){
    $meta = ['responses' => ['type' => $alert_type, 'message' => $alert_message], 'last_page' => $last_page ];
   if(($meta) ? $meta : $meta){
     return $meta;
   }
   return FALSE;
}


function FunctionName(){
    // $this->load->library('user_agent');
    if ($this->agent->is_browser()){
            $agent = $this->agent->browser().' '.$this->agent->version();
    }
    
    if ($this->agent->is_robot()){
            $agent = $this->agent->robot();
    }

    if ($this->agent->is_mobile()){
            $agent = $this->agent->mobile();
    }

    else{
            return $agent = 'Unidentified User Agent';
    }

    return $agent;

    return $this->agent->platform(); // Platform info (Windows, Linux, Mac, etc.)

}

function is_mobile(){
    if (get_instance()->agent->is_mobile()) {
        return TRUE;
    }

    return FALSE;
}

function url_username_and_eid($username,$eid){
    $CI =& get_instance();
    if($username == strtolower($CI->session->userdata('username')) && $eid ==
        $CI->session->userdata('eid')){
        return TRUE;
    }

    return FALSE;
}

function get_timezones_list(){
    return [
    'EUROPE'     => DateTimeZone::listIdentifiers(DateTimeZone::EUROPE),
    'AMERICA'    => DateTimeZone::listIdentifiers(DateTimeZone::AMERICA),
    'INDIAN'     => DateTimeZone::listIdentifiers(DateTimeZone::INDIAN),
    'AUSTRALIA'  => DateTimeZone::listIdentifiers(DateTimeZone::AUSTRALIA),
    'ASIA'       => DateTimeZone::listIdentifiers(DateTimeZone::ASIA),
    'AFRICA'     => DateTimeZone::listIdentifiers(DateTimeZone::AFRICA),
    'ANTARCTICA' => DateTimeZone::listIdentifiers(DateTimeZone::ANTARCTICA),
    'ARCTIC'     => DateTimeZone::listIdentifiers(DateTimeZone::ARCTIC),
    'ATLANTIC'   => DateTimeZone::listIdentifiers(DateTimeZone::ATLANTIC),
    'PACIFIC'    => DateTimeZone::listIdentifiers(DateTimeZone::PACIFIC),
    'UTC'        => DateTimeZone::listIdentifiers(DateTimeZone::UTC),
    ];
}
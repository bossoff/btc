<?php
/**
 * 
 */
class AuthModel extends CI_Model
{
	private $vcn_errors = [];
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('Alert');
	}

	public function set_alert(){
		
		if ($this->vcn_errors != null) $this->alert->set($this->vcn_errors);
		$ar = array('code'=>'100', 'status'=>'success');
		die(var_dump($ar));
	}


	public function checkLogin($email, $name = '')
	{
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->vcn_errors[] = 'Invalid email submitted.';
		}

		if (strlen($name) < 3) {
			$this->vcn_errors[] = 'Invalid name submitted.';
		}

		if ($this->vcn_errors != null) return false;
	}
}


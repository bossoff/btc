<?php

class request extends CI_controller{
	
	// function __construct(argument)
	// {
	// 	# code...
	// }

	public function index(){
		
		$this->home();

	}

	public function login(){

		$data = [
			'page_name' => 'login', 
			'page_title' => 'Login'
		];

		$this->load->view('front/index', $data);	
	}

	public function home(){

		$data = [
			'page_name' => 'home', 
			'page_title' => 'Home'
		];

		$this->load->view('front/index', $data);	
	}

	public function company(){

		$data = [
			'page_name' => 'company', 
			'page_title' => 'Company'
		];

		$this->load->view('front/index', $data);	
	}

	public function support(){

		$data = [
			'page_name' => 'support', 
			'page_title' => 'Support'
		];

		$this->load->view('front/index', $data);	
	}

	public function market(){

		$data = [
			'page_name' => 'market', 
			'page_title' => 'Word Market'
		];

		$this->load->view('front/index', $data);	
	}

	public function faqs(){

		$data = [
			'page_name' => 'faqs', 
			'page_title' => 'Frequent Questions'
		];

		$this->load->view('front/index', $data);	
	}

	public function review(){

		$data = [
			'page_name' => 'review', 
			'page_title' => 'Reviews'
		];

		$this->load->view('front/index', $data);	
	}

	public function investment(){

		$data = [
			'page_name' => 'investment', 
			'page_title' => 'Investment Plan'
		];

		$this->load->view('front/index', $data);	
	}

	// public function lock_screen(){

	// 	$data = [
	// 		'page_name' => 'lockscreen', 
	// 		'page_title' => 'Login', 
	// 		'users' =>  getUser()
	// 	];

	// 	$this->load->view('auth/index', $data);
	// }

}
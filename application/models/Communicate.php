<?php
class Communicate extends CI_model{
	
	function __construct(){
		parent::__construct();
		$this->load->model('Mailer');
		$default = [
			'company_link' => base_url(),	
			'company_name' => settings('system_name'),
			'logo' => settings('system_name'),
		];
	}

	public function activation($data=[]){
		$replaceablePatterns = [
			'mailto', 'firstname', 'lastname', 
			'button_name','activate_link',
			// mail path
			'company_link', 'company_name', 'slogan',
			'logo', 'email_signature', 'year'
		];

		// Here is your template
		$temp = $this->get($data['mail_type'],'row');

		$mail_message = $temp->message;
		$mail_subject = $temp->subject;
		$mail_fromname = $temp->fromname;
		$mail_fromnemail = $temp->fromemail;

		foreach ($replaceablePatterns as $pattern) {
			$search_pattern = "{".$pattern."}";//Concatenating the curly brackets
			if(preg_match($search_pattern, $mail_message)){
				$mail_message = preg_replace($search_pattern, $data[$pattern], $mail_message);
			}

			if(preg_match($search_pattern, $mail_subject)){
				$mail_subject = preg_replace($search_pattern, $data[$pattern], $mail_subject);
			}

			if(preg_match($search_pattern, $mail_fromname)){
				$mail_fromname = preg_replace($search_pattern, $data[$pattern], $mail_fromname);
			}

			if(preg_match($search_pattern, $mail_fromname)){
				$mail_fromname = preg_replace($search_pattern, $data[$pattern], $mail_fromname);
			}

		}
		$mailto = $data['mailto'];

		$message_curly = str_replace("{", "", $mail_message);
		$message = str_replace("}", "", $message_curly);

		$subject_curly = str_replace("{", "", $mail_subject);
		$subject = str_replace("}", "", $subject_curly);

		$fromname_curly = str_replace("{", "", $mail_fromname);
		$fromname = str_replace("}", "", $fromname_curly);

		$fromemail = $mail_fromnemail;
		// die($message);
		// die(var_dump($data['mailto']));
		$send = $this->send_email($mailto,$subject,$message,$fromemail,$fromname);
	}

	public function welcome($data=[]){
		$replaceablePatterns = [
			'mailto', 'firstname', 'lastname', 
			'button_name','reset_link',
			// mail path
			'company_link', 'company_name', 'slogan',
			'logo', 'email_signature', 'year'
		];

		// Here is your template
		$temp = $this->get($data['mail_type'],'row');
		$mail_message = $temp->message;
		$mail_subject = $temp->subject;
		$mail_fromname = $temp->fromname;
		$mail_fromnemail = $temp->fromemail;

		foreach ($replaceablePatterns as $pattern) {
			$search_pattern = "{".$pattern."}";//Concatenating the curly brackets
			if(preg_match($search_pattern, $mail_message)){
				$mail_message = preg_replace($search_pattern, $data[$pattern], $mail_message);
			}

			if(preg_match($search_pattern, $mail_subject)){
				$mail_subject = preg_replace($search_pattern, $data[$pattern], $mail_subject);
			}

			if(preg_match($search_pattern, $mail_fromname)){
				$mail_fromname = preg_replace($search_pattern, $data[$pattern], $mail_fromname);
			}

			if(preg_match($search_pattern, $mail_fromname)){
				$mail_fromname = preg_replace($search_pattern, $data[$pattern], $mail_fromname);
			}

		}

		$mailto = $data['mailto'];

		$message_curly = str_replace("{", "", $mail_message);
		$message = str_replace("}", "", $message_curly);

		$subject_curly = str_replace("{", "", $mail_subject);
		$subject = str_replace("}", "", $subject_curly);

		$fromname_curly = str_replace("{", "", $mail_fromname);
		$fromname = str_replace("}", "", $fromname_curly);

		$fromemail = $mail_fromnemail;
		// die($message);
		$send = $this->send_email($mailto,$subject,$message,$fromemail,$fromname);
		
	}

	public function password_reset($data=[]){

		$replaceablePatterns = [

			'mailto', 'firstname', 'lastname', 
			'button_name','reset_link','activate_link',
			
			// mail path
			'company_link', 'company_name', 'slogan',
			'logo', 'email_signature', 'year'
		];

		// Here is your template
		$temp = $this->get($data['mail_type'],'row');

		$mail_message = $temp->message;
		$mail_subject = $temp->subject;
		$mail_fromname = $temp->fromname;
		$mail_fromnemail = $temp->fromemail;

		foreach ($replaceablePatterns as $pattern) {
			$search_pattern = "{".$pattern."}";//Concatenating the curly brackets
			if(preg_match($search_pattern, $mail_message)){
				$mail_message = preg_replace($search_pattern, $data[$pattern], $mail_message);
			}

			if(preg_match($search_pattern, $mail_subject)){
				$mail_subject = preg_replace($search_pattern, $data[$pattern], $mail_subject);
			}

			if(preg_match($search_pattern, $mail_fromname)){
				$mail_fromname = preg_replace($search_pattern, $data[$pattern], $mail_fromname);
			}

			if(preg_match($search_pattern, $mail_fromname)){
				$mail_fromname = preg_replace($search_pattern, $data[$pattern], $mail_fromname);
			}

		}

		$mailto = $data['mailto'];

		$message_curly = str_replace("{", "", $mail_message);
		$message = str_replace("}", "", $message_curly);

		$subject_curly = str_replace("{", "", $mail_subject);
		$subject = str_replace("}", "", $subject_curly);

		$fromname_curly = str_replace("{", "", $mail_fromname);
		$fromname = str_replace("}", "", $fromname_curly);

		$fromemail = $mail_fromnemail;
		// die($message);
		$send = $this->send_email($mailto,$subject,$message,$fromemail,$fromname);
	}

	public function replace_pathern($data){
    	$replaceablePatterns = [

			'mailto', 'firstname', 'lastname', 
			'button_name','reset_link',
			// mail path
			'company_link', 'company_name', 'slogan',
			'logo', 'email_signature', 'year'
		];

		// Here is your template
		$temp = $this->get($data['mail_type'],'row');

		$mail_message = $temp->message;
		$mail_subject = $temp->subject;
		$mail_fromname = $temp->fromname;
		$mail_fromnemail = $temp->fromemail;

		foreach ($replaceablePatterns as $pattern) {
			$search_pattern = "{".$pattern."}";//Concatenating the curly brackets
			if(preg_match($search_pattern, $mail_message)){
				$mail_message = preg_replace($search_pattern, $data[$pattern], $mail_message);
			}

			if(preg_match($search_pattern, $mail_subject)){
				$mail_subject = preg_replace($search_pattern, $data[$pattern], $mail_subject);
			}

			if(preg_match($search_pattern, $mail_fromname)){
				$mail_fromname = preg_replace($search_pattern, $data[$pattern], $mail_fromname);
			}

			if(preg_match($search_pattern, $mail_fromname)){
				$mail_fromname = preg_replace($search_pattern, $data[$pattern], $mail_fromname);
			}
		}

		$mailto = $data['mailto'];

		$message_curly = str_replace("{", "", $mail_message);
		$message = str_replace("}", "", $message_curly);

		$subject_curly = str_replace("{", "", $mail_subject);
		$subject = str_replace("}", "", $subject_curly);

		$fromname_curly = str_replace("{", "", $mail_fromname);
		$fromname = str_replace("}", "", $fromname_curly);

		$fromemail = $mail_fromnemail;

		return ['mailto' => $mailto,'message' => $message, 'subject' => $subject, 'fromname' => $fromname, 'fromemail' => $fromemail];
    }

	// public function password_reset1($data=[]){

	// 	$replaceablePatterns = [

	// 		'mailto', 'firstname', 'lastname', 
	// 		'button_name','reset_link',
	// 		// mail path
	// 		'company_link', 'company_name', 'slogan',
	// 		'logo', 'email_signature', 'year'
	// 	];

	// 	// Here is your template
	// 	$temp = $this->get($data['mail_type'],'row');
	// 	$mail_message = $temp->message;
	// 	$mail_subject = $temp->subject;
	// 	$mail_fromname = $temp->fromname;
	// 	$mail_fromnemail = $temp->fromemail;

	// 	foreach ($replaceablePatterns as $pattern) {
	// 		$search_pattern = "{".$pattern."}";//Concatenating the curly brackets
	// 		if (strpos($mail_message, $search_pattern)) {
	// 			$message = str_replace($search_pattern, $data[$pattern], $mail_message);
	// 		}

	// 		if (strpos($mail_subject, $search_pattern)) {
	// 			$subject = str_replace($search_pattern, $data[$pattern], $mail_subject);
	// 		}

	// 		if (strpos($mail_fromname, $search_pattern)) {
	// 			$fromname = str_replace($search_pattern, $data[$pattern], $mail_fromname);
	// 		}
	// 	}

	// 	$mailto = $data['mailto'];
	// 	$fromemail = $mail_fromnemail;
	// 	$send = $this->send_email($mailto,$subject,$message,$fromemail,$fromname);
	// }

	public function get($where = [], $result_type = 'result_array'){
        return $this->db->get_where(db_prefix() . 'mailtemplates',['type'=>$where,'active'=>1])->{$result_type}();
    }

   
    public function get_email_template_by_id($id){
        $this->db->where('emailtemplateid', $id);
        return $this->db->get(db_prefix() . 'mailtemplates')->row();
    }

    
    public function add_template($data){
        $this->db->insert(db_prefix() . 'mailtemplates', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            return $insert_id;
        }

        return false;
    }

    

    public function send_email($to, $subject, $message, $from_email = NULL, $from_name = NULL, $attachment = NULL, $cc = NULL, $bcc = NULL){

    	return $this->Mailer->send_email($to, $subject, $message, $from_email, $from_name, $attachment, $cc,$bcc);
    }

}

?>

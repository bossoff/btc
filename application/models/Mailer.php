<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailer extends CI_Model {
	
	/***custom email sender****/

	public function send__mail($msg=NULL, $sub=NULL, $to=NULL, $from=NULL) {
		//Load email library
		$this->load->library('email');

		if($from == NULL) $from	= $this->db->get_where('settings' , array('type' => 'system_email2'))->row()->description;

		//SMTP & mail configuration
		$get = $this->db->where('type','eyf')->get('smtp_settings')->row();

		$config['protocol'] 	= 	$get->protocol;
		$config['smtp_host'] 	= 	$get->host;
		$config['smtp_port'] 	= 	$get->port;
		$config['smtp_user'] 	= 	$get->username;
		$config['smtp_pass'] 	= 	$get->password;
		$config['wordwrap'] 	= 	TRUE;
		$config['mailtype'] 	= 	'html';
		$config['charset'] 		= 	'utf-8';
		// $config['newline'] 		= 	"\r\n";

		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");

		//Email content
		// $htmlContent = '<h1>Sending email via SMTP server</h1>';
		// $htmlContent .= '<p>This email has sent via SMTP server from CodeIgniter application.</p>';
		$htmlContent = $msg; 

		$this->email->to($to);
		$this->email->from($from, $this->db->get_where('settings' , ['type' => 'system_name'])->row()->description);
		$this->email->subject($sub);
		$this->email->message($htmlContent);

		//Send email
		//$this->email->print_debugger();
		if ($attachmenttrue == true) {
            $this->email->addAttachment($attachment);
        }

		//send the message, check for errors
        if (!$this->email->send()) {
            echo json_encode(array('status' => 'Error', 'message' => $this->email->ErrorInfo));
        } else {
            echo json_encode(array('status' => 'Success', 'message' => 'Email Sent Successfully!'));
        }
	}


	public function send_email($to, $subject, $message, $from_email = NULL, $from_name = NULL, $attachment = NULL, $cc = NULL, $bcc = NULL, $sender=Null) {

        // if($from == NULL) $from = settings('system_email2');

        //SMTP & mail configuration
        $settings = $this->Crud->smtp('test');

        $this->load->library('email');
        $config['protocol'] = $settings->protocol;
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $config['wordwrap']     =   TRUE;
        if ($settings->protocol == 'smtp') {
            $config['smtp_host'] = $settings->host;
            $config['smtp_user'] = $settings->user;
            $config['smtp_pass'] = $settings->pass;
            $config['smtp_port'] = $settings->port;
        } 

        // if ($settings->protocol == 'sendmail') {
        //     $config['mailpath'] = $settings->mailpath;
        // }

        $this->email->initialize($config);

        if($from_email && $from_name){
            $this->email->from($from_email, $from_name);
        } elseif($from) {
            $this->email->from($from_email, settings('system_name'));
        }else {
            $this->email->from($settings->no_reply,settings('system_name'));
        }

        $this->email->to($to);
        if ($cc) {
            $this->email->cc($cc);
        }
        if ($bcc) {
            $this->email->bcc($bcc);
        }
        $this->email->subject($subject);
        $this->email->message($message);
        if ($attachment) {
            if(is_array($attachment)) {
                $this->email->attach($attachment['file'], '', $attachment['name'], $attachment['mine']);
            } else {
                $this->email->attach($attachment);
            }
        }
        // else{
        //     $this->email->addAttachment($attachment); 
        // }

        if ($this->email->send()) {
            // echo $this->email->print_debugger(); die('TRUE Returen');
            return TRUE;
        } else {
            // echo $this->email->print_debugger(); die('FALSE Returen');
            return FALSE;
        }
    }
   
}






		

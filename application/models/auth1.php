<?php

class Auth extends CI_Model{	

 	public function user_login($username, $password, $remember = FALSE){
        // Remove cookies first
        $cookie = [
        	'name' => 'users',
            'value' => '',
            'expire' => -3600,
            'path' => '/',
        ];
        $this->input->set_cookie($cookie);
        $data['lock'] = 0;
        $this->db->where('username',$username)->update(db_prefix().'users',$data);

        if (!$this->update_login_attempts()){
            set_alert('danger', 'Login Attempts Exceeded');
            return TRUE;
        }
       
        if(LOGIN_WITH_USERNAME == TRUE){
            // if (!$username OR strlen($pass) < min OR strlen($pass) > max){
            if (!$username){
                set_alert('danger', 'Login Failed. Username');
                return TRUE;
            }
            $db_username = 'username';
        } 

        if(LOGIN_WITH_EMAIL == TRUE){
            if (!valid_email($username) || !filter_var($username, FILTER_VALIDATE_EMAIL)){
                set_alert('danger', 'Login Failed. Invalid Email Address');
                return TRUE;
            }
            $db_username = 'email';
        }

        $query = null;

        // if users is banned
        $query = $this->db->where($db_username,$username)->where('banned', 1)->get(db_prefix().'users');

        if ($query->num_rows() > 0){
            set_alert('info', 'Login Failed. Account has been block');
            return TRUE;
        }
        // if users is not verified
        $query = $this->db->where($db_username,$username)->where('active', 0)->get(db_prefix().'users');
        if ($query->num_rows() > 0){
            set_alert('danger', 'Login Failed. Account has not been verified');
            return TRUE;
        }
        // to find user id, create sessions and cookies
        $query = $this->db->where($db_username,$username)->get(db_prefix().'users');
        if ($query->num_rows() == 0){
            set_alert('danger', 'Login Failed. No user found');
            return TRUE;
        }

        $query = $this->db->where($db_username,$username)->where('banned', 0)->where('active',1)->get(db_prefix().'users');
        if($query->num_rows() > 0){
        	$row = $query->row();        	
        }
        // if email and pass matches and not banned
        $pass = encrypt_password($password);
        if ($query->num_rows() != 0 && $pass == $row->password){
        	// $row = $query->row();
            // If email and pass matches
            // create session
            $usersdata = [
            	'uid' => $row->userid,
            	'eid' => $row->eid,
                'username' => $row->username,
                'email' => $row->email,
                'user_type' => $row->user_type,
                'loggedin' => TRUE
            ];

            $this->session->set_userdata($usersdata);

            // set_alert('danger', 'Login Failed. Invalid Login Credentials');
            // return TRUE; 

            if($remember){
                $expire =  '+1 days';
                $today = date("Y-m-d");
                $remember_date = date_expire($today,$expire);                
                $token = get_token(16);
                $this->update_remember($row->userid, $row->eid, $token, $remember_date);
                $cookie = [
                	'name' => 'user',
                    'value' => $row->userid . "-" . $token,
                    'expire' => 99 * 999 * 999,
                    'path' => '/',
                ];
                $this->input->set_cookie($cookie);

             //    set_alert('danger', print_r($this->input->set_cookie($cookie)));
            	// return TRUE;
            }

            // update last login
            $this->update_last_login($row->userid,$row->eid);
            $this->update_activity();
          
            if (RESET_LOGIN_ATTEMPT == TRUE){
                $this->reset_login_attempts();
            }

            return TRUE;
        } // if not matches
        
        set_alert('danger', 'Login Failed. Invalid Login Credentials');
        return TRUE;        
    }

   	//Check user login

    public function check_loggedin(){

        if ($this->session->userdata('loggedin')){
            return TRUE;
        }
        
        if (!$this->input->cookie('user', TRUE)){
            return FALSE;
        } else {
            $cookie =  explode('-', $this->input->cookie('user', TRUE));
            if (!is_numeric($cookie[0]) OR strlen($cookie[1]) < 13){
                return FALSE;
            } else {
                $query = $this->db->where('userid', $cookie[0])
                 				->where('remember_exp', $cookie[1])
                 				->get(db_prefix().'users');

                $row = $query->row();

                if ($query->num_rows() < 1){
                    // $this->update_remember($cookie[0]);
                    return FALSE;
                } else {

                    if (strtotime($row->remember_time) > strtotime("now")){
                        // $this->login_fast($cookie[0]);
                        return TRUE;
                    } // if time is expired
                    else {
                        return FALSE;
                    }
                }
            }
        }

        return FALSE;
    }

    //Update last login

    public function update_last_login($user_id = FALSE, $eid){

        if ($user_id == FALSE) $user_id = $this->session->userdata('uid');

        $data['last_login'] = set_date();
        $data['last_ip'] = ip_address();

        $query = $this->db->where('userid', $user_id)->where('eid', $eid)->update(db_prefix().'users', $data);
        return $query;
    }

	// Reset login attempts
    public function reset_login_attempts(){
        $ip_address = ip_address();
        return $this->db
        			->where('ip_address', $ip_address)
        			->where('timestamp >=', date("'Y-m-d - h:i:s A", strtotime("-" . '5 minutes')))
        			->delete(db_prefix().'login_attempts');
    }

    // Update login attempt and if exceeds return FALSE
    public function update_login_attempts(){
        $ip_address = ip_address(); 
        $query = $this->db
        			->where('ip_address', $ip_address)
        			->where('timestamp >=', date("'Y-m-d - h:i:s A", strtotime("-" . '5 minutes')))
        			->get(db_prefix().'login_attempts');

        if ($query->num_rows() == 0){
            $data['ip_address'] = $ip_address;
            $data['timestamp'] = set_date();
            $data['login_attempts'] = 1;
            $this->db->insert(db_prefix().'login_attempts', $data);
            return TRUE;
        } 

        if ($query->num_rows() >0){
            $row = $query->row();
            $data['timestamp'] = set_date();
            $data['login_attempts'] = $row->login_attempts + 1;
          
            $this->db->where('id', $row->id)->update(db_prefix().'login_attempts', $data);

            if ($data['login_attempts'] > 5){
                return FALSE;
            } else {
                return TRUE;
            }
        }

    }

    //Get login attempt
    public function get_login_attempts(){
        $ip_address = ip_address();
        $query = $this->db
        			->where('ip_address', $ip_address)
        			->where('timestamp >=', date("'Y-m-d - h:i:s A", strtotime("-" . '5 minutes')))
        			->get(db_prefix().'login_attempts');

        if ($query->num_rows() != 0){
            $row = $query->row();
            return $row->login_attempts;
        }

        return 0;
    }

    // Update remember

    public function update_remember($user_id, $eid, $expression = null, $expire = null){

        $data['remember_time'] = $expire;
        $data['remember_exp'] = $expression;
        $query = $this->db->where('userid', $user_id)->where('eid', $eid)->update(db_prefix().'users', $data);
        return $query;

    }

    //last Activities
	public function update_activity($user_id = FALSE){

	    if ($user_id == FALSE) $user_id = $this->session->userdata('uid');

	    if ($user_id == FALSE){
	        return FALSE;
	    }

	    $data['last_activity'] = set_date();
	    return $this->db->where('userid', $user_id)->update(db_prefix().'users', $data);
	}

	// app Log
	public function logdata($param1){
 		$data['note']  = $param1;
 		$data['creation_date']  = set_date();
 		$data['uid']  = $this->session->userdata('uid');
        $query = $this->db->insert(db_prefix().'log', $data);
        return $query;
    }
}






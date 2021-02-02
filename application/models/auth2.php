<?php

class Auth extends CI_Model{

    private $userid;

    private $vcn_errors = [];

    public function validate_user($uid){
        

    }	

 	public function user_login($username, $password, $remember = FALSE){
        set_cookie([
            'name' => 'username',
            'value' => '',
            'expire' => -3600,
            'path' => '/',
        ]);
        
        if(!$this->update_login_attempts()){
            set_alert('danger', 'Login Attempts Exceeded');
            return false;
        }
        

        if(settings('login_with_username') == 1){
            // if (!$username OR strlen($pass) < min OR strlen($pass) > max){
            if (!$username){
                set_alert('danger', '<strong>Error Login:</strong> Username');
                rdir('login');
            }
            $db_username = 'username';
        } 

        if(settings('login_with_email') == 1){
            if (!valid_email($username) || !filter_var($username, FILTER_VALIDATE_EMAIL)){
                set_alert('danger', '<strong>Error Login:</strong> Invalid Email Address');
                rdir('login');
            }
            $db_username = 'email';
        }

        if(settings('login_with_phone') == 1){
            if (!$username){
                set_alert('danger', '<strong>Error Login:</strong> Invalid Phone Number');
                rdir('login');
            }
            $db_username = 'phone_no';
        }

        $query = Null;

        // if users is banned
        $query = $this->db->where($db_username,$username)->where('banned', 1)->get(db_prefix().'users');

        if ($query->num_rows() > 0){
            set_alert('info', '<strong>Error Login:</strong> Account has been block');
            rdir('login');
        }
        // if users is not verified
        $query = $this->db->where($db_username,$username)->where('active', 0)->get(db_prefix().'users');
        if ($query->num_rows() > 0){
            set_alert('info', '<strong>Denied:</strong> Account has not been verified');
            rdir('login');
        }
        // to find user id, create sessions and cookies
        $query = $this->db->where($db_username,$username)->get(db_prefix().'users');
        if ($query->num_rows() == 0){
            set_alert('danger', '<strong>Error Login:</strong> No user found');
            rdir('login');
        }

        $query = $this->db->where($db_username,$username)->where('banned', 0)->where('active',1)->get(db_prefix().'users');
        if($query->num_rows() > 0){
            $row = $query->row();           
        }

        $pass = encrypt_password($password);
        if ($query->num_rows() !== 0 && $pass == $row->password){
             $usersdata = [
                'uid' => $row->userid,
                'eid' => $row->eid,
                'branch' => $row->branch,
                'username' => $row->username,
                'email' => $row->email,
                'user_type' => $row->user_type,
                'loggedin' => TRUE
            ];

            $this->session->set_userdata($usersdata);

            if($remember){
                $expire =  '+1 days';
                $today = date("Y-m-d");
                $remember_date = date_expire($today,$expire);                
                $token = get_token(16);
                $expired = 99 * 999 * 999;
                $this->update_remember($row->userid, $row->eid, $token, $remember_date);

                set_cookie([
                    'name' => 'uid',
                    'value' => $row->userid,
                    'expire' => $expired,
                ]);

               set_cookie([
                    'name' => 'remember_code',
                    'value' => $token,
                    'expire' => $expired
                ]);
            }
            // update last login
            $this->update_last_login($row->userid,$row->eid);
            $this->update_activity();
          
            if (RESET_LOGIN_ATTEMPT == TRUE){
                $this->reset_login_attempts();
            }

            return TRUE;
        } // if not matches
        return FALSE;   
    }

    //Check user login
    public function check_loggedin(){

        if($this->session->userdata('loggedin')){
            return TRUE; 
        }

        if(!get_cookie('uid') && !get_cookie('remember_code')){
            return FALSE;
        } else{

            if(!is_numeric(get_cookie('uid')) || strlen(get_cookie('remember_code')) < 16){
                return FALSE;
            } else{

                $query = $this->db->where('userid', get_cookie('uid'))
                                ->where('remember_exp', get_cookie('remember_code'))
                                ->get(db_prefix().'users');                

                if ($query->num_rows() == 1) {
                    $row = $query->row();
                   // update last login
                    $this->update_last_login($row->userid,$row->eid);
                    $this->update_activity($row->userid);
                } 

                if (strtotime($row->remember_time) > strtotime("now")) {
                    $this->fast_login(get_cookie('uid'));
                    return TRUE;
                } 
                // if time is expired
                return FALSE;                   
            }
        }
        
        return FALSE;
    }

    // Fast login
    // Login with just a user id

    public function fast_login($user_id){

        $query = $this->db->where('userid', $user_id)
                        ->where('banned', 0)
                        ->get(db_prefix().'users');

        if ($query->num_rows() > 0) {
            $row = $query->row();
            // if id matches
            // create session
            $usersdata = [
                'uid' => $row->userid,
                'eid' => $row->eid,
                'branch' => $row->branch,
                'username' => $row->username,
                'email' => $row->email,
                'user_type' => $row->user_type,
                'loggedin' => TRUE
            ];

            $this->session->set_userdata($usersdata);
            return TRUE;
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

    // Login with lock Screen Password Session
    public function re_activate_sess($pass){
        $password = encrypt_password($pass);
       $query = $this->db->where('password',$password)
                        ->where('eid',$this->session->userdata('eid'))
                        ->where('userid',$this->session->userdata('uid'))
                        ->get(db_prefix().'users');

        if($query->num_rows() >0){
            $row = $query->row();
            $this->fast_login($row->userid);
            return TRUE;
        }

        return FALSE;
    }

    // User Emails with link to reset password

    public function is_remind_password($email){

        $query = $this->db->where('email', $email)->get(db_prefix().'users');

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $ver_code = get_token(30);

            $data['new_pass_key_requested'] = $ver_code;

            $this->db->where('email', $email)->update(db_prefix().'users', $data);

            $user_r = [
                'email' => $row->email, 
                'vcode' => $ver_code, 
                'username' => $row->username
            ];

            return  $user_r;
        }
        return FALSE;
    }


    public function password_reset() {
        # code...
    }

    public function check_user_type($check_group, $id = false) {

        $id || $id = $this->session->userdata('user_id');

        $types = $this->get_user_type($id);

        // return print_r($types);

        if($types['user_type'] === $check_group) {
            return TRUE;
        }

        return FALSE;
    }

    public function get_user_type($user_id = false) {
        $user_id || $user_id = $this->session->userdata('user_id');

        $user_type_id = $this->get_user_type_id($user_id);

        // return  $this->db->get_where(db_prefix().'user_types',['id'=>$user_type_id])->row();
        return $this->db->where('id',$user_type_id)->get(db_prefix().'user_types')->row_array();

    }

    // get Particular user by user type ID
    public function get_user_type_id($user_id = false) {
        $user_id || $user_id = $this->session->userdata('user_id');

        $type_id = $this->db->get_where(db_prefix().'users',['user_type',1])->row()->user_type;

        return $type_id;
    }

    // Register User
    public function create_user($firstname,$lastname,$email,$phone,$password,$timezone,$username=FALSE){
        
        if($this->user_exist_by_email($email)){
            set_alert('danger', '<strong>Failed:</strong> Email Address already Exist.');
            rdir('register');
        }

        if($this->user_exist_by_phone($phone)){
            set_alert('danger', '<strong>Failed:</strong> Phone Number already Exist.');
            rdir('register');
        }
        if(strlen($phone)>11 || strlen($phone)<11){
             set_alert('danger', '<strong>Failed:</strong> Invalid requirement phone number.');
            rdir('register');
        }

        // if($this->user_exist_by_username($username)){
        //     set_alert('danger', '<strong>Failed:</strong> Username already Exist.');
        //     rdir('register');
        // }

        $valid_email = (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$valid_email) {
            set_alert('danger', '<strong>Failed:</strong> Invalid Email Address.');
            rdir('register');
        }

        $split_mail = explode('@', $email);
		$username = $split_mail[0];        
        $data = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'phone_no' => $phone,
            'timezone' => $timezone,
            'image' => 'uploads/default/user.png',
            'last_ip' => ip_address(),
            'eid' => genGUID(),
            'username' => ucwords(strtolower($username)),
            'password' => encrypt_password($password),
            'user_type' => 2,
            'active' => 0,
            'creation_date' => set_date(),
        ];

        $query = $this->db->insert(db_prefix().'users', $data);
        if($query)
            return TRUE;
    }
    
    public function user_exist_by_phone($user_phone){
        $query = $this->db->where('phone_no', $user_phone)
                                ->get(db_prefix().'users');

        if ($query->num_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }

    public function user_exist_by_username($username){
        $query = $this->db->where('username', $username)
                                ->get(db_prefix().'users');

        if ($query->num_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }

    public function user_exist_by_email($user_email){
        $query = $this->db->where('email', $user_email)
                                ->get(db_prefix().'users');

        if ($query->num_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }


    // public function ($value=''){
        
    // }


}






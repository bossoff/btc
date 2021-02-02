<?php
/**
 * 
 */
         
class Alert
{
	
	public function show() {
	    $CI =& get_instance();
	    $CI->load->library('session');
	    $show = '';
	    if ($CI->session->flashdata('e_msg')) {
	        $er_msg = $CI->session->flashdata('e_msg');
	        $show .= '<div class="alert text-center alert-danger alert-dismissible">';
	        foreach ($er_msg as $e) {
	            $show .= ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
	            $show .= '<p>';
	            $show .= $e;
	            $show .= '</p>';
	        }
	        $show .= '</div>';

	    } elseif ($CI->session->flashdata('s_msg')) {
	        $sc_msg = $CI->session->flashdata('s_msg');
	        $show .= '<div class="alert text-center alert-success alert-dismissible">';
	        foreach ($sc_msg as $s) {
	            $show .= '<p>';
	            $show .= ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
	            $show .= $s;
	            $show .= '</p>';
	        }
	        $show .= '</div>';
	    }

	    echo $show;
	}

	public function set($response) {
	    $CI =& get_instance();
	    $CI->load->library('session');
	    $show = '';
	    if (strpos($response[0], 'successfully') > 0 || strpos($response[0], 'successful') > 0 || strpos($response[0], 'success') > 0) {
	        $msg = $CI->session->set_flashdata('s_msg',$response);
	    } else {
	        $msg = $CI->session->set_flashdata('e_msg',$response);
	    }
	}
}
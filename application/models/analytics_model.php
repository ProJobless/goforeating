<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analytics_model extends CI_Model
{
	function log_action()
	{
		$this->load->helper('url');
		$data = array(
			'user_id' => $user_id,
			'url'	  => uri_string(),
			'prev_url'=> $this->session->flashdata('requested_page'),
			'ctime'	  => time(),
			'ip'	  => $this->input->ip_address(),
			'ua'	  => $_SERVER['HTTP_USER_AGENT'],
			);
		$this->db->
	}
}
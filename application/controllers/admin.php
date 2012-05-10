<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$admin = array(1,3,4,5);
		if(!in_array($this->ion_auth->get_user()->id, $admin)) show_404();
	}
	
	function chungechunyemen()
	{
		
		$this->uni->save_one('admin_updates', array(
							'user_id'=> $this->ion_auth->get_user()->id,
							'value' => nl2br($this->input->post('update')),
							'ctime' => time(),
							));
		redirect($this->session->flashdata('requested_page'));
	}
	
	function index()
	{
		$data['title'] = 'Administration Panel';
		$data['content'] = 'admin/default';
		$data['js'] = 'admin/default_js';
		$this->load->view('main', $data);
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friend extends CI_Controller
{
	public $user;
	
	function __construct()
	{
		parent::__construct();
		if(!$this->ion_auth->logged_in())
		{
			redirect('welcome');
		}
		$this->user = $this->ion_auth->get_user();
		$this->load->model('friends_model');
		$this->uni->log_action();
	}
	
	function index()
	{
		$data['title'] = '朋友';
		$this->load->view('main', $data);	
	}
	
	function ajax_delete()
	{
		$uid = $this->input->post('uid');
		$fid = $this->input->post('fid');
		if($this->friends_model->delete_friend($uid, $fid))
		{
			echo 'success';
		}
		else
		{
			echo 'fail';
		}
		
	}
	
	function ajax_add()
	{
		$this->load->model('notifications_model');
		$uid = $this->input->post('uid');
		$fid = $this->input->post('fid');
		if($this->friends_model->add_friend($uid, $fid))
		{
			// add notification
			$this->notifications_model->add($fid, 5,$uid, NULL);
			echo 'success';
		}
		else
		{
			echo 'fail';
		}
		
	}
}
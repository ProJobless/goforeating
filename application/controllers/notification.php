<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Controller
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
		$this->uni->log_action();
	}
	
	function index()
	{
		$this->load->model('notifications_model');
		$data['unread_nums']= $this->notifications_model->get_count($this->user->id);
		$data['notifications'] = $this->notifications_model->get_unread($this->user->id);
		$data['content'] = 'notification/default';
		$data['title'] = '通知';
		$this->load->view('main', $data);
	}
}
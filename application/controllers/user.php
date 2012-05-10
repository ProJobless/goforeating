<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
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
		redirect('home');
	}
	
	function view($username)
	{
		$user = $this->ion_auth->get_user_by_username($username);
		if( ! $user)
		{
			show_404();
		}
		
		$this->load->helper('form');
		$this->load->model(array('deal_people_model', 'uni', 'deal_comments_model', 'deals_model', 'friends_model'));
		
		$data['join'] = $this->deal_people_model->get_user_joins($user->id);
		$data['interest'] = $this->deal_people_model->get_user_interests($user->id);
		
		$data['is_friend'] = $this->friends_model->is_friend($this->user->id, $user->id);
		$data['js'] = 'user/view_js';
		$data['title'] = $user->name;
		$data['content'] = 'user/view';
		$data['user'] = $user;
		$data['me'] = $this->user;
		$this->load->view('main', $data);
	}
}
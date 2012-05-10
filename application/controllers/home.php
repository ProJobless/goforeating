<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	public $user;
	
	function __construct()
	{
		parent::__construct();
		if(!$this->ion_auth->logged_in())
		{
			redirect('welcome');
		}
		//$this->output->enable_profiler(TRUE);
		$this->user = $this->ion_auth->get_user();
		$this->uni->log_action();
	}
	
	function index()
	{
		if(date('H') < 3)
		{
			$data['salut'] = '睡';
		}
		elseif (date('H') < 9)
		{
			$data['salut'] = '吃早饭';
		}
		elseif (date('H') < 14)
		{
			$data['salut'] = '吃午饭';
		}
		elseif (date('H') < 16)
		{
			$data['salut'] = '喝下午茶';
		}
		elseif (date('H') < 20)
		{
			$data['salut'] = '吃晚饭';
		}
		else
		{
			$data['salut'] = '吃夜宵';
		}
		$this->load->helper('form');
		$this->load->model(array('deal_tags_model', 'deal_people_model', 'deals_model', 'deal_comments_model', 'notifications_model'));
		$data['unread'] = $this->notifications_model->get_count($this->user->id);
		$data['created_nums'] = $this->deals_model->get_user_created_nums($this->user->id);
		$data['joined_nums'] = $this->deals_model->get_user_joined_nums($this->user->id);
		$data['interested_nums'] = $this->deals_model->get_user_interested_nums($this->user->id);
		$data['tags'] = $this->deal_tags_model->get_distinct_tags();
		
		$data['deals'] = $this->deals_model->get_user_deals($this->user->id);
		
		$data['user'] = $this->user;
		$data['js'] = 'home/default_js';
		$data['content'] = 'home/default';
		$this->load->view('main', $data);
	}
}
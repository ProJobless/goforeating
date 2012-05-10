<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->uni->log_action();
	}
	
	function index()
	{
		redirect('home');
	}
	
	function about()
	{
		$data = array(
		'title' => '关于我们',
		'content' => 'page/about',
		);
		
		$this->load->view('main', $data);
	}
	
	
	function feedback()
	{
		$this->load->helper('form');
		$this->load->model('uni');
		$this->load->library('form_validation');
		
		$data = array(
		'title' => '意见反馈',
		'content' => 'page/feedback',
		);
		
		$data['options'] = array(
            'A' => '建议/意见',
			'B' => 'BUG报告',
			'H' => '寻求帮助',
			'S' => '骚扰',
			'O' => '其它',
        );
		
		if($this->input->post('feedback-submit'))
		{
			if($this->input->post('user-type') == 'guest')
			{
				$feed_data['email'] = $this->input->post('email');
			}
			else
			{
				$feed_data['user_id'] = $this->input->post('user-type');
			}
			
			$feed_data['type'] = $this->input->post('type');
			$feed_data['value'] = nl2br($this->input->post('content'));
			$feed_data['ctime'] = time();
			
			if($this->uni->save_one('feedback', $feed_data))
			{
				$this->session->set_flashdata('user-info', 'Thanks!');
				redirect('page/feedback');
			}
		}
		else
		{
			$this->load->view('main', $data);
		}
	}
	
	function tos()
	{
		$data = array(
		'title' => '服务条款',
		'content' => 'page/tos',
		);
		
		$this->load->view('main', $data);
	}
	
	function help()
	{
		$this->load->helper('url');
		$data = array(
		'title' => '帮助信息',
		'content' => 'page/help',
		);
		
		$this->load->view('main', $data);
	}
	
	function updates()
	{
		$data = array(
			'title' => '更新记录',
			'content' => 'page/updates',
			'items' => $this->uni->get_many('admin_updates'),
		);
		
		$this->load->view('main', $data);
	}
}
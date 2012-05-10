<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	function index()
	{
		if($this->ion_auth->logged_in())
		{
		    redirect('home');
		}
		else
		{
		    $this->load->helper('form');
		    $data['content'] = 'welcome';
			$data['js'] = 'welcome_js';
		    $this->load->view('main', $data);
		}
		$this->uni->log_action();
	}
	
	function login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$remember = $this->input->post('remember');
		if($this->ion_auth->login($email, $password, $remember))
		{
		    $this->uni->log_user('logins');
		    $this->session->set_flashdata('user-info', '欢迎回来!');
			redirect('home', 'fresh');
		}
		else
		{
		    $this->session->set_flashdata('user-error', '错误的邮件或者密码!');
			redirect('/', 'refresh');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
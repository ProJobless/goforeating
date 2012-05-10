<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invite extends CI_Controller
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
        
        $this->load->model(array('register_code_model', 'register_code_static_model'));
        $this->uni->log_action();
    }
    
    public function index()
    {
        $this->load->helper('form');
        //$this->output->enable_profiler(TRUE);
        
        $code_num = $this->register_code_static_model->get_code_num($this->ion_auth->get_user()->id);
                
        $available_num = $this->register_code_model->get_available_num($this->ion_auth->get_user()->id);
        
        // if there is no records and the user do have right to invite people, generate codes
        if($available_num == 0 AND $code_num > 0)
        {
            $data['codes'] = $this->register_code_model->create_code($code_num, $this->ion_auth->get_user()->id);
        }
        
        // if codes are generated
        else if ($available_num > 0)
        {
            $temp = $this->register_code_model->get_user_code($this->ion_auth->get_user()->id);
            //trim data
            foreach($temp as $item)
            {
                $data['codes'][] = $item->value; 
            }
        }
        
        // not available to generate codes
        else
        {
            $data['codes'] = NULL;  
        }
        $data['code_num'] = count($data['codes']);
        $data['title'] = "邀请朋友";
        $data['content'] = 'invite/default';
        $this->load->view('main', $data);
    }
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tag extends CI_Controller
{
	public $user;
	
	function __construct()
	{
		parent::__construct();
		if($this->ion_auth->logged_in())
		{
			$this->user = $this->ion_auth->get_user();
		}
		else
		{
			redirect('welcome');
		}
		$this->uni->log_action();
	}
	
	
	function view($tag = '')
	{
		if($tag == '')
		{
			show_404();
		}
		$this->load->helper('form');
		$this->load->model(array('deal_tags_model', 'uni', 'deal_comments_model', 'deal_people_model', 'deals_model'));
		$deals = $this->deal_tags_model->get_deals_by_tag(urldecode($tag));
		
		$related_tags = array();
        if($deals)
        {
            foreach($deals as $deal)
            {
				$related_tags = array_merge($related_tags, $this->deal_tags_model->get_tags_by_deal_id($deal->deal_id));
            }
        }
		
		$data['related_tags'] = $related_tags;
		$data['tag_value'] = $tag;
		$data['user'] = $this->user;
		$data['deals'] = $deals;
		$data['content'] = 'tag/view';
		$data['title'] = '标签 ' . urldecode($tag);
		$this->load->view('main', $data);
	}
}
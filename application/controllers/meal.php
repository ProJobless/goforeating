<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Meal extends CI_Controller
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
	
	function add()
	{
		$this->load->library('form_validation');
		
		if($this->input->post('meal-submit'))
		{
			$this->form_validation->set_rules('location', '去哪吃', 'required|trim');
			$this->form_validation->set_rules('deadline', '截止日期', 'trim');
			$this->form_validation->set_rules('num_people', '人数', 'numeric');
			$this->form_validation->set_rules('avg_price', '人均', 'numeric');
			$this->form_validation->set_rules('addr', '地址', 'required|trim');
			$this->form_validation->set_rules('desc', '说明', 'max_length[1000]');
			
			// if everything goes well
			if($this->form_validation->run() == TRUE)
			{
				$location = $this->input->post('location');
				$deadline = strtotime($this->input->post('deadline'));
				$num_people = $this->input->post('num_people');
				$avg_price = $this->input->post('avg_price');
				$addr = $this->input->post('addr');
				$desc = nl2br($this->input->post('desc'));
				$deal_data = array(
					'user_id' => $this->user->id,
					'location' => $location,
					'min_people' => $num_people,	//@TODO: advance this function
					'max_people' => $num_people,
					'deadline' => $deadline,
					'avg_price' => $avg_price,
					'addr' => $addr,
					'desc' => $desc,
					'friends_only' => $this->input->post('auth'),
					'ctime' => time(),
					);
				// if inserted data
				if($this->uni->save_one('deals', $deal_data))
				{
					$deal_id = $this->db->insert_id();
					// assemble tags info
					$tags = explode(',', $this->input->post('tags'));
					// insert every tag
					foreach($tags as $tag)
					{
						if(trim($tag) != '')
						{
						$this->uni->save_one('deal_tags', array(
							'deal_id' => $deal_id,
							'user_id' => $this->user->id,
							'value' => trim($tag),
							'ctime' => time(),
							));
						}
					}
					$this->uni->log_user('creates');
					// set prompt information
					$this->session->set_flashdata('user-info', '恭喜,成功创建!');
					redirect('/meal/add');
				}
			}
			else
			{
				$this->session->set_flashdata('user-error', '出错了!!');
				$data['js'] = 'meal/add_js';
				$data['content'] = 'meal/add';
				$data['title'] = '开饭';
				$this->load->view('main', $data);
			}
		}
		else
		{
			$this->load->helper('form');
			$data['js'] = 'meal/add_js';
			$data['content'] = 'meal/add';
			$data['title'] = '开饭';
			$this->load->view('main', $data);
		}
	}
	
	function find()
	{
		$this->load->view('main');
	}
	
	function ajax_action()
	{
		$this->load->model(array('deal_people_model', 'deals_model', 'notifications_model'));
			if($this->input->post('post_field') == 'join')
			{
				if($this->deal_people_model->join($this->user->id, $this->input->post('deal_id')))
				{
					$deal_owner = $this->deals_model->get_deal_owner($this->input->post('deal_id'));
					// add notification
					$this->notifications_model->add($deal_owner, 1, $this->user->id, $this->input->post('deal_id'));
					$cur_people = $this->uni->get_one('deals',$this->input->post('deal_id'))->cur_people;
					$this->uni->log_user('joins');
					echo $cur_people;
				}
			}
			elseif ($this->input->post('post_field') == 'quit_join')
			//quit JOIN
			{
				if($this->deal_people_model->quit($this->user->id, $this->input->post('deal_id'), 'J'))
				{
					$cur_people = $this->uni->get_one('deals',$this->input->post('deal_id'))->cur_people;
					$this->uni->log_user('join_quits');
					echo $cur_people;
				}
			}
			// when INTEREST
			elseif($this->input->post('post_field') == 'interest')
			{
				if($this->deal_people_model->interest($this->user->id, $this->input->post('deal_id')))
				{
					$deal_owner = $this->deals_model->get_deal_owner($this->input->post('deal_id'));
					// add notification
					$this->notifications_model->add($deal_owner, 2, $this->user->id, $this->input->post('deal_id'));
					$cur_people = $this->uni->get_one('deals',$this->input->post('deal_id'))->cur_people;
					$this->uni->log_user('interests');
					echo $cur_people;
				}
			}
			elseif($this->input->post('post_field') == 'quit_interest')
			{
				if($this->deal_people_model->quit($this->user->id, $this->input->post('deal_id')))
				{
					$cur_people = $this->uni->get_one('deals',$this->input->post('deal_id'))->cur_people;
					$this->uni->log_user('interest_quits');
					echo $cur_people;
				}
			}
	}
	function action()
	{
		$this->load->model(array('deal_people_model', 'deals_model', 'notifications_model'));
		// when JOIN
		if($this->input->post('join'))
		{
			$this->session->keep_flashdata('requested_page');
			if($this->input->post('join') == '我要去')
			{
				if($this->deal_people_model->join($this->user->id, $this->input->post('deal_id')))
				{
					$deal_owner = $this->deals_model->get_deal_owner($this->input->post('deal_id'));
					// add notification
					$this->notifications_model->add($deal_owner, 1, $this->user->id, $this->input->post('deal_id'));
					$this->session->set_flashdata('user-info', '恭喜!成功加入');
				}
				$this->uni->log_user('joins');
				redirect($this->session->flashdata('requested_page'), 'refresh');
			}
			else
			//quit JOIN
			{
				if($this->deal_people_model->quit($this->user->id, $this->input->post('deal_id'), 'J'))
				{
					$this->session->set_flashdata('user-warn', '成功退出!');
				}
				$this->uni->log_user('join_quits');
				redirect($this->session->flashdata('requested_page'), 'refresh');
			}
		}
		// when INTEREST
		elseif ($this->input->post('interest'))
		{
			$this->session->keep_flashdata('requested_page');
			if($this->input->post('interest') == '感兴趣')
			{
				if($this->deal_people_model->interest($this->user->id, $this->input->post('deal_id')))
				{
					$deal_owner = $this->deals_model->get_deal_owner($this->input->post('deal_id'));
					// add notification
					$this->notifications_model->add($deal_owner, 2, $this->user->id, $this->input->post('deal_id'));
					$this->session->set_flashdata('user-info', '恭喜!标记为感兴趣!');
				}
				$this->uni->log_user('interests');
				redirect($this->session->flashdata('requested_page'), 'refresh');
			}
			else
			{
				if($this->deal_people_model->quit($this->user->id, $this->input->post('deal_id')))
				{
					$this->session->set_flashdata('user-warn', '成功退出!');
				}
				$this->uni->log_user('interest_quits');
				redirect($this->session->flashdata('requested_page'), 'refresh');
			}
		}
		else
		{
			show_404();
		}
	}
	
	function view($deal_id = 0)
	{
		$this->load->model(array('deals_model', 'deal_people_model', 'deal_comments_model', 'deal_tags_model', 'friends_model'));
		$this->load->helper('form');
		$deal = $this->uni->get_one('deals', $deal_id);
		$is_private = $this->deals_model->is_private($deal_id);
		$is_friend = $this->friends_model->is_friend($deal->user_id, $this->user->id);
		
		if(empty($deal_id) || empty($deal))
		{
			show_404();
		}
		
		if( $this->user->id != $deal->user_id AND $is_private AND !$is_friend)
		{
			show_404();
		}
		
		$this->load->library('table');
		$tmpl = array (
				'table_open'          => '<table border="0" cellpadding="4" cellspacing="0">',
				'heading_row_start'   => '<tr class="contact-heading">',
				'heading_row_end'     => '</tr>',
				'heading_cell_start'  => '<th>',
				'heading_cell_end'    => '</th>',
				
				'row_start'           => '<tr class="contact-row-odd">',
				'row_end'             => '</tr>',
				'cell_start'          => '<td>',
				'cell_end'            => '</td>',
				
				'row_alt_start'       => '<tr class="contact-row-even">',
				'row_alt_end'         => '</tr>',
				'cell_alt_start'      => '<td>',
				'cell_alt_end'        => '</td>',
				'table_close'         => '</table>'
              );
		$this->table->set_template($tmpl);
		
		$join_people = $this->deal_people_model->get_join_people($deal_id);
		
		//$this->table->set_heading('姓名', '电话');
		foreach($join_people as $item)
		{
			$user = $this->ion_auth->get_user($item->user_id);
			$this->table->add_row("<a href='/user/view/$user->username'>$user->name</a>", $user->phone);
		}
		$data['is_full'] = $this->deals_model->check_full($deal_id);
		$data['tags'] = $this->deal_tags_model->get_tags_by_deal_id($deal_id);
		$data['comments'] = $this->deal_comments_model->get_deal_comments($deal_id);
		$data['join'] = $this->deal_people_model->get_join_people($deal_id);
		$data['interest'] = $this->deal_people_model->get_interest_people($deal_id);
		$data['user'] = $this->user;
		$data['deal'] = $deal;
		$data['js'] = 'meal/view_js';
		$data['title'] = '一起去'.$deal->location.'吃饭吧';
		$data['content'] = 'meal/view';
		$this->load->view('main', $data);
	}
	
	function delete($deal_id = 0)
	{
		if($deal_id == 0)
		{
			show_404();
		}
		$this->load->model(array('uni'));
		$deal = $this->uni->get_one('deals', $deal_id);
		// check user auth
		if($deal->user_id != $this->user->id)
		{
			redirect('home', 'refresh');
		}
		if($this->uni->delete_one('deals', $deal_id))
		{
			$this->uni->log_user('create_deletes');
			redirect('home', 'refresh');
		}
	}
	
	function submit_comment()
	{
		$this->load->model(array('notifications_model', 'deal_comments_model'));
		$this->session->keep_flashdata('requested_page');
		$this->load->library('form_validation');
		if($this->input->post('comment-submit'))
		{
			if(trim($this->input->post('comment')) == '')
			{
				redirect($this->session->flashdata('requested_page'));
			}
			$user_id = $this->input->post('user_id');
			$deal_id = $this->input->post('deal_id');
			$value = nl2br($this->input->post('comment'));
			$data = array(
				'deal_id' => $deal_id,
				'user_id' => $user_id,
				'value' => $value,
				'ctime' => time()
				);
			if($this->uni->save_one('deal_comments', $data))
			{
				$deal_owner = $this->uni->get_one('deals', $deal_id)->user_id;
				// send notification to the deal owner
				if($deal_owner != $user_id)
				{
					$this->notifications_model->add($deal_owner, 3, $user_id, $deal_id);
				}
				
				$all_comments = $this->deal_comments_model->get_deal_comments($deal_id);
				
				// send notifications to all users who have commented on this deal
				// but avoid sending notifications to THIS user
				// I dont want to get a notification when I just posted a comment myself, right?
				$set[] = $deal_owner;
				$set[] = $user_id;
				
				foreach($all_comments as $item)
				{
					if(!in_array($item->user_id, $set))
					{
						$this->notifications_model->add($item->user_id, 4, $user_id, $deal_id);
						$set[] = $item->user_id;
					}
				}
				
				redirect($this->session->flashdata('requested_page'), 'refresh');
			}
			
		}
	}
	
	function edit($deal_id = 0)
	{
		$this->load->model(array('deals_model','deal_tags_model'));
		$deal = $this->uni->get_one('deals', $deal_id);
		$this->load->helper('form');
		
		// auth
		if($deal_id == 0 || $deal->user_id != $this->user->id)
		{
			show_404();
		}
		
		$tags = $this->deal_tags_model->get_tags_by_deal_id($deal_id);
		$data['tags'] = '';
		foreach($tags as $tag)
		{
			$data['tags'] .= $tag->value . ', ';
		}
		
		$data['title'] = '编辑';
		$data['content'] = 'meal/edit';
		$data['js'] = 'meal/edit_js';
		$data['user'] = $this->user;
		$data['deal'] = $deal;
		
		if($this->input->post('meal-submit'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('location', '去哪吃', 'required|trim');
			$this->form_validation->set_rules('deadline', '截止日期', 'trim');
			$this->form_validation->set_rules('num_people', '人数', 'numeric');
			$this->form_validation->set_rules('avg_price', '人均', 'numeric');
			$this->form_validation->set_rules('addr', '地址', 'required|trim');
			$this->form_validation->set_rules('desc', '说明', 'max_length[1000]');
			
			// if everything goes well
			if($this->form_validation->run() == TRUE)
			{
				$location = $this->input->post('location');
				$deadline = strtotime($this->input->post('deadline'));
				$num_people = $this->input->post('num_people');
				$avg_price = $this->input->post('avg_price');
				$addr = $this->input->post('addr');
				$desc = nl2br($this->input->post('desc'));
				$deal_data = array(
					'user_id' => $this->user->id,
					'location' => $location,
					'min_people' => $num_people,	//@TODO: advance this function
					'max_people' => $num_people,
					'deadline' => $deadline,
					'avg_price' => $avg_price,
					'addr' => $addr,
					'desc' => $desc,
					'friends_only' => $this->input->post('auth'),
					);
				// if inserted data
				if($this->uni->update_one('deals',  $deal_id, $deal_data))
				{
					// delete previous tags
					$this->load->model('deal_tags_model');
					$this->deal_tags_model->delete_tags_by_deal_id($deal_id);
					// assemble tags info
					$tags = explode(',', $this->input->post('tags'));
					// insert every tag
					foreach($tags as $tag)
					{
						if(trim($tag) != '')
						{
						$this->uni->save_one('deal_tags', array(
							'deal_id' => $deal_id,
							'user_id' => $this->user->id,
							'value' => trim($tag),
							'ctime' => time(),
							));
						}
					}
					// set prompt information
					$this->session->set_flashdata('user-info', '恭喜,修改成功!');
					redirect('meal/view/'. $deal_id);
				}
			}
			else
			{
				$this->load->view('main', $data);
			}
		}
		else
		{
			$this->load->view('main', $data);
		}
	}
}
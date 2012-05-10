<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends CI_Controller
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
	
	function index()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		if($this->input->post('setting-submit'))
		{
			$this->form_validation->set_rules('realname', '姓名', 'required');
			$this->form_validation->set_rules('phone', '手机', 'exact_length[11]|numeric');
			$this->form_validation->set_rules('bio', '自述', 'trim');
			
			if($this->form_validation->run() == TRUE)
			{
				$name = $this->input->post('realname');
				$phone = $this->input->post('phone');
				$bio = nl2br($this->input->post('bio'));
				
				// photo setting
                $config['upload_path'] = './assets/user_photos/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '500';
                $config['max_width']  = '1000';
                $config['max_height']  = '1000';
                $config['file_name'] = $this->user->id;
                $config['overwrite'] = TRUE;
                $this->load->library('upload', $config);
				
				$update_data = array(
					'name' => $name,
					'phone' => $phone,
					'bio' => $bio
				);
				
				// no photo selected
				if (empty($_FILES['userfile']['name']))
                {
                    if($this->ion_auth->update_user($this->user->id, $update_data))
                    {
                        $this->session->set_flashdata('user-info', 'You have upgrated your profile');
                        redirect('home');
                    }
                }
				
				//if anything to upload AND something wrong when uploading
				elseif ( !empty($_FILES['userfile']['name'])  AND !$this->upload->do_upload() )
                {
                    $data['upload_error'] = $this->upload->display_errors('<p class="required">', '</p>');
                    $this->session->set_flashdata('user-warn', 'Oops! Something wrong when uploading');
                    $data['user'] = $this->user;
                    $data['content'] = 'setting/default';
                    $data['title'] = '设置';
                    $this->load->view('main', $data);
                }
				//if anything is okay
				elseif ( !empty($_FILES['userfile']['name']) AND $this->upload->do_upload())
                {
                    $upload_data = $this->upload->data();
                    
					// first resize photo to 50x50 px
                    if($this->_photo_resize($upload_data['full_path'], $upload_data['image_width']))
                    {
						// then creae a 100x100 thumb
                        $update['photo'] = $upload_data['raw_name'] . '_thumb' . $upload_data['file_ext'];
                        
                        $img2['image_library'] = 'gd2';
                        $img2['source_image'] = $upload_data['full_path'];
                        $img2['maintain_ratio'] = TRUE;
                        if($upload_data['image_width'] > 100)
                        {
                            $img2['width'] = 100;
                            $img2['height'] = 100;
                        }
                        else
                        {
                            $img2['width'] = $upload_data['image_width'];
                            $img2['height'] = $upload_data['image_height'];
                        }
                        $img2['new_image'] = $upload_data['raw_name'] . '_100' . $upload_data['file_ext'] ;
                        $this->image_lib->initialize($img2);
                        $this->image_lib->resize();
						$update_data['photo'] = $upload_data['file_name'];
                    }
                    else
                    {
                        $update_data['photo'] = 'default_photo.gif';
                    }
                    
                    if($this->ion_auth->update_user($this->user->id, $update_data))
                    {
                        $this->session->set_flashdata('user-info', 'You have upgrated your profile');
                        redirect('home', 'refresh');
                    }
                }
				
			}
			else
			{
				$this->session->set_flashdata('user-error', 'Oops');
				$data['user'] = $this->user;
				$data['title'] = '设置';
				$data['content'] = 'setting/default';
				$this->load->view('main', $data);
			}
		}
		else
		{
			$data['user'] = $this->user;
			$data['title'] = '设置';
			$data['content'] = 'setting/default';
			$this->load->view('main', $data);
		}
	}
	
	
	// resize user's photo
    function _photo_resize($full_path, $width)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $full_path;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 50;
        $config['height'] = 50;
        
        $this->load->library('image_lib');
        $this->image_lib->initialize($config);
        
        if($this->image_lib->resize())
        {
            $this->image_lib->clear();
            return TRUE;
        }
        else
        {
            $this->image_lib->clear();
            return FALSE;
        }
    }
}
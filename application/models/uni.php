<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Universal CRUD model
 *
 * @author Sutar <sutarshow@gmail.com>
 *
 */


class Uni extends CI_Model
{
    
    function _photo_resize($full_path, $width, $height)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $full_path;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $width;
        $config['height'] = $height;
        
        $this->load->library('image_lib');
        $this->image_lib->initialize($config);
        
        return $this->image_lib->resize();
    }
    
    /**
     * Universal Save One Function
     * 
     * For the lord!
     *
     * @param $table
     * @param $data
     * @return mixed
     */
    public function save_one($table = '', $data = array())
    {
        if(empty($table) || empty($data))
        {
            return FALSE;
        }
        
        return $this->db->insert($table, $data) ?  $this->db->insert_id() : FALSE; 
    }
    
    function log_action()
	{
		$this->load->helper('url');
        
		$data = array(
			'user_id' => @$this->ion_auth->get_user()->id,
			'url'	  => uri_string(),
			'prev_url'=> $this->session->flashdata('requested_page'),
			'ctime'	  => time(),
			'ip'	  => $this->input->ip_address(),
			'ua'	  => $_SERVER['HTTP_USER_AGENT'],
			);
		return $this->db->insert('analytic_actions', $data);
	}
    
    function log_user($field)
    {
        $log = $this->db->where('user_id', $this->ion_auth->get_user()->id)->get('analytic_users')->row();
        
        if($log == NULL)
        {
            $this->db->insert('analytic_users', array('user_id'=>$this->ion_auth->get_user()->id));
            $log = $this->db->where('user_id', $this->ion_auth->get_user()->id)->get('analytic_users')->row();
        }
        
        $log->$field = $log->$field + 1;
        
        return $this->db->where('user_id', $log->user_id)->update('analytic_users', $log);
    }
    
    function log_user_invites($user_id)
    {
        $log = $this->db->where('user_id', $user_id)->get('analytic_users')->row();
        
        if($log == NULL)
        {
            $this->db->insert('analytic_users', array('user_id'=>$user_id));
            $log = $this->db->where('user_id', $this->ion_auth->get_user()->id)->get('analytic_users')->row();
        }
        
        $log->invites = $log->invites + 1;
        
        return $this->db->where('user_id', $log->user_id)->update('analytic_users', $log);
    }
    
    /**
     * Universal Get One Function
     *
     * @param $table
     * @param $id
     * @return object
     */
    public function get_one($table = '', $id = 0)
    {
        if($id == 0 OR $table == '')
        {
            return FALSE;
        }
        return $this->db->where('id', $id)->get($table)->num_rows() > 0 ? $this->db->where('id', $id)->get($table)->row() : FALSE;
    }
    
    /**
     * Universal Get One Function ( return as Array )
     *
     * @param $table
     * @param $id
     * @return array
     */
    public function get_one_array($table = '', $id = 0)
    {
        if($id == 0 OR $table == '')
        {
            return FALSE;
        }
        
        return $this->db->where('id', $id)->get($table)->num_rows() > 0 ? $this->db->where('id', $id)->get($table)->row_array() : FALSE;
    }
    
    /**
     * Universal Get Many Function
     *
     * @param $table
     * @param $user_id
     * @param $limits
     * @param $offset
     * @return array
     *
     */
    public function get_many($table = '', $limits = 20, $offset = 0)
    {
        if($table == '')
        {
            return FALSE;
        }
        $query = $this->db->order_by('ctime', 'desc')->limit($limits, $offset)->get($table);
        
        return $query->num_rows > 0 ? $query->result() : FALSE;
        
    }
    
    /**
     * Universal Get Many Function By user_id
     *
     * @param $table
     * @param $user_id
     * @param $limits
     * @param $offset
     * @return array
     *
     */
    public function get_user_many($table = '', $user_id = 0, $limits = 20, $offset = 0)
    {
        if($table == '' OR $user_id == 0)
        {
            return FALSE;
        }
        $query = $this->db->where('user_id',$user_id)->order_by('ctime', 'desc')->limit($limits, $offset)->get($table);
        
        return $query->num_rows > 0 ? $query->result() : FALSE; 
    }
    
    /**
     * Universal Delete One Function
     *
     * @param $table
     * @param $id
     * @return bool
     */
    public function delete_one($table = '', $id = 0)
    {
        if($table == '' OR $id == 0)
        {
            return FALSE;
        }
        
        return $this->db->delete($table, array('id' => $id));
    }
    
    /**
     * Universal Update Function
     *
     * @param $table
     * @param $id
     * @param $data
     * @return bool
     */
    public function update_one($table = '', $id = 0, $data = array())
    {
        if($table == '' OR $id == 0 OR empty($data))
        {
            return FALSE;
        }
        
        return $this->db->where('id', $id)->update($table, $data); 
    }
    
}
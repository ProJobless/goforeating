<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register_code_static_model extends CI_Model
{
    public function get_code_num($user_id)
    {
        $query = $this->db->where('user_id', $user_id)->get('register_code_static');
        
        if($query->num_rows() == 0)
        {
            return 0;
        }
        else
        {
            return $query->row()->code_num;
        }
    }
}
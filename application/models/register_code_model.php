<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register_code_model extends CI_Model
{
    public function create_code($num = 10, $user_id = '')
    {
        for($i = 0; $i < $num; $i++)
        {
            $value = strtoupper(substr(md5(microtime() . $user_id), rand(0, 6), 10));
            $this->db->insert('register_code', array('value'=>$value, 'ctime'=>time(), 'upper_id'=> $user_id));
            $result[] = $value;
        }
        
        return $result;
    }
    
    public function use_code($value, $username)
    {
        return $this->db->where('value', $value)->update('register_code', array('utime'=>time(),'username'=>$username));
    }
    
    public function get_available_num($user_id)
    {
        $query = $this->db->where('upper_id', $user_id)->get('register_code');
        
        if($query->num_rows() == 0)
        {
            return 0;
        }
        else
        {
            return $this->db->where('upper_id', $user_id)->where('utime', NULL)->get('register_code')->num_rows();    
        }
    }
    
    public function get_user_code($user_id)
    {
        $query = $this->db->select('value')->where('upper_id', $user_id)->where('utime',NULL)->get('register_code');
        
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return FALSE;
        }
    }
}
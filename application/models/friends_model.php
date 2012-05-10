<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friends_model extends CI_Model
{   
    public function add_friend($uid, $fid)
    {
        $data = array(
                'uid' => $uid,
                'fid' => $fid,
                'ctime'=> time(),
                );
        return $this->db->insert('friends', $data) ? $this->db->insert_id() : FALSE;
    }
    
    public function is_friend($uid, $fid)
    {
        return $this->db->where('uid', $uid)->where('fid', $fid)->where('active', '1')->get('friends')->num_rows();
    }
    
    public function delete_friend($uid, $fid)
    {
        return $this->db->delete('friends', array('uid' => $uid, 'fid' => $fid)); 
    }
    
    public function get_user_friends($user_id, $limit = 100, $offset = 0)
    {
        $query = $this->db->select('fid')->where('uid', $user_id)->where('active', '1')->limit($limit, $offset)->order_by('ctime', 'desc')->get('friends');
        
        return $query->num_rows() > 0 ? $query->result() : FALSE;
    }
    
    public function get_friends_reverse($fid)
    {
        $query = $this->db->select('uid')->where('fid', $fid)->where('active', '1')->order_by('ctime', 'desc')->get('friends');
        
        return $query->num_rows() > 0 ? $query->result() : FALSE;
    }
    
    public function get_friends_timeline($user_id, $limit = 20, $offset = 0)
    {
        $friends = $this->get_user_friends($user_id);
        if(!$friends)
        {
            return FALSE;
        }
        foreach($friends as $friend)
        {
            $list[] = $friend->fid;
        }
        $list[] = $user_id;
        $query = $this->db->where_in('user_id', $list)->order_by('ctime', 'desc')->limit($limit, $offset)->get('deals');
        
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
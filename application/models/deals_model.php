<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Deals_model extends CI_Model
{
	function check_full($deal_id)
	{
		$query = $this->db->select('cur_people, max_people')->where('id', $deal_id)->get('deals')->row();
		return $query->cur_people >= $query->max_people;
	}
	
	function is_private($deal_id)
	{
		return $this->db->where('id', $deal_id)->get('deals')->row()->friends_only;
	}
	
	function get_public_deals($limits = 20, $offset = 0)
	{
		$query = $this->db->where('friends_only', 0)->order_by('ctime', 'desc')->limit($limits, $offset)->get('deals');
        
        return $query->num_rows > 0 ? $query->result() : FALSE;
	}
	
	function get_private_deals($user_id, $limits = 20, $offset =0)
	{
		$this->load->model('friends_model');
		$friends = $this->friends_model->get_user_friends($user_id);
		foreach($friends as $friend)
		{
			$friends_id[] = (int)$friend->fid;
		}
		$this->db->where('friends_only', 1)->where_in('user_id', $friends_id)->order_by('ctime', 'desc')->limit($limits, $offset)->get('deals');
	}
	
	function get_user_deals($user_id, $limits = 20, $offset = 0)
	{
		// so ugly...
		$this->load->model('friends_model');
		$friends = $this->friends_model->get_friends_reverse($user_id);
		if($friends)
		{
			$users = "(" . $user_id . ",";
			foreach($friends as $friend)
			{
				$users .= $friend->uid . ','; 
			}
			//produce (1,2,5,61) format
			$users = preg_replace('/,$/', ')', $users);
			$sql = "SELECT * FROM `deals` WHERE `friends_only`=0 UNION SELECT * FROM `deals` WHERE `friends_only`=1 AND `user_id` IN $users ORDER BY `ctime` DESC LIMIT $offset, $limits";
			
			return $this->db->query($sql)->result();
		} else {
			$sql = "SELECT * FROM `deals` WHERE `friends_only`=0 UNION SELECT * FROM `deals` WHERE `friends_only`=1 AND `user_id`=$user_id ORDER BY `ctime` DESC LIMIT $offset, $limits";
			
			return $this->db->query($sql)->result();
		}
	}
	
	function get_deal_owner($deal_id)
	{
		return $this->db->select('user_id')->where('id', $deal_id)->get('deals')->row()->user_id;
	}
	
	function get_user_created_nums($user_id)
	{
		return $this->db->select('user_id')->where('user_id', $user_id)->get('deals')->num_rows();
	}
	
	function get_user_joined_nums($user_id)
	{
		return $this->db->select('user_id')->where('user_id', $user_id)->where('type', 'J')->get('deal_people')->num_rows();
	}
	
	function get_user_interested_nums($user_id)
	{
		return $this->db->select('user_id')->where('user_id', $user_id)->where('type', 'I')->get('deal_people')->num_rows();
	}
}
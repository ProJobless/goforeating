<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Deal_people_model extends CI_Model
{
	function join($user_id, $deal_id)
	{
		// check if the record exist
		$exist = $this->db->where('user_id', $user_id)->where('deal_id', $deal_id)->where('type', 'J')->get('deal_people')->num_rows();
		if($exist > 0)
		{
			return FALSE;
		}
		
		// check user has already marked as INTEREST ?
		$interest = $this->db->where('user_id', $user_id)->where('deal_id', $deal_id)->where('type', 'I')->get('deal_people')->num_rows();
		if($interest > 0)
		{
			return $this->db->where('user_id', $user_id)->where('deal_id', $deal_id)->update('deal_people', array('type' => 'J', 'ctime' => time())) && $this->db->set('cur_people', 'cur_people+1', FALSE)->where('id', $deal_id)->update('deals');
		}
		
		// insert new record
		$data = array(
			'deal_id' => $deal_id,
			'user_id' => $user_id,
			'type' => 'J',
			'ctime' => time(),
			);
		return $this->db->insert('deal_people', $data) && $this->db->set('cur_people', 'cur_people+1', FALSE)->where('id', $deal_id)->update('deals');
	}
	
	function interest($user_id, $deal_id)
	{
		// check if the record exist
		$exist = $this->db->where('user_id', $user_id)->where('deal_id', $deal_id)->where('type', 'I')->get('deal_people')->num_rows();
		if($exist > 0)
		{
			return FALSE;
		}
		
		// check user has already marked as JOIN ?
		$join = $this->db->where('user_id', $user_id)->where('deal_id', $deal_id)->where('type', 'J')->get('deal_people')->num_rows();
		if($join > 0)
		{
			return $this->db->where('user_id', $user_id)->where('deal_id', $deal_id)->update('deal_people', array('type' => 'I', 'ctime' => time())) && $this->db->set('cur_people', 'cur_people-1', FALSE)->where('id', $deal_id)->update('deals');
		}
		
		// insert new record
		$data = array(
			'deal_id' => $deal_id,
			'user_id' => $user_id,
			'type' => 'I',
			'ctime' => time(),
			);
		return $this->db->insert('deal_people', $data) && $this->db->set('cur_people', 'cur_people-1', FALSE)->where('id', $deal_id)->update('deals');
	}
	
	function check_state($user_id, $deal_id)
	{
		$query = $this->db->where('user_id', $user_id)->where('deal_id', $deal_id)->get('deal_people');
		if($query->num_rows() == 0)
		{
			return FALSE;
		}
		
		return $query->row()->type == 'J' ? 'J' : 'I';
	}
	
	function quit($user_id, $deal_id, $type = 'I')
	{
		if($type == 'J')
		{
			$this->db->set('cur_people', 'cur_people-1', FALSE)->where('id', $deal_id)->update('deals');
		}
		return $this->db->where('user_id', $user_id)->where('deal_id', $deal_id)->delete('deal_people');
	}
	
	function get_join_people($deal_id)
	{
		return $this->db->where('deal_id', $deal_id)->where('type', 'J')->order_by('ctime', 'desc')->get('deal_people')->result();
	}
	
	function get_interest_people($deal_id)
	{
		return $this->db->where('deal_id', $deal_id)->where('type', 'I')->order_by('ctime', 'desc')->get('deal_people')->result();
	}
	
	function get_user_joins($user_id)
	{
		return $this->db->where('user_id', $user_id)->where('type', 'J')->order_by('ctime', 'desc')->get('deal_people')->result();
	}
	
	function get_user_interests($user_id)
	{
		return $this->db->where('user_id', $user_id)->where('type', 'I')->order_by('ctime', 'desc')->get('deal_people')->result();
	}
}
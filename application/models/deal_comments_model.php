<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Deal_comments_model extends CI_Model
{
	function get_deal_comments($deal_id)
	{
		return $this->db->where('deal_id', $deal_id)->order_by('ctime', 'asc')->get('deal_comments')->result();
	}
	
	function get_deal_comments_count($deal_id)
	{
		return $this->db->where('deal_id', $deal_id)->get('deal_comments')->num_rows();
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Deal_tags_model extends CI_Model
{
	function get_distinct_tags()
	{
		$this->db->distinct();
		return $this->db->select('value')->order_by('ctime', 'desc')->get('deal_tags')->result();
	}
	
	function get_deals_by_tag($tag)
	{
		return $this->db->where('value', $tag)->order_by('ctime', 'desc')->get('deal_tags')->result();
	}
	
	function get_tags_by_deal_id($deal_id)
	{
		return $this->db->where('deal_id', $deal_id)->order_by('ctime', 'desc')->get('deal_tags')->result();
	}
	
	function delete_tags_by_deal_id($deal_id)
	{
		return $this->db->where('deal_id', $deal_id)->delete('deal_tags');
	}
}
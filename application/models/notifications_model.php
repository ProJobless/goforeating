<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifications_model extends CI_Model
{
	/**
     * Category List
     * 1 : $item1 joined your "go to $item2"
     * 2 : $item1 interested your "go to $item2"
     * 3 : $item1 commented on your deal $item2
     * 4 : ditto
     * 5 : $item1 added you as friend
     * 6 :
     * 7 : $item1 has reached its goal
     *
     */
	
	public function add($user_id, $cat, $item1, $item2)
	{
		$data = array(
            'user_id' => $user_id,
            'cat'     => $cat,
            'item1'   => $item1,
            'item2'   => $item2,
			'ctime'   => time(),
            );
        return $this->db->insert('notifications', $data);
	}
	
	public function translate($notification)
	{
		$this->load->model('uni');
		
		if($notification->cat == 1)
		{
			$user = $this->ion_auth->get_user($notification->item1);
			$deal = $this->uni->get_one('deals', $notification->item2);
			$result = "<a href='/user/view/{$user->username}'>{$user->name}</a>参加了你创建的<a href='/meal/view/{$deal->id}'>去{$deal->location}吃好吃的</a>.";
			return $result;
		}
		elseif ($notification->cat == 2)
		{
			$user = $this->ion_auth->get_user($notification->item1);
			$deal = $this->uni->get_one('deals', $notification->item2);
			$result = "<a href='/user/view/{$user->username}'>{$user->name}</a>对你创建的<a href='/meal/view/{$deal->id}'>去{$deal->location}吃好吃的</a>感兴趣.";
			return $result;
		}
		elseif ($notification->cat == 3)
		{
			$user = $this->ion_auth->get_user($notification->item1);
			$deal = $this->uni->get_one('deals', $notification->item2);
			$result = "<a href='/user/view/{$user->username}'>{$user->name}</a>在你创建的<a href='/meal/view/{$deal->id}'>去{$deal->location}吃好吃的</a>上发言了.";
			return $result;
		}
		elseif ($notification->cat == 4)
		{
			$user = $this->ion_auth->get_user($notification->item1);
			$deal = $this->uni->get_one('deals', $notification->item2);
			$result = "<a href='/user/view/{$user->username}'>{$user->name}</a>在你发言过的<a href='/meal/view/{$deal->id}'>去{$deal->location}吃好吃的</a>上发言了.";
			return $result;
		}
		elseif ($notification->cat == 5)
		{
			$friend = $this->ion_auth->get_user($notification->item1);
			$result = "<a href='/user/view/{$friend->username}'>{$friend->name}</a>加你为好友了!";
			return $result;
		}
		elseif ($notification->cat == 6)
		{
			$friend = $this->ion_auth->get_user($notification->item1);
			$result = "<a href='/user/view/{$friend->username}'>{$friend->name}</a>解除了!";
			return $result;
		}
		elseif ($notification->cat == 7)
		{
			$deal = $this->uni->get_one('deals', $notification->item1);
			$result = "聚餐<a href='/meal/view/{$deal->id}'>去{$deal->location}吃好吃的</a>人数达成!";
			return $result;
		}
	}
	
	public function get_unread($user_id)
    {
        return $this->db->where('user_id', $user_id)->where('read', 0)->get('notifications')->result();
    }
	
	public function mark_read($id)
    {
        return $this->db->where('id', $id)->update('notifications', array('read' => 1));
    }
    
    public function get_count($user_id)
    {
        return $this->db->where('user_id', $user_id)->where('read', 0)->get('notifications')->num_rows();
    }
}
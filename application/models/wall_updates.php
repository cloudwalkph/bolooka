<?php
//Srinivas Tamada http://9lessons.info
//Wall_Updates

	class Wall_Updates extends CI_Model {

		function __construct()
		{
			$this->load->database();
		}
		
		function post_share($msg_id = 0, $uid_fk = 0, $page_id = 0, $limit = 0, $lastId = 0, $offset = 0 ) {
			if($msg_id != 0) {
				$this->db->where('msg_id', $msg_id);
			}
			if($lastId != 0) {
				$this->db->where('msg_id <', $lastId);
			}
			if($uid_fk != 0) {
				$this->db->where('uid_fk', $uid_fk);
			}
			if($page_id != 0) {
				$this->db->where('page_id', $page_id);
			}
			if($limit != 0) {
				if($offset != 0) {
					$this->db->limit($limit, $offset);
				} else {
					$this->db->limit($limit);
				}
			}
			$this->db->where('deleted', 0);
			$this->db->order_by('msg_id', 'desc');
					
			/* get this query */
			if ($this->db->table_exists('blog')) {
				$data = $this->db->get('blog');
			} else {
				$data = $this->db->get('messages');
			}
			return $data;
		}
		
		function select_album_blog($wid = 0, $albumid = 0) {
			$this->db->where('uid_fk', $wid);
			$this->db->where('album_id', $albumid);

			if ($this->db->table_exists('blog')) {
				$data = $this->db->get('blog');
			} else {
				$data = $this->db->get('messages');
			}
			// return $this->db->last_query();
			return $data;
		}
		
		function wall_blog($blog_uid = 0, $last_id = 0) {
			$this->db
				->select('*')
				->limit(12);
			if($last_id != 0) {
				$this->db->where('msg_id <', $last_id);
			}
			if ($this->db->table_exists('blog')) {
				$this->db->join('follow', 'follow.website_id = blog.uid_fk');
				$this->db->where('follow.users', $blog_uid);
				$this->db->where('blog.deleted', 0);
				$this->db->order_by('blog.created desc, msg_id desc');
				$data = $this->db->get('blog');
			} else {
				$this->db->join('follow', 'follow.website_id = messages.uid_fk');
				$this->db->where('follow.users', $blog_uid);
				$this->db->where('messages.deleted', 0);
				$this->db->order_by('messages.created desc');
				$data = $this->db->get('messages');
			}
			return $data;
		}
		
		function select_blog($id = 0, $albumid = 0, $limit = 0) {
			if($id != 0) {
				$this->db->where('message', $id);
			}
			if($albumid != 0) {
				$this->db->where('album_id', $albumid);
			}
			if($limit != 0) {
				$this->db->limit($limit);
			}
			$this->db->order_by('msg_id desc');
			if ($this->db->table_exists('blog')) {
				$query = $this->db->get('blog');
			} else {
				$query = $this->db->get('messages');
			}
			// return $this->db->last_query();
			return $query;
		}

		function insert_blog($uid_fk = 0, $page_id = 0, $album_id = 0, $message = null, $blog_title = null, $image_name = null) {
			$insert_data = array(
				'uid_fk' => $uid_fk,
				'page_id' => $page_id,
				'album_id' => $album_id,
				'message' => $message,
				'blog_title' => $blog_title,
				'image_name' => $image_name,
				'created' => time()
			);
			if ($this->db->table_exists('blog')) {
				$this->db->insert('blog', $insert_data);
			} else {
				$this->db->insert('messages', $insert_data);
			}
			
			return $this->db->insert_id();
		}
		
		function insert_product($album_id=0, $prod_id=0, $wid=0, $pid=0) {
			$insert_data = array(
				'uid_fk' => $wid,
				'page_id' => $pid,
				'album_id' => $album_id,
				'message' => $prod_id,
				'created' => time()
			);
			if ($this->db->table_exists('blog')) {
				$this->db->insert('blog', $insert_data);
			} else {
				$this->db->insert('messages', $insert_data);
			}
			
			return $this->db->insert_id();
		}

		function update_blog($msg_id = 0, $message = null) {
			$update_data = array(
				'message' => $message
			);
			$this->db->where('msg_id', $msg_id);

			if ($this->db->table_exists('blog')) {
				$this->db->update('blog', $update_data);
			} else {
				$this->db->update('messages', $update_data);
			}
			// return $this->db->last_query();			
		}

		function delete_blog($id = 0, $album_id = 0, $msg_id = 0) {
			$update_data = array(
				'deleted' => time()
			);

			if($msg_id != 0) {
				$this->db->where('msg_id', $msg_id);
			}
			if($id != 0) {
				$this->db->where('message', $id);
			}
			if($album_id != 0) {
				$this->db->where('album_id', $album_id);
			}

			if ($this->db->table_exists('blog')) {
				$this->db->update('blog', $update_data);
			} else {
				$this->db->update('messages', $update_data);
			}
			// return $this->db->last_query();
		}

		// Updates   	
		public function Updates($pid)
		{
			$this->db->where('uid_fk', $pid);
			$this->db->order_by('msg_id desc');
			if ($this->db->table_exists('blog')) {
				$data = $this->db->get('blog');
			} else {
				$data = $this->db->get('messages');
			}
			return $query->result_array();
		}
		//Comments
		public function Comments($msg_id)
		{
			$this->db->where('msg_id_fk', $msg_id);
			$this->db->order_by('com_id');
			$query = $this->db->get('comments');
			return $query->result_array();
		}
		
		//Avatar Image
		public function Gravatar($uid)
		{
			$query = mysql_query("SELECT email FROM `users` WHERE uid='$uid'") or die(mysql_error());
			$row = mysql_fetch_array($query);
			if(!empty($row))
			{
				$email=$row['email'];
				$lowercase = strtolower($email);
				$imagecode = md5( $lowercase );
				$data="http://www.gravatar.com/avatar.php?gravatar_id=$imagecode";
				return $data;
			}
			else
			{
				$data="";
				return $data;
			}
		}
		
		//Insert Update
		public function Insert_Update($uid, $update, $title_post, $img, $title, $url, $desc, $imageUrl, $imageName, $pid) 
		{
			$time = time();
			$ip = $_SERVER['REMOTE_ADDR'];
			
			// $query = $this->db->query("SELECT `msg_id`, `uid_fk`, `message`, `created` FROM `messages` WHERE `uid_fk`='$uid' ORDER BY `msg_id` DESC LIMIT 1");
			// $result = $query->row_array();
			
			// if($update != $result['message'])
			// {
			$insert_data = array(
				'message' => $update,
				'blog_title' => $title_post,
				'uid_fk' => $uid,
				'ip' => $ip,
				'created' => $time,
				'image' => $img,
				'title' => $title,
				'url' => $url,
				'description' => $desc,
				'imageUrl' => $imageUrl,
				'image_name' => $imageName,
				'page_id' => $pid
			);
			if ($this->db->table_exists('blog')) {
				$this->db->insert('blog', $insert_data);
			} else {
				$this->db->insert('messages', $insert_data);
			}
			$thisid = $this->db->insert_id();
			return $thisid;

		}
		
		//Insert Comments
		public function Insert_Comment($msg_id, $comment) 
		{
			$comment = htmlentities($comment);
			$time = time();
			$ip = $_SERVER['REMOTE_ADDR'];
			
				$query = $this->db->query("INSERT INTO `comments` (`comment`, `msg_id_fk`, `ip`, `created`) VALUES ('$comment', '$msg_id', '$ip', '$time')");
				$newquery = $this->db->query("SELECT `com_id`, `uid_fk`, `comment`, `msg_id_fk`, `created` FROM comments C where `msg_id_fk`='$msg_id' order by `com_id` desc limit 1 ");
				return $newquery->result_array();
		}
		
		//Delete Comments
			public function Delete_Comment($uid, $com_id) 
		{
			$query = mysql_query("DELETE FROM `comments` WHERE uid_fk='$uid' and com_id='$com_id'") or die(mysql_error());
			return true;
				   
		}
		
		public function insert_comment_content($cdata)
		{
			$com_id = $cdata['com_id'];
			$comment = tolink(htmlentities($cdata['comment'] ));
			$time = $cdata['created'];
			$username = $cdata['first_name'];
			$uid = $cdata['uid_fk'];
			$cface = $this->Wall_Updates->Gravatar($uid);

			echo '
			<div class="stcommentbody" id="stcommentbody'.$com_id.'">
				<div class="stcommentimg">
					<img src="'.$cface.'" class="small_face" />
				</div> 
				<div class="stcommenttext">
					<a class="stcommentdelete" href="#" id='.$com_id.'>X</a>
					<b>'.$username.'</b> '.$comment.'
					<div class="stcommenttime">'.time_stamp($time).'</div> 
				</div>
			</div>
			';
		}
		
		
		
		 public function insert_one($table,$data)
	   {
			$this->db->insert($table,$data);
				
	   }
		public function insert_two($table,$data)
	   {
			$this->db->insert($table,$data);
				
	   }
	   
	   public function select_only($table)
	   
	   {
			return $this->db
				   ->get($table)
				   ->result();
				
				 
	   }
	   
	   public function select_where($table,$data)
	   
	   {
		   return $this->db
				   ->where($data)
				   ->get($table);   
				   
	   }
	   
	   

	   public function delete_one($table,$where)
	   {
		  return $this->db
			 ->where($where)
			 ->delete($table); 
		

		}

		
		public function update($table,$where,$update)
		
		{
		   return $this->db
			 ->where($where)
			 ->update($table,$update);
			 
		  
		}
		
		public function update_all($table,$update)
		
		{
		   return $this->db
			 
			 ->update($table,$update);
			 
		  
		}
	}

?>

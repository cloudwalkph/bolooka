<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wall extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->model('wall_updates');
		$this->load->library('session');
		$this->load->model('video_model');
	}

	public function index()
	{
		$this->load->view('wall/blog');
	}
	function message_ajax()
	{
		$this->load->view('wall/message_ajax');
	}
	function delete_message_ajax()
	{
		$msg_id = $this->input->post('msg_id');
		$this->wall_updates->delete_blog($msg_id);

		$this->db->query("DELETE FROM `comments` WHERE msg_id_fk = '$msg_id' ");
	}
	function comment_ajax()
	{
		$this->load->view('wall/comment_ajax');	
	}
	function delete_comment_ajax()
	{
		$this->load->view('wall/delete_comment_ajax');	
	}
	
// new facebook wall 
	
	function get_content() {

		$this->load->view('blog/get_content');
	}

	function insert() {
		// write your code here to process the message received via ajax to save it to your database 
		//i leave this part up to you to implement . do leave a comment in case you're stuck 
		$update = htmlentities($this->input->post('wall'), ENT_QUOTES, 'UTF-8');
		$title_post = htmlentities($this->input->post('title_post'), ENT_QUOTES, 'UTF-8');
		$uid = $this->input->post('wid');
		$pid = $this->input->post('pid');
		$img = htmlentities($this->input->post('image'), ENT_QUOTES);
		$title = htmlentities($this->input->post('title'), ENT_QUOTES, 'UTF-8');
		$url = htmlentities($this->input->post('url'), ENT_QUOTES);

		$desc = htmlentities($this->input->post('desc'), ENT_QUOTES, 'UTF-8');
		$imageUrl = htmlentities($this->input->post('imageUrl'), ENT_QUOTES);   
		$imageName = $this->input->post('imageName');
		
		$thisid = $this->wall_updates->Insert_Update($uid, $update, $title_post, $img, $title, $url, $desc, $imageUrl, $imageName, $pid); 
		echo $thisid;
	}
	
	function upwallimage($name=null) {
		$this->load->model('Photo_Model');
		
		$wid = $this->input->post('website_id');
		$pid = $this->input->post('page_id');
		$message = $this->input->post('text_post');
		$title_post = $this->input->post('blog_title');
		$data['image'] = null;
		
		$wallimage = $this->Photo_Model->upload('uploadFile');

		if(is_array($wallimage)) {
			$thumbnail = $this->Photo_Model->make_thumbnail($wallimage['full_path']);
			$medium = $this->Photo_Model->make_medium($wallimage['full_path']);
			$data['image'] = $wallimage['file_name'];
		}
		
		$data['message_id'] = $this->wall_updates->insert_blog($wid, $pid, 0, $message, $title_post, $data['image']);
		$return_data = json_encode($data);
		echo $return_data;
	}

	function edit_content_post(){
		$id = $this->input->post('message_id');
		
		$queryBlog = $this->wall_updates->post_share($id);
		$row = $queryBlog->row_array();
		
		echo $row['message'];
	}
	function save_edited_content_post(){
		$id = $this->input->post('message_id');
		$message = $this->input->post('message');

		$this->wall_updates->update_blog($id, $message);

		echo str_replace("\n", '</p></p>', html_entity_decode($message));
	}
	function pagination() {
		$pid = $this->input->post('pid');
		$wid = $this->input->post('wid');
		$page_num = $this->input->post('p_num');
		
		$perpage = 6;
		$startingpoint = ($page_num * $perpage) - $perpage;

		$query = $this->wall_updates->post_share(0, $wid, $pid, 6, 0, $startingpoint);
		
		foreach ($query->result() as $row)
		{
			$created = $row->created;
			$album_id = $row->album_id;
			$msg_id = $row->msg_id;
			$uid_fk = $row->uid_fk;
			$message = $row->message;
			$description = $row->description;
			$image_name = $row->image_name;
			$images = $row->image;
			$imageUrl = $row->imageUrl;
			$titles = $row->title;
			$url_web = $row->url;
			$detect = $this->video_model->detect_url($url_web);
			
			$this->db->where('msg_id_fk',$msg_id);
			$this->db->where('uid_fk',$this->session->userdata('uid'));
			$comment_query = $this->db->get('comments');
			
			$message = str_replace("\n",'</p></p>',html_entity_decode($message));
			echo '
				<div class="well list_li_blog" id="'.$msg_id.'">
					<a class="remove_post">
						<img class="close_img" src="'.base_url('img/close_button.png').'">
					</a>
					<div class="edit_content_paste">
					<p>'.$message.'</p>
					</div>
			';
			
		if($imageUrl != ' ' || $imageUrl == 'undefined' || $image_name != '')
		{
			echo '
				<div class="pull-left media_float" style="margin-right:10px;position:relative;">
			';
			if($detect != 'no video')
			{
				echo '
					<span class="play_button" style="cursor:pointer;bottom: 2px;left:2px;position: absolute;background-color: rgba(255, 255, 255, 0.5);padding: 0 10px;">
						<i class="icon-play"></i>
					</span>
				';
			}
			
			if($imageUrl == 'undefined' || $image_name != '') {
				echo '<img style="width:67%;" src="'.base_url("uploads/".str_replace(" ","_",$image_name)).'">';
			} else {
				$images = strip_tags(html_entity_decode($images, ENT_QUOTES), '<img>');
				echo $images;
			}
			echo '
				</div>
			';
		}
			
			echo '
				<div style="overflow:hidden; margin-right: 10px; padding-left: 5px;">
			';
			if(($url_web != ' '))
			{
				echo '
					<p style="color:#08C;margin:0;"><a href="'.$url_web.'">'.html_entity_decode($titles).'</a></p> 
					<p class="video_url_link" alt="'.$url_web.'"></p>
					<p>'.html_entity_decode($description).'</p>
				';
			}
			echo '
				</div>
			';
			
			echo '
				<div style="clear:both;"></div>
				<br/>
				<div class="comment_content">
					<p style="border-bottom:1px solid #ddd;padding-bottom: 10px;">
						<strong class="comment_button">'.$comment_query->num_rows().' COMMENT(S) </strong>
					</p>
			';
			
			echo '
					<ul class="media-list" style="display:none;">
			';
			
			
			if($comment_query->num_rows() > 0)
			{
				foreach($comment_query->result() as $comRow)
				{
					$com_id = $comRow->com_id;
					$comment = $comRow->comment;
					$msg_id_fk = $comRow->msg_id_fk;
					$uid_fk = $comRow->uid_fk;
					$created = $comRow->created;
				echo '
					<li class="media">
						<a class="pull-left" href="#">
							<img class="media-object" src="'.base_url('img/no-photo.jpg').'" style="width: 65px;">
						</a>
						<div class="media-body">
							<p>'.$comment.'</p>
							<p style="text-align: right;"><small>'.date('F j, Y',$created).'</small></p>
						</div>
					</li>
				';
				}
			}
			echo '
					</ul>
				</div>
			';
			
			echo '
				</div>
			';
			
		}
	}
}

/* End of file blog.php */
/* Location: ./application/controllers/blog.php */
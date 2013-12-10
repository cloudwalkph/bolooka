<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Store extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->database();
		$this->load->model('facebook_model');
	}

	function index()
	{
		if($this->session->userdata('logged_in')) {
			$uid = $this->session->userdata('uid');
			$button = $this->input->post('create');
			if($button == 'save')
			{
				$web['site_name'] = $this->input->post('site_name');
				$web['url'] = url_title($web['site_name'], '-', true);
				
				if($this->input->post('com_name') != '') {
					$web['com_name'] = $this->input->post('com_name');
				} else {
					$web['com_name'] = $this->input->post('site_name');
				}
				
				/* new upload process ni noel */
				$logo_data['image'] = null;
				$logo_data['nologo'] = '0';
				$design_data['image'] = null;
				$design_data['nobg'] = '0';
				
				$this->load->model('photo_model');
				
					if(isset($_FILES['upload_logo'])) {
						$uploadedlogo = $this->photo_model->upload('upload_logo');
						$thumbnail = $this->photo_model->make_thumbnail($uploadedlogo['full_path']);
						$medium = $this->photo_model->make_medium($uploadedlogo['full_path']);
						if($uploadedlogo['file_name']) {
							$logo_data['image'] = $uploadedlogo['file_name'];
						} else {
							$logo_data['nologo'] = '1';
						}
					}
					if(isset($_FILES['upload_bg'])) {
						$uploadedbg = $this->photo_model->upload('upload_bg');
						$thumbnail = $this->photo_model->make_thumbnail($uploadedbg['full_path']);
						$medium = $this->photo_model->make_medium($uploadedbg['full_path']);
						if($uploadedbg['file_name']) {
							$design_data['image'] = 'uploads/'.$uploadedbg['file_name'];
						}
					} else {
						if($this->input->post('def_bg')) {
							$design_data['image'] = 'img/newBackgrounds/'.$this->input->post('def_bg');
						} else {
							$design_data['nobg'] = '1';
						}				
					}

				/* */

				$query = $this->db->query("select `id` from `websites` where `url` like '".$web['url']."'");
				
				if($query->num_rows == 0)
				{
					/* insert data to websites table */
					$new_website_insert_data = array(
						'user_id' => $this->session->userdata['uid'],
						'site_name' => $web['com_name'],
						'url' => $web['url'] ,
						'business_type' => $this->input->post('business_type'),
						'date_created' => time()
					);
					
					$insert = $this->db->insert('websites', $new_website_insert_data);

					/* get id from website table and save to session */
					$web_id = $this->db->insert_id('id');

					if($web_id) {

						/* insert to marketgroup */
						$marketgroup = $this->input->post('marketgroup');
						if($marketgroup != 0)
						{
							$data_insert_web_marketgroup = array(
							   'web_id' => $web_id ,
							   'marketgroup_id' => $marketgroup,
							   'status' => '0',
							   'date_added' => time()
							);
							$this->db->insert('web_marketgroup', $data_insert_web_marketgroup);

							/* get user to notify */
							$queryUser = $this->db->query("SELECT * FROM user_marketgroup WHERE marketgroup_id = ".$marketgroup." ");
							$userRow = $queryUser->row_array();
							if($queryUser->num_rows() > 0)
							{
								/* for notification */
								$data_insert_flag = array(
									'uid' => $this->session->userdata('uid'),
									'website_id' => $web_id,
									'status' => 1,
									'notify' => $userRow['user_id'],
									'action' => 'request',
									'time' => time()
								);
								$this->db->insert('flag', $data_insert_flag);
							}
						}
						
						$update_web = array(
							'marketgroup' => $marketgroup
						);
						$this->db->where('id', $web_id);
						$this->db->update('websites', $update_web);

						$newdata = array(
						   'website_id' => $web_id
						);
						$this->session->set_userdata($newdata);
						
						/* start insert into follow table*/
						$webId = $this->session->userdata('website_id');
						$uid = $this->session->userdata('uid');
						$insertFollow = mysql_query("INSERT INTO follow (users, website_id) VALUES('$uid','$webId')");
						/* end insert into follow table*/

						/* insert data to logo table */
						$new_logo_insert_data = array(
							'website_id' => $web_id,
							'image' => $logo_data['image'],
							'position' => 'left',
							'color' => '#777',
							'nologo' => $logo_data['nologo']
						);
						$insert = $this->db->insert('logo', $new_logo_insert_data);
						
						/* insert data to background table */
						$new_bg_insert_data = array(
							'website_id' => $web_id,
							'image' => $design_data['image'],
							'bgcolor' => '#999',
							'boxcolor' => 'rgba(0,0,0,0.5)',
							'transparency' => '50',
							'font_color' => '#FFF',
							'font_style' => 'Segoe UI',
							'font_size' => '16',
							'menu_bgcolor' => 'rgba(0,0,0,0.5)',
							'menu_color' => '#FFF',
							'menu_over' => '#4b4b4b',
							'menu_active' => '#000',
							'nobg' => $design_data['nobg']
						);
						$insert = $this->db->insert('design', $new_bg_insert_data);
					
						$social = $this->input->post('social');
						$status = $this->input->post('status');
						$name = $this->input->post('menu');
						$order = $this->input->post('seq');
						$type = $this->input->post('type');
							
						/* add pages data to db */
						$count = count($order);
						for($i = 0; $i < $count; $i++)
						{
							$content =	'
								<h2>Welcome to your Site</h2>

								<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Cras et ipsum quis mi semper accumsan. Integer pretium dui id massa. Suspendisse in nisl sit amet urna rutrum imperdiet. Nulla eu tellus. Donec ante nisi, ullamcorper quis, fringilla nec, sagittis eleifend, pede. Nulla commodo interdum massa. Donec id metus. Fusce eu ipsum. Suspendisse auctor. Phasellus fermentum porttitor risus.</p>

								<h3>Services</h3>

								<ul>
									<li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Cras et ipsum quis mi semper accumsan.</li>
									<li>Integer pretium dui id massa. Suspendisse in nisl sit amet urna rutrum imperdiet.</li>
									<li>Nulla eu tellus. Donec ante nisi, ullamcorper quis, fringilla nec, sagittis eleifend, pede.</li>
									<li>Nulla commodo interdum massa. Donec id metus. Fusce eu ipsum. Suspendisse auctor. Phasellus fermentum porttitor risus.</li>
								</ul>
							';
							
							$socialenabled = "off";
							if(is_array($social)){
								if(in_array($i+1,$social))
								{
									$socialenabled = "on";
								}
							}
							$data = array(
								'website_id' => $web_id,
								'title' => 'menu'.$i, 
								'social' => $socialenabled,
								'status' => $status[$i], 
								'name' => $name[$i],
								'type' => $type[$i],
								'url' => url_title($name[$i],'-',true)
							);
							if($this->db->field_exists('page_seq', 'pages')) {
								$data['page_seq'] = $order[$i];
							} else {
								$data['order'] = $order[$i];
							}
							$result = $this->db->insert('pages', $data);
							$page_id = $this->db->insert_id('id');
							
							if($data['type'] == 'article')
							{
								$dataArticle = array(
									'page_id' => $page_id,
									'content' => $content
								);
								$result = $this->db->insert('articles', $dataArticle);
							}
							if($data['type'] == 'contact_us')
							{
								$dataContactUs = array(
									'page_id' => $page_id,
								);
								$result = $this->db->insert('contact_us', $dataContactUs);
							}
						}

						$layout = $this->input->post('layout');	
						$data = array(
							'layout' => $layout
						);
						$this->db->where('id', $this->session->userdata('website_id'));
						$result = $this->db->update('websites', $data);
						
						// /* insert footer */
						
						$this->db->where('website_id', $this->session->userdata('website_id'));
						$new_footer_update_data = array(
							'website_id' => $web_id,
							'label' => 'Copyright &copy; 2013. All Rights Reserved.',
							'color' => '#FFF',
							'bgcolor' => 'rgba(0,0,0,0.5)',
							'noads' => 0
						);
						$result = $this->db->insert('footer', $new_footer_update_data);
					}
					$callback['fb_message'] = $this->facebook_model->fb_action_create($web['url']);
					$callback['web_id'] = $web_id;
					echo json_encode($callback);
				}
			}
		} else {
			redirect(base_url());
		}
	}
}

/* End of file store.php */
/* Location: ./application/controllers/store.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('encrypt');
		$this->load->library('session');
		$this->load->model('times_model');
		$this->load->model('wall_updates');
		$this->load->library('email');
		$this->load->helper('date');
		$this->load->database();
		$this->load->model('photo_model');
		$this->load->model('times_model');
	}

	function index() {
		date_default_timezone_set('Asia/Manila');
		if($this->session->userdata('logged_in')) {
			if($this->input->get()) {
				$uid = $this->input->get('uid');
			} else {
				$uid = $this->session->userdata('uid');
			}

			$this->db->where('uid', $uid);
			$data['queryuser'] = $this->db->get('users');

			/* Get user_bank_details */
			$uid = $this->session->userdata('uid');			
			$this->db->where('user_id', $uid);
			$bankquery = $this->db->get('user_bank_details');
			$data['bank_details_array'] = $bankquery;
			
			/* Get user_delivery_method */
			$uid = $this->session->userdata('uid');			
			$this->db->where('user_id', $uid);
			$del_query = $this->db->get('user_delivery_method');
			$data['delivery_method_array'] = $del_query;
			
			/* Get user_payment_option */
			$uid = $this->session->userdata('uid');			
			$this->db->where('user_id', $uid);
			$payoption_query = $this->db->get('user_payment_option');
			$data['payment_option_array'] = $payoption_query;
			
			$data['pass_error'] = '';
			$data['activemenu'] = 'profile';
			$data['sidebar'] = $this->load->view('dashboard/sidebar', $data, true);
			$data['content'] = $this->load->view('manage/profile', $data, true);

			$data2home['bar_holder'] = $this->load->view('bar_holder', $data, true);
			$data2home['body'] = $this->load->view('manage_account', $data, true);
			$data2home['footer'] = '';
			
			$this->load->view('dashboard/template', $data2home);
		} else {
			redirect(base_url());
		}
		
		
		$query_region = $this->db->get('regions');
		if($query_region->num_rows() == 0)
		{
			$this->db->query("
				INSERT INTO `regions` (`id`, `region`) VALUES
				(1, 'NCR'),
				(2, 'CAR'),
				(3, 'REGION I'),
				(4, 'REGION II'),
				(5, 'REGION III'),
				(6, 'REGION IV'),
				(7, 'REGION IV-A'),
				(8, 'REGION IV-B'),
				(9, 'REGION V'),
				(10, 'REGION VI'),
				(11, 'REGION VII'),
				(12, 'REGION VIII'),
				(13, 'REGION IX'),
				(14, 'REGION X'),
				(15, 'REGION XI'),
				(16, 'REGION XII'),
				(17, 'REGION XIII'),
				(18, 'REGION ARMM');
			");
		}
		
	}
	
	function update()
	{
		// $array_method = $this->input->post('chkssetting');
		// $sample = array_search('meetup', $array_method);
		// print_r($sample);
		
		$uid = $this->session->userdata('uid');
		$this->load->library('encrypt');
		
		$this->db->where('uid', $uid);
		$queryuser = $this->db->get('users');
		$result = $queryuser->row_array();
		$data['image'] = 'http://www.placehold.it/164x164/333333/ffffff&text=no+photo';
	
		if(isset($result['profile_picture']) || $result['profile_picture'] != null){
			$checkPic = 'uploads/'.$uid.'/medium/'.$result['profile_picture'];
			
			if($this->photo_model->image_exists($checkPic)) {
				$data['image'] = base_url().$checkPic;
			} else {
				$checkPic = 'uploads/'.$uid.'/'.$result['profile_picture'];
				if($this->photo_model->image_exists($checkPic)) {
					$data['image'] = base_url().$checkPic;
				} else {
					$checkPic = 'uploads/'.$result['profile_picture'];
					if($this->photo_model->image_exists($checkPic)) {
						$data['image'] = base_url().$checkPic;
					} else {
						$data['image'] = 'http://www.placehold.it/164x164/333333/ffffff&text=image+not+found';
					}
				}
			}
		}

		if(isset($_FILES['upload_image'])) {
			$this->load->model('Photo_Model');
			$uploaded = $this->photo_model->upload('upload_image', $uid);
			$thumbnail = $this->photo_model->make_thumbnail($uploaded['full_path']);
			$medium = $this->photo_model->make_medium($uploaded['full_path']);

			/* for upload image file */
			if(isset($uploaded['file_name']))
			{
				$this->db->query("UPDATE users SET profile_picture = '".$uploaded['file_name']."' WHERE uid = '".$uid."'");
				$data['image'] = base_url().'uploads/'.$uid.'/medium/'.$uploaded['file_name'];
			}
		}
		/* end of upload image file */
		
		if($button = $this->input->post('button'))
		{
			if($button=='profile')
			{
				$data['pass_error'] = '';
				$data['save'] = 'success';				
				
				/* check if bank details has been set  */
				if($this->input->post('user_bankname'))
				{
					$bank_name = $this->input->post('user_bankname');
					$bank_acc = $this->input->post('user_acctname');
					$bank_num = $this->input->post('user_acctnum');
					
					$bank_query = $this->db->where('user_id',$uid)->get('user_bank_details');
					if($bank_query->num_rows() == 0)
					{
						foreach($bank_name as $count => $bank_item)
						{
							$array_bank = array(
								'user_id' => $uid,
								'bank_name' => $bank_item,
								'account_name' => $bank_acc[$count],
								'account_number' => $bank_num[$count]
							);
							$this->db->insert('user_bank_details',$array_bank);
						}
						
					}else
					{
						/* check if bank name already in database and delete data in bank details where not in array */
						$array_search = array();
						foreach($bank_name as $count => $bank_item)
						{
							array_push($array_search,$bank_item);
						}
						
						/* delete bank details where not in array */
						$this->db->where('user_id',$uid)->where_not_in('bank_name',$array_search)->delete('user_bank_details');
						
						/* insert to table */
						foreach($bank_name as $count => $bank_item)
						{
							$this->db->where('bank_name',$bank_item);
							$bank_query = $this->db->get('user_bank_details')->num_rows();
							if($bank_query == 0)
							{
								$array_bank = array(
									'user_id' => $uid,
									'bank_name' => $bank_item,
									'account_name' => $bank_acc[$count],
									'account_number' => $bank_num[$count]
								);
								$this->db->insert('user_bank_details',$array_bank);
							}
						}
					}
				}else
				{
					/* delete existing */
					$this->db->where('user_id',$uid)->delete('user_bank_details');
				}
				
				/* delivery method */
				$array_method = $this->input->post('chkssetting');
				$method_price = $this->input->post('method_price');
				
				if($array_method)
				{
					/* delete existing first */
					$this->db->where('user_id',$uid)->delete('user_delivery_method');
					
					/* insert data every delivery method set */
					foreach($array_method as $count => $item)
					{
						$delivery_array = array(
							'user_id' => $uid,
							'name' => $item,
							'price' => $method_price[$count] ? $method_price[$count] : 0
						);
						
						$this->db->insert('user_delivery_method',$delivery_array);
					}
					
				}else
				{
					/* delete existing first */
					$this->db->where('user_id',$uid)->delete('user_delivery_method');
				}
				
				/* payment option */
				$paypal_email = $this->input->post('mail_paypal');
				$paypal_email = trim($paypal_email);
				
				
				$gcash = $this->input->post('gnum');
				$gcash = trim($gcash);
				
				
				$smart_money = $this->input->post('snum');
				$smart_money = trim($smart_money);
				
				if($paypal_email || $gcash || $smart_money)
				{
					$data_array = array(
						'user_id' => $uid, 
						'paypal_email' => $paypal_email, 
						'gcash' => $gcash, 
						'smart_money' => $smart_money
					);
					$this->db->where('user_id',$uid);
					$query = $this->db->get('user_payment_option');
					if($query->num_rows() > 0)
					{
						$this->db->where('user_id',$uid)->update('user_payment_option',$data_array);
					}else
					{
						$this->db->insert('user_payment_option',$data_array);
					}
				}
				
				
				// $chkssetting = '';
				// if($this->input->post('chkssetting')){
					// $chkssetting = json_encode($this->input->post('chkssetting'));
				// }				
				
				// $this->db->where('user_id', $this->session->userdata('uid'));
				// $chkquery = $this->db->get('checkout_settings');
				
				// $payment_settings_data = array(
					// 'settings' => $chkssetting,
					// 'user_id' => $this->session->userdata('uid'),
					// 'paypal_email' => $this->input->post('mail_paypal'),
					// 'gcash' => $this->input->post('gnum'),
					// 'smart_money' => $this->input->post('snum')
				// );
				
				// if($chkquery->num_rows() > 0){
					// $this->db->where('user_id', $this->session->userdata('uid'));
					// $this->db->update('checkout_settings', $payment_settings_data);
				// } else {
					// $this->db->insert('checkout_settings', $payment_settings_data);
				// }
				/* Checkout Settings */

				$profile_update_data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name')
				);

				
				$this->db->where('uid', $this->session->userdata('uid'));
				$insert = $this->db->update('users', $profile_update_data);
				
				$user_info_data = array(
					'user_id' => $this->session->userdata('uid'),
					'age' => $this->input->post('age'),
					'bday' => strtotime($this->input->post('bdate')),
					'sex' => $this->input->post('sex'),
					'address' => $this->input->post('address'),
					'region' => $this->input->post('region'),
					'city' => $this->input->post('city'),
					'mobile_num' => $this->input->post('mobile'),
					'landline' => $this->input->post('Landline'),
					'fax_num' => $this->input->post('fax')
				);
				
				$this->db->where('user_id',$this->session->userdata('uid'));
				$query_info = $this->db->get('user_profile_info');
				$row_info = $query_info->row_array();
				
				if($query_info->num_rows() > 0)
				{
					$this->db->where('user_id',$this->session->userdata('uid'));
					$this->db->update('user_profile_info',$user_info_data);
				}else
				{
					$this->db->insert('user_profile_info',$user_info_data);
				}
			}
		}
			$return_data = json_encode($data);
			echo $return_data;
	}
	
	function otherdelivery(){
		$delivery_name = $this->input->post('other_name');		
		
		$this->db->where('user_id', $this->session->userdata('uid'));
		$query_checkout_settings = $this->db->get('checkout_settings');
		
		if($query_checkout_settings->num_rows() > 0) {
			$result_checkout_settings = $query_checkout_settings->row_array();
			$other_delivery_array = json_decode($result_checkout_settings['other_delivery']);
			
			$other_delivery_array[] = $delivery_name;
			$other_delivery = json_encode($other_delivery_array);
			$other_data = array(
				'other_delivery' => $other_delivery
			);
			$this->db->where('user_id', $this->session->userdata('uid'));
			$this->db->update('checkout_settings', $other_data);
		} else {
			$other_delivery_array[] = $delivery_name;
			$other_data = array(
				'other_delivery' => json_encode($other_delivery_array)
			);
			$other_data['user_id'] = $this->session->userdata('uid');			
			$this->db->insert('checkout_settings', $other_data);
		}
	}
	
	function bankaccount(){
		$bnkname = $this->input->post('bnkname');
		$accname = $this->input->post('accname');
		$accnum = $this->input->post('accnum');
		
		$bnk_records = array();
		$bank_details = array(
			'bank_name' => $bnkname,
			'acct_name' => $accname,
			'acct_num' => $accnum
		);
		
		// $bank_details = $bnkname.','.$accname.','.$accnum;
		$bnk_records[] = $bank_details;		
		
		$this->db->where('user_id', $this->session->userdata('uid'));
		$insert = $this->db->get('checkout_settings');	
		
		$insert_other_data = array(
			'bank_details' => json_encode($bnk_records),
			'user_id' => $this->session->userdata('uid')
		);		
		
		if($insert->num_rows() > 0){
			$result = $insert->row_array();
			
			if(!empty($result['bank_details'])){
				$bnk_records = json_decode($result['bank_details'],true);
				// array_push($bnk_records, $bank_details);
				$bnk_records[] = $bank_details;
			}
			
			foreach($bnk_records as $key => $value){
				if($value['acct_num'] == $accnum){
					echo $key;
				}
			}
			
			$other_data = array(
				'bank_details' => json_encode($bnk_records)
			);
			
			$this->db->where('user_id', $this->session->userdata('uid'));
			$this->db->update('checkout_settings', $other_data);
		}else{
			$this->db->insert('checkout_settings', $insert_other_data);
			echo 0;
		}
		
	}
	
	function reset_password()
	{
		
		$password = $this->input->post('input_pass');
		$passEn = $this->encrypt->encode($password);
		$uid = $this->input->post('user_id');
		$hash = $this->input->post('hash_id');
		
		$this->db->where('uid',$uid);
		$this->db->where('hash',$hash);
		$query = $this->db->get('users');
		$row = $query->row_array();
		
		/* reset hash to avoid turning back */
		$email = $row['email'];
		$new_hash = md5($email.time());
		
		
		if($query->num_rows() > 0)
		{
			$data_users = array(
				'password' => $passEn,
				'hash' => $new_hash,
				'email_status' => '1'
			);
			$this->db->where('uid',$uid);
			$this->db->update('users',$data_users);
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	
	function city_list()
	{
		$id = $this->input->post('id');
		
		$this->db->where('region_id',$id);
		$query = $this->db->get('city');
		echo '<option value="0">Select...</option>';
		if($query->num_rows() > 0)
		{
			foreach($query->result_array() as $row)
			{
				echo '<option value="'.$row['city'].'">'.$row['city'].'</option>';
			}
		}
	}
	
	function removeProfilePicture()
	{
		$id = $this->input->post('uid');
		$this->db->where('uid',2);
		$getUser = $this->db->get('users');
		$row = $getUser->row_array();
		if($getUser->num_rows() > 0)
		{
			$data_array = array(
				'profile_picture' => NULL
			);
			$this->db->where('uid',$id);
			$this->db->update('users',$data_array);
		}
	}
	
	function updatebank(){
		if(isset($_POST)){
			$bank_array = array();
			$actnum_past = $this->input->post('actnum_past');
			$bncname = $this->input->post('bncname');
			$actname = $this->input->post('actname');
			$actnum = $this->input->post('actnum');
			
			$this->db->where('user_id', $this->session->userdata('uid'));
			$ckquery = $this->db->get('checkout_settings');
			$cksettings = $ckquery->row_array();
			
			if($cksettings['bank_details']){
				foreach(json_decode($cksettings['bank_details']) as $key => $bank_row){
					
					// if($bank_part[2] == $actnum_past){
						// $bank_array[$key] = $bncname.','.$actname.','.$actnum;
					// }else{
						// $bank_array[$key] = $bank_part[0].','.$bank_part[1].','.$bank_part[2];
					// }
					
					if($bank_row->acct_num == $actnum_past){
						$bank_array[$key] = array(
							'bank_name' => $bncname,
							'acct_name' => $actname,
							'acct_num' => $actnum
						);
					}else{
						$bank_array[$key] = array(
							'bank_name' => $bank_row->bank_name,
							'acct_name' => $bank_row->acct_name,
							'acct_num' => $bank_row->acct_num
						);
					}
				}
				
				$update_array = array(
					'bank_details' => json_encode($bank_array)
				);
				
				$this->db->where('user_id', $this->session->userdata('uid'));
				$this->db->update('checkout_settings', $update_array);
			}
		}
	}
	
	/* function remove_bank(){
		if(isset($_POST)){
			$bank_array = array();
			$key_to_remove = $this->input->post('rev_key');
			
			$this->db->where('user_id', $this->session->userdata('uid'));
			$ckquery = $this->db->get('checkout_settings');
			$cksettings = $ckquery->row_array();
			
			if($cksettings['bank_details']){
				foreach(json_decode($cksettings['bank_details']) as $key => $bank_row){
					
					if($key == $key_to_remove){
						//do nothing
					}else{
						// $bank_array[$key] = $bank_row[0].','.$bank_row[1].','.$bank_row[2];
						$bank_array[$key] = array(
							'bank_name' => $bank_row->bank_name,
							'acct_name' => $bank_row->acct_name,
							'acct_num' => $bank_row->acct_num
						);
					}
				}
				
				$update_array = array(
					'bank_details' => json_encode($bank_array)
				);
				
				$this->db->where('user_id', $this->session->userdata('uid'));
				$this->db->update('checkout_settings', $update_array);
			}
		}
	} */
}
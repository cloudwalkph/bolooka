<?php

class Photo_Model extends CI_Model {

	function upload($field_name=null, $user=null)
	{
		if($user != null) {
			$upload_dir = 'uploads/'.$user.'/';
		} else {
			$upload_dir = 'uploads/';
		}
		if(!is_dir($upload_dir))
		{
		   mkdir($upload_dir, 0755, true);
		}	
		
		$this->load->library('upload');
		$config['upload_path'] = $upload_dir; //if the files does not exist it'll be created 
		$config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
		// $config['max_size'] = '2000'; //size in kilobytes
		$config['encrypt_name']  = TRUE;

			$this->upload->initialize($config);

			if (!$this->upload->do_upload($field_name))
			{
				$uploaded = $this->upload->display_errors();
			}
			else
			{
				$uploaded = $this->upload->data();
				
			}

		return $uploaded; /* prints the result of the operation and analyze the data */
	}
	
	function multi_upload($product=0, $page=0, $web=0, $user=0, $type=null)
	{
		if($type == 'album') {
			$upload_dir = 'files/' . $product . '/';
		} else {
			$upload_dir = 'uploads/';
			if($user != 0) {
				$upload_dir .= $user . '/';
				if($web != 0) {
					$upload_dir .= $web . '/';
					if($page != 0) {
						$upload_dir .= $page . '/';
						if($product != 0) {
							$upload_dir .= $product . '/';
						}
					}
				}
			}
		}
		if(!is_dir($upload_dir))
		{
		   mkdir($upload_dir, 0755, true);
		}
	
		$this->load->library('upload');
		$config['upload_path'] = $upload_dir; //if the files do not exist it'll be created 
		$config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
		$config['max_size'] = '4000'; //size in kilobytes
		$config['encrypt_name']  = TRUE;

		$this->upload->initialize($config);

		$uploaded = $this->upload->up(TRUE); //Pass true if you want to create the index.php files

		return $uploaded; //prints the result of the operation and analyze the data */
	}
	
	function make_thumbnail($image_file=null, $image_width=80, $image_height=80) {
		list($width, $height) = getimagesize($image_file);

			$image_info = pathinfo($image_file);
		
			$this->load->library('image_lib');
			
			$img_array['image_library'] = 'gd2';
			$img_array['source_image'] = $image_file;
			$img_array['maintain_ratio'] = TRUE;
			$img_array['width'] = $image_width;
			$img_array['height'] = $image_height;
			
			$folderName = $image_info['dirname'].'/thumbnail';
			
			if(!is_dir($folderName))
			{
			   mkdir($folderName, 0755, true);
			}

			$img_array['new_image'] = $folderName.'/'.$image_info['basename'];
			
		if($width > $image_width || $height > $image_height) {
			$this->image_lib->initialize($img_array);
			if (!$this->image_lib->resize())
			{
				return $this->image_lib->display_errors('<p>','</p>');
			}
		} else {
			if (!copy($image_file, $img_array['new_image'])) {
				echo "failed to copy $file...\n";
			}
		}
		return $img_array['new_image'];
	}

	function make_medium($image_file=null, $image_width=0, $image_height=0) {
		list($width, $height) = getimagesize($image_file);
		
		$image_info = pathinfo($image_file);
	
		$this->load->library('image_lib');
		
		$img_array['image_library'] = 'gd2';
		$img_array['source_image'] = $image_file;
		$img_array['maintain_ratio'] = TRUE;
		$img_array['width'] = 800;
		$img_array['height'] = 600;
		
		$folderName = $image_info['dirname'].'/'.'medium';
		
		if(!is_dir($folderName))
		{
		   mkdir($folderName, 0755, true);
		}

		$img_array['new_image'] = $folderName.'/'.$image_info['basename'];
		
		if($width > 800 || $height > 600) {

			$this->image_lib->initialize($img_array);
			
			if ( ! $this->image_lib->resize())
			{
				return $this->image_lib->display_errors('<p>','</p>');
			}
		} else {
			if (!copy($image_file, $img_array['new_image'])) {
				echo "failed to copy $file...\n";
			}		
		}
		
		return $img_array['new_image'];
	}

	function custom_thumbnail($image_file=null, $image_width=240, $image_height=1000) {
		list($width, $height) = getimagesize($image_file);

			$image_info = pathinfo($image_file);
		
			$this->load->library('image_lib');
			
			$img_array['image_library'] = 'gd2';
			$img_array['source_image'] = $image_file;
			$img_array['maintain_ratio'] = TRUE;
			$img_array['width'] = $image_width;
			if($height < 1000) {
				$img_array['height'] = $image_height;
			} else {
				$img_array['height'] = $height;
			}
			
			$folderName = $image_info['dirname'].'/s'.$image_width;
			$img_array['new_image'] = $folderName.'/'.$image_info['basename'];

			if(!is_dir($folderName))
			{
			   mkdir($folderName, 0755, true);
			}

		// if($width > $image_width || $height > $image_height) {
			$this->image_lib->initialize($img_array);
			if (!$this->image_lib->resize()) {
				// return $this->image_lib->display_errors('<p>','</p>');
			} else {
				return $img_array['new_image'];
			}
		// } else {
			// if (!copy($image_file, $img_array['new_image'])) {
				// echo "failed to copy $file...\n";
			// }
		// }
	}
	
	function image_exists($img) {
		// $img = realpath($img);
		if(!is_file($img)) {
			return false;
		} else {
			return true;
		}
	}
	
	function get_size($img) {
		$size = getimagesize($img);
		return $size;
	}
	
	function create_thumbs($file=null) {
		
	}
	
	/* convert upload_max_filesize values to bytes */
	
	function return_bytes($val) {
		$val = trim($val);
		$last = strtolower($val[strlen($val)-1]);
		switch($last) {
			// The 'G' modifier is available since PHP 5.1.0
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}

		return $val;
	}
	
	function test_upload($product=0, $page=0, $web=0, $user=0, $type=null)
	{
		if($type == 'album') {
			$upload_dir = 'files/' . $product . '/';
		} else {
			$upload_dir = 'test_uploads/';
			if($user != 0) {
				$upload_dir .= $user . '/';
				if($web != 0) {
					$upload_dir .= $web . '/';
					if($page != 0) {
						$upload_dir .= $page . '/';
						if($product != 0) {
							$upload_dir .= $product . '/';
						}
					}
				}
			}
		}
		if(!is_dir($upload_dir))
		{
		   mkdir($upload_dir, 0755, true);
		}
	
		$this->load->library('upload');
		$config['upload_path'] = $upload_dir; //if the files do not exist it'll be created 
		$config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
		$config['max_size'] = '4000'; //size in kilobytes
		$config['encrypt_name']  = TRUE;

		$this->upload->initialize($config);

		$uploaded = $this->upload->up(TRUE); //Pass true if you want to create the index.php files

		return $uploaded; //prints the result of the operation and analyze the data */
	}
}
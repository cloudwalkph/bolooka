<?php
	class Gallery_Model extends CI_Model
	{
		function getAlbums($album_id = 0, $wid = 0, $page_id = 0) {
			if($album_id != 0)
				$this->db->where('id', $wid);

			if($wid != 0)
				$this->db->where('web_id', $wid);
				
			if($page_id != 0)
				$this->db->where('page_id', $page_id);
				
			$this->db->order_by('id desc');

			$qalbum = $this->db->get('albums');

			return $qalbum;
		}
		
		function updateAlbums($album_id = 0, $album_cover = null) {
			if($this->db->field_exists('album_cover', 'albums'))
			{
				$update_array = array( 'album_cover' => $album_cover );
			} else {
				$update_array = array( 'primary' => $album_cover );
			}
			$this->db->where('id', $album_id);
			$this->db->update('albums', $update_array);
		}
		
		function getGallery($gallery_id = 0, $album_id = 0) {

			if($album_id != 0)
				$this->db->where('albums', $album_id);

			$this->db->order_by('sortdata');

			$qgallery = $this->db->get('gallery');

			return $qgallery;
		}
	function insertAlbums($web_id = 0, $page_id = 0, $album_name = null, $album_description = null) {
		$album_data = array (
				'web_id' => $web_id,
				'page_id' => $page_id,
				'album_name' => $album_name,
				'created' => time () 
		);
		if ($this->db->field_exists ( 'descrip', 'albums' )) :
			$album_data ['descrip'] = $album_description;
		 else :
			$album_data ['discrip'] = $album_description;
		endif;
		$this->db->insert ( 'albums', $album_data );
		
		return $this->db->insert_id ();
	}
		
		function deleteAlbums() {
			
		}

	}
?>
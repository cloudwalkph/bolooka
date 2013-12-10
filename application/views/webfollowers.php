<?php
	$this->db->where('website_id', $wid);
	$queryLogo = $this->db->get("logo");	
	$rowLogo = $queryLogo->row_array();
	
	$this->db->where('id',$wid);
	$queryWebsite = $this->db->get('websites');	
	$rowWebsite = $queryWebsite->row_array();
	
	$this->db->where('website_id', $wid);
	$this->db->order_by('id','desc');
	$query = $this->db->get('follow');
?>
<div class="container-fluid mobile_view">
	<legend style="font-family: Segoe UI Semibold; font-size: 18px; color: rgb(23, 23, 23);">Followers</legend>
	<ul class="thumbnails">
		<?php
			if($query->num_rows() > 0){
				foreach($query->result_array() as $row){
					
					$this->db->where('uid', $row['users']);
					$this->db->order_by('uid','desc');
					$this->db->limit(1);
					$thisquery = $this->db->get('users');
					$userdata = $thisquery->row_array();
									
					
					/* $name = $userdata['name'];
					$profilePic = str_replace(" ","_",$userdata['profile_picture']); 
					$profile_pic = base_url().'uploads/'.$profilePic;

					if($profilePic == null)
					{
						$profile_pic = ''.base_url().'img/Default Profile Picture.jpg';
					} */
					if(isset($userdata['name'])){
						$profilePic = str_replace(" ","_",$userdata['profile_picture']); 
						$profile_pic = base_url().'uploads/'.$row['users'].'/medium/'.$profilePic;
		?>
			<li class="span2">
				<div class="thumbnail">
					<img src="<?php echo $profile_pic; ?>" onerror="this.src='http://www.placehold.it/164x164/333333/ffffff&text=no+photo'" />
					<h4 style="text-align: center; font-weight: normal;"><?php echo $userdata['name']; ?></h4>
				</div>
			</li>
		<?php
					}
				}
			}
		?>
	</ul>
</div>
<style type="text/css">
.web-owner
{
	display:none;
	position:absolute;
	margin-top: -55px;
	color: white;
	background: #7F7E7E;
	padding: 2px 4px;
	border-radius: 5px;
	font-size: 12px;
	margin-left: 28px;
}

.cat-followers:hover span.web-owner
{
	display:block;
	position:absolute;
}

/* RESPONSIVE */
@media (max-width: 767px)
{
	.mobile_view {
		padding: 0 8px;
	}
}
</style>

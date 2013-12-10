<?php
//left container pagination
if(isset($_GET['domainId'])){

	$siteId = $this->session->userdata('site');
	$logoId = $this->session->userdata('logos');
	$pageId = $this->session->userdata('pageId');
	$footerId = $this->session->userdata('footerId');
	$designId = $this->session->userdata('designId');
	$layoutId = $this->session->userdata('layoutId');
	$domainId = $this->session->userdata('bannerId');
	$this->session->set_userdata('domainId','8');
	
	if((!empty($siteId)) OR (!empty($logoId)) OR (!empty($pageId)) OR (!empty($footerId)) OR (!empty($designid)) OR (!empty($layoutId)) OR (!empty($bannerId)))
	{
		
		$this->session->unset_userdata('site');
		$this->session->unset_userdata('logos');
		$this->session->unset_userdata('pageId');
		$this->session->unset_userdata('footerId');
		$this->session->unset_userdata('designId');
		$this->session->unset_userdata('layoutId');
		$this->session->unset_userdata('bannerId');
	}
	
}
?>
				<div id="headerArea">
					<div class="uiHeader uiHeaderPage uiHeaderBottomBorder">
						<h2 style="text-decoration:underline;">Buy Domain Page:</h2>
					</div>
				</div>

				<div id="contentArea">
				</div>
				
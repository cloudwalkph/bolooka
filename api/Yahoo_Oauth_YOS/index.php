<?php
	include 'yahoo_connect.php';
?>
<?php
		if ($this->session->userdata('login') == true) {
			// echo "You are : " . $_SESSION['name'] . "<br/>";
			// echo "GUID : " . $_SESSION['guid'];
			echo '<br/><a class="" href="?logout"></a>';
		} else {
			echo '<a class="mp_oss_i mp_oss_i_yahoo" href="'.base_url().'signup/yin"><img src="'.base_url().'img/yahoo_icon_drop.png" style="height: 17px; width: 17px;"> Yahoo </a>';
		}
?>

<style type="text/css">
.reg-domain .control-group .help-inline{
	display:none;
}
</style>
<div class="alert alert-block domain-empty-err" style="display:none;">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	Please type your domain name.
</div>
<div class="alert alert-error domain-not-err" style="display:none;">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	This <span class="dnames"></span> is not available.
</div>
<?php
	if(!isset($_GET['paypal'])){
	$this->db->where('web_id', $wid);
	$query2 = $this->db->get('domainlist');
	if($query2->num_rows() == 0){
?>
<div class="row-fluid" style="text-align: center;margin-bottom: 20px;">
	<h4>Register a Domain to your site:</h4>
<form class="form-inline">
	<div class="input-prepend input-append domain-input" style="margin-left: 2px;">
		<span class="add-on" style="padding: 8px 5px;">www</span>
			<input style="min-height: 38px;min-width: 150px;" class="span2 txt-look-domain" id="appendedPrependedInput" type="text" placeholder="yourdomain">
		<select class="add-on ext" style="min-height: 38px;-webkit-appearance:none;">
			<option value="com" selected="selected">.com</option>
			<option value="net">.net</option>
			<option value="org">.org</option>
			<option value="me">.me</option>
			<option value="mobi">.mobi</option>
			<option value="us">.us</option>
			<option value="asia">.asia</option>
			<option value="biz">.biz</option>
			<option value="co">.co</option>
			<option value="info">.info</option>
		</select>
		<a style="padding: 8px 18px;" class="btn btn-primary ck-domain-button" href="#">Search</a><span class="load-img" style="display:none;margin-left: 11px;position: relative;top: 9px;"><img src="<?php echo base_url(); ?>img/add.gif" /></span>
	</div>
</form>
	<div class="row-fluid dom-list">

	</div>
</div>
<?php
	}else{
		$resu = $query2->row_array();
?>
<div class="row-fluid">
	<label>Your Domain: </label><h2>www.<?php echo $resu['domain']; ?></h2>
</div>
<?php
	}
?>
<?php
	}else{
?>
<div class="row-fluid domain-form" style="margin-bottom: 20px;">
	<h4>Domain Registration:</h4>
	<form class="form-horizontal reg-domain">
		<div class="control-group">
			<label class="control-label" for="selectDomain" style="padding-top: 0;">Domain:</label>
			<div class="controls">
				<select name="selectDomain" id="selectDomain">
<?php
					$this->db->where('payment_type','domain');
					$query = $this->db->get('transactions');
					if($query->num_rows() > 0){	
						foreach($query->result_array() as $rows){
							$this->db->where('domain', $rows['product_id_array']);
							$thisquery = $this->db->get('domainlist');
							if($thisquery->num_rows() == 0){
								echo '<option value="'.$rows['product_id_array'].'">'.$rows['product_id_array'].'</option>';
							}							
						}
					}
?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" style="padding-top: 0;">Year:</label>
			<div class="controls">
				<p>1 Year</p>
			</div>
		</div>
		<div class="control-group reg-domain-input">
			<label class="control-label" for="inputFname">First Name: <span style="color:red;">*</span></label>
			<div class="controls">
				<input type="text" id="inputFname" placeholder="First Name">
				<span class="help-inline">Required</span>
			</div>
		</div>
		<div class="control-group reg-domain-input">
			<label class="control-label" for="inputLname">Last Name: <span style="color:red;">*</span></label>
			<div class="controls">
				<input type="text" id="inputLname" placeholder="Last Name">
				<span class="help-inline">Required</span>
			</div>
		</div>
		<div class="control-group reg-domain-input">
			<label class="control-label" for="inputEmail">Email: <span style="color:red;">*</span></label>
			<div class="controls">
				<input type="text" id="inputEmail" placeholder="Email">
				<span class="help-inline">Required</span>
			</div>
		</div>
		<div class="control-group reg-domain-input">
			<label class="control-label" for="inputAddress">Address: <span style="color:red;">*</span></label>
			<div class="controls">
				<textarea id="inputAddress" placeholder="Address" style="width: 515px;height: 134px;"></textarea>
				<span class="help-inline">Required</span>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputProvince">Province:</label>
			<div class="controls">
				<input type="text" id="inputProvince" placeholder="Province">
			</div>
		</div>
		<div class="control-group reg-domain-input">
			<label class="control-label" for="inputPostal">Postal: <span style="color:red;">*</span></label>
			<div class="controls">
				<input type="text" id="inputPostal" placeholder="Postal">
				<span class="help-inline">Required</span>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputPhone">Phone:</label>
			<div class="controls">
				<input type="text" id="inputPhone" placeholder="Phone">				
			</div>
		</div>
		<div class="control-group reg-domain-input">
			<label class="control-label" for="inputCountry">Country: <span style="color:red;">*</span></label>
			<div class="controls">
				<select name="inputCountry" id="inputCountry">
					<option value="">Select...</option>
					<option value="AF">Afghanistan</option>
					<option value="AX">ÅLand Islands</option>
					<option value="AL">Albania</option>
					<option value="DZ">Algeria</option>
					<option value="AS">American Samoa</option>
					<option value="AD">Andorra</option>
					<option value="AO">Angola</option>
					<option value="AI">Anguilla</option>
					<option value="AQ">Antarctica</option>
					<option value="AG">Antigua And Barbuda</option>
					<option value="AR">Argentina</option>
					<option value="AM">Armenia</option>
					<option value="AW">Aruba</option>
					<option value="AU">Australia</option>
					<option value="AT">Austria</option>
					<option value="AZ">Azerbaijan</option>
					<option value="BS">Bahamas</option>
					<option value="BH">Bahrain</option>
					<option value="BD">Bangladesh</option>
					<option value="BB">Barbados</option>
					<option value="BY">Belarus</option>
					<option value="BE">Belgium</option>
					<option value="BZ">Belize</option>
					<option value="BJ">Benin</option>
					<option value="BM">Bermuda</option>
					<option value="BT">Bhutan</option>
					<option value="BO">Bolivia</option>
					<option value="BA">Bosnia And Herzegovina</option>
					<option value="BW">Botswana</option>
					<option value="BV">Bouvet Island</option>
					<option value="BR">Brazil</option>
					<option value="OI">British Indian Ocean Territory</option>
					<option value="BN">Brunei Darussalam</option>
					<option value="BG">Bulgaria</option>
					<option value="BF">Burkina Faso</option>
					<option value="BI">Burundi</option>
					<option value="KH">Cambodia</option>
					<option value="CM">Cameroon</option>
					<option value="CA">Canada</option>
					<option value="CV">Cape Verde</option>
					<option value="KY">Cayman Islands</option>
					<option value="CF">Central African Republic</option>
					<option value="TD">Chad</option>
					<option value="CL">Chile</option>
					<option value="CN">China</option>
					<option value="CX">Christmas Island</option>
					<option value="CC">Cocos (Keeling) Islands</option>
					<option value="CO">Colombia</option>
					<option value="KM">Comoros</option>
					<option value="CG">Congo</option>
					<option value="CD">Congo, The Democratic Republic Of The</option>
					<option value="CK">Cook Islands</option>
					<option value="CR">Costa Rica</option>
					<option value="CI">Cote D'Ivoire</option>
					<option value="HR">Croatia</option>
					<option value="CU">Cuba</option>
					<option value="CY">Cyprus</option>
					<option value="CZ">Czech Republic</option>
					<option value="DK">Denmark</option>
					<option value="DJ">Djibouti</option>
					<option value="DM">Dominica</option>
					<option value="DO">Dominican Republic</option>
					<option value="EC">Ecuador</option>
					<option value="EG">Egypt</option>
					<option value="SV">El Salvador</option>
					<option value="GQ">Equatorial Guinea</option>
					<option value="ER">Eritrea</option>
					<option value="EE">Estonia</option>
					<option value="ET">Ethiopia</option>
					<option value="FX">Falkland Islands (Malvinas)</option>
					<option value="FO">Faroe Islands</option>
					<option value="FJ">Fiji</option>
					<option value="FI">Finland</option>
					<option value="FR">France</option>
					<option value="GF">French Guiana</option>
					<option value="PF">French Polynesia</option>
					<option value="TF">French Southern Territories</option>
					<option value="GA">Gabon</option>
					<option value="GM">Gambia</option>
					<option value="GE">Georgia</option>
					<option value="DE">Germany</option>
					<option value="GH">Ghana</option>
					<option value="GI">Gibraltar</option>
					<option value="GR">Greece</option>
					<option value="GL">Greenland</option>
					<option value="GD">Grenada</option>
					<option value="GP">Guadeloupe</option>
					<option value="GU">Guam</option>
					<option value="GT">Guatemala</option>
					<option value="GG">Guernsey</option>
					<option value="GN">Guinea</option>
					<option value="GW">Guinea-Bissau</option>
					<option value="GY">Guyana</option>
					<option value="HT">Haiti</option>
					<option value="HM">Heard Island And Mcdonald Islands</option>
					<option value="VA">Holy See (Vatican City State)</option>
					<option value="HN">Honduras</option>
					<option value="HK">Hong Kong</option>
					<option value="HU">Hungary</option>
					<option value="IS">Iceland</option>
					<option value="IN">India</option>
					<option value="ID">Indonesia</option>
					<option value="IR">Iran, Islamic Republic Of</option>
					<option value="IQ">Iraq</option>
					<option value="IE">Ireland</option>
					<option value="IM">Isle Of Man</option>
					<option value="IL">Israel</option>
					<option value="IT">Italy</option>
					<option value="JM">Jamaica</option>
					<option value="JP">Japan</option>
					<option value="JE">Jersey</option>
					<option value="JO">Jordan</option>
					<option value="KZ">Kazakhstan</option>
					<option value="KE">Kenya</option>
					<option value="KI">Kiribati</option>
					<option value="KP">Korea, Democratic People'S Republic Of</option>
					<option value="KR">Korea, Republic Of</option>
					<option value="KW">Kuwait</option>
					<option value="KG">Kyrgyzstan</option>
					<option value="LA">Lao People'S Democratic Republic</option>
					<option value="LV">Latvia</option>
					<option value="LB">Lebanon</option>
					<option value="LS">Lesotho</option>
					<option value="LR">Liberia</option>
					<option value="LY">Libyan Arab Jamahiriya</option>
					<option value="LI">Liechtenstein</option>
					<option value="LT">Lithuania</option>
					<option value="LU">Luxembourg</option>
					<option value="MO">Macao</option>
					<option value="MK">Macedonia, The Former Yugoslav Republic Of</option>
					<option value="MG">Madagascar</option>
					<option value="MW">Malawi</option>
					<option value="MY">Malaysia</option>
					<option value="MV">Maldives</option>
					<option value="ML">Mali</option>
					<option value="MT">Malta</option>
					<option value="MH">Marshall Islands</option>
					<option value="MQ">Martinique</option>
					<option value="MR">Mauritania</option>
					<option value="MU">Mauritius</option>
					<option value="YT">Mayotte</option>
					<option value="MX">Mexico</option>
					<option value="FM">Micronesia, Federated States Of</option>
					<option value="MD">Moldova, Republic Of</option>
					<option value="MC">Monaco</option>
					<option value="MN">Mongolia</option>
					<option value="MS">Montserrat</option>
					<option value="MA">Morocco</option>
					<option value="MZ">Mozambique</option>
					<option value="MM">Myanmar</option>
					<option value="NA">Namibia</option>
					<option value="NR">Nauru</option>
					<option value="NP">Nepal</option>
					<option value="NL">Netherlands</option>
					<option value="AN">Netherlands Antilles</option>
					<option value="NC">New Caledonia</option>
					<option value="NZ">New Zealand</option>
					<option value="NI">Nicaragua</option>
					<option value="NE">Niger</option>
					<option value="NG">Nigeria</option>
					<option value="NU">Niue</option>
					<option value="NF">Norfolk Island</option>
					<option value="MP">Northern Mariana Islands</option>
					<option value="NO">Norway</option>
					<option value="OM">Oman</option>
					<option value="PK">Pakistan</option>
					<option value="PW">Palau</option>
					<option value="PS">Palestinian Territory, Occupied</option>
					<option value="PA">Panama</option>
					<option value="PG">Papua New Guinea</option>
					<option value="PY">Paraguay</option>
					<option value="PE">Peru</option>
					<option value="PH">Philippines</option>
					<option value="PN">Pitcairn</option>
					<option value="PL">Poland</option>
					<option value="PT">Portugal</option>
					<option value="PR">Puerto Rico</option>
					<option value="QA">Qatar</option>
					<option value="RE">Reunion</option>
					<option value="RO">Romania</option>
					<option value="RU">Russian Federation</option>
					<option value="RW">Rwanda</option>
					<option value="SH">Saint Helena</option>
					<option value="KN">Saint Kitts And Nevis</option>
					<option value="LC">Saint Lucia</option>
					<option value="PM">Saint Pierre And Miquelon</option>
					<option value="VC">Saint Vincent And The Grenadines</option>
					<option value="WS">Samoa</option>
					<option value="SM">San Marino</option>
					<option value="ST">Sao Tome And Principe</option>
					<option value="SA">Saudi Arabia</option>
					<option value="SN">Senegal</option>
					<option value="CS">Serbia And Montenegro</option>
					<option value="SC">Seychelles</option>
					<option value="SL">Sierra Leone</option>
					<option value="SG">Singapore</option>
					<option value="SK">Slovakia</option>
					<option value="SI">Slovenia</option>
					<option value="SB">Solomon Islands</option>
					<option value="SO">Somalia</option>
					<option value="ZA">South Africa</option>
					<option value="GS">South Georgia And The South Sandwich Islands</option>
					<option value="ES">Spain</option>
					<option value="LK">Sri Lanka</option>
					<option value="SD">Sudan</option>
					<option value="SR">Suriname</option>
					<option value="SJ">Svalbard And Jan Mayen</option>
					<option value="SZ">Swaziland</option>
					<option value="SE">Sweden</option>
					<option value="CH">Switzerland</option>
					<option value="SY">Syrian Arab Republic</option>
					<option value="TW">Taiwan, Province Of China</option>
					<option value="TJ">Tajikistan</option>
					<option value="TZ">Tanzania, United Republic Of</option>
					<option value="TH">Thailand</option>
					<option value="TL">Timor-Leste</option>
					<option value="TG">Togo</option>
					<option value="TK">Tokelau</option>
					<option value="TO">Tonga</option>
					<option value="TT">Trinidad And Tobago</option>
					<option value="TN">Tunisia</option>
					<option value="TR">Turkey</option>
					<option value="TM">Turkmenistan</option>
					<option value="TC">Turks And Caicos Islands</option>
					<option value="TV">Tuvalu</option>
					<option value="UG">Uganda</option>
					<option value="UA">Ukraine</option>
					<option value="AE">United Arab Emirates</option>
					<option value="GB">United Kingdom</option>
					<option value="US">United States</option>
					<option value="UM">United States Minor Outlying Islands</option>
					<option value="UY">Uruguay</option>
					<option value="UZ">Uzbekistan</option>
					<option value="VU">Vanuatu</option>
					<option value="VE">Venezuela</option>
					<option value="VN">Viet Nam</option>
					<option value="VG">Virgin Islands, British</option>
					<option value="VI">Virgin Islands, U.S.</option>
					<option value="WF">Wallis And Futuna</option>
					<option value="EH">Western Sahara</option>
					<option value="YE">Yemen</option>
					<option value="ZM">Zambia</option>
					<option value="ZW">Zimbabwe</option>
				</select>
				<span class="help-inline">Required</span>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<a class="btn btn-primary reg-buton">Register Domain</a>
			</div>
		</div>
	</form>
</div>
<?php
	}
?>
<div class="row-fluid domain-info hidden">
	<label>Your Domain:</label><h2 class="dom-main"></h2>
	<p>Your Domain will be online after 24hrs.</p>
</div>
<script type="text/javascript">
$('.domain-input').delegate('.ck-domain-button','click', function(){
		
	var name = $('.txt-look-domain').val();
	var extension = $('.ext').val();
	var datastr = '';
	var domainname = 'domainname='+name+'&ext='+extension+'&web_id=<?php echo $wid; ?>';
	$('.domain-empty-err').hide();
	$('.domain-not-err').hide();
	//alert(domainname);
	if((name == '') || (name == ' '))
	{
		//alert('wala');
		$('.domain-empty-err').show();
	}
	else
	{
		//alert('meron');
		$('.load-img').show();
		$('.ck-domain-button').addClass('disabled');
		$.ajax({
			type: 'post',
			url: '<?php echo base_url(); ?>multi/checkdomain/',
			data: domainname,
			success: function(html)
			{
				if(html == 'not'){
					$('.domain-not-err').show();
					$('.dnames').html('www.'+name+'.'+extension);
					$('.ck-domain-button').removeClass('disabled');
					$('.load-img').hide();
				}else{
					$('.dom-list').html(html);
					$('.ck-domain-button').removeClass('disabled');
					$('.load-img').hide();
				}
			}
		});
	}
});
$('.reg-domain').delegate('.reg-buton','click',function(){
	var selectDomain = $('#selectDomain').val();
	var fname = $('#inputFname').val();
	var lname = $('#inputLname').val();
	var email = $('#inputEmail').val();
	var address = $('#inputAddress').val();
	var province = $('#inputProvince').val();
	var postal = $('#inputPostal').val();
	var phone = $('#inputPhone').val();
	var country = $('#inputCountry').val();
	var datastring = 'web_id=<?php echo $wid; ?>&domain='+selectDomain+'&years=1&fname='+fname+'&lname='+lname+'&email='+email+'&address='+address+'&province='+province+'&postal='+postal+'&phone='+phone+'&country='+country;
	// alert(datastring);
	$('.reg-domain-input').removeClass('error');
	$('.reg-domain .control-group .help-inline').hide();
	if(fname == '' || lname == '' || email == '' || address == '' || postal == '' || country == ''){
		$('.reg-domain-input').addClass('error');
		$('.reg-domain .control-group .help-inline').show();
		return false;
	}else{
		// alert(datastring);
		$('.domain-form').empty();
		$('.domain-form').html('<p style="text-align: center;"><img src="<?php echo base_url(); ?>img/ajax-loader.gif" /></p>');
		$.ajax({
			type:'post',
			url:'<?php echo base_url(); ?>multi/recorddomain',
			data: datastring,
			success: function(html)
			{
				//alert(html);
				
				if(html != 'nagawa')
				{
					$('.domain-form').empty();
					$('.domain-form').html('<p style="text-align: center;">Problem occured please contact info@bolooka.com for manual domain creation.</p>');
					//alert('Error Occured!!');
					return false;
				}
				else
				{
					//alert(html);
					$('.domain-form').empty();
					$('.domain-info').removeClass('hidden');
					$('.dom-main').html('www.'+selectDomain);
					return true;
				}
				
			}
		});
	}	
});
</script>
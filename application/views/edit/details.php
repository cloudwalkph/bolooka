<?php
	$queryWeb = $this->db->where('id', $wid);
	$queryWeb = $this->db->get('websites');
	$rowWeb = $queryWeb->row();
?>
<style>
	.head {
		font-size: 14px;
		font-family: Segoe UI Semibold;
		color: #000000;
	}
	label {
		font-size: 12px;
		font-family: Segoe UI Semibold;
	}
	.save_state {
		/* display:none; */
	}
	.edit_state {
		display: none;
	}
	.fileupload-new img.remove, .fileupload-new .icon-remove{
		display:none;
	}
	.fileupload-new .thumbnail:hover img.remove, .fileupload-new .thumbnail:hover .icon-remove{
		display:block;
	}
</style>

<?php
		$form_attrib = array('name' => 'form_detail', 'id' => 'form_detail', 'class' => 'form-horizontal fileupload_form');
		echo form_open_multipart('dashboard/update_page/details', $form_attrib);
?>
		<div class="row-fluid">
			<div class="span6 head" style="font-family: Segoe UI Semibold;">Site Details: </div>
			<div class="span6" style="text-align: right;margin-bottom: 20px;">
				<button class="btn save_state" type="submit"> Save </button>
				<button class="btn edit_state active_action_button" type="button"> Edit </button>
			</div>

				<!-- company name -->
				<div class="control-group">
					<input type="hidden" name="website_id" value="<?php echo $wid ?>" />
					<label class="control-label" for="siteName">Company Name: </label>
					<div class="controls">
						<input type="text" class="span4" id="siteName" name="site_name" placeholder="Company Name" value="<?php echo $rowWeb->site_name; ?>">
					</div>
				</div>
				<!-- url -->
				<div class="control-group">
					<label class="control-label">Site URL:</label>
					<div class="controls">
						<span class="help-inline" style="padding: 5px 0;"><a href="<?php echo base_url() . url_title($rowWeb->url, '-', true); ?>"><?php echo base_url(); ?><strong><?php echo url_title($rowWeb->url, '-', true); ?></strong></a></span><i class="iconic-lock"></i>
					</div>
				</div>
				<!-- type of business -->
				<div class="control-group">
					<label class="control-label" for="">Type of Business: </label>
					<div class="controls">
						<select name="business_type" id="business_type" class="span4">
							<option value="">Select...</option>
<?php 
							$business_category_query = $this->db->query('SELECT * FROM `business_categories`');
							foreach($business_category_query->result_array() as $rowWeb_categ)
							{
?>
							<option value="<?php echo $rowWeb_categ['Category']; ?>" <?php echo $rowWeb->business_type == $rowWeb_categ['Category'] ? "selected=yes" : "" ?>><?php echo $rowWeb_categ['Description']; ?></option>
<?php
							}
?>
						</select>
					</div>
				</div>
				<!-- affiliates -->
				<div class="control-group">
					<label class="control-label" for="">Affiliates: </label>
					<div class="controls">
						<select name="marketgroup" id="marketgroup" title="Choose your group" class="span4">
							<option value="0">Select...</option>
<?php 
							$this->db->where('web_id',$wid);
							$webmarket_query = $this->db->get('web_marketgroup');
							$webRow = $webmarket_query->row_array();
							
							$marketgroup_query = $this->db->get('marketgroup');
							foreach($marketgroup_query->result_array() as $marketgroup_result)
							{
								if($webmarket_query->num_rows() > 0)
								{
?>
							<option <?php echo $webRow['marketgroup_id'] == $marketgroup_result['id'] ? 'selected="selected"' : ''; ?> value="<?php echo $marketgroup_result['id']; ?>"><?php echo $marketgroup_result['name']; ?></option>
<?php
								} else {
?>
							<option value="<?php echo $marketgroup_result['id']; ?>"><?php echo $marketgroup_result['name']; ?></option>
<?php
								}
							}
?>
						</select>
					</div>
				</div>
				<!-- country -->
				<div class="control-group">
					<label class="control-label" for="">Country: </label>
					<div class="controls">
<?php
						$countries = array(
							'' => 'Select...',
							'AF' => 'Afghanistan',
							'AX' => 'ÅLand Islands',
							'AL' => 'Albania',
							'DZ' => 'Algeria',
							'AS' => 'American Samoa',
							'AD' => 'Andorra',
							'AO' => 'Angola',
							'AI' => 'Anguilla',
							'AQ' => 'Antarctica',
							'AG' => 'Antigua And Barbuda',
							'AR' => 'Argentina',
							'AM' => 'Armenia',
							'AW' => 'Aruba',
							'AU' => 'Australia',
							'AT' => 'Austria',
							'AZ' => 'Azerbaijan',
							'BS' => 'Bahamas',
							'BH' => 'Bahrain',
							'BD' => 'Bangladesh',
							'BB' => 'Barbados',
							'BY' => 'Belarus',
							'BE' => 'Belgium',
							'BZ' => 'Belize',
							'BJ' => 'Benin',
							'BM' => 'Bermuda',
							'BT' => 'Bhutan',
							'BO' => 'Bolivia',
							'BA' => 'Bosnia And Herzegovina',
							'BW' => 'Botswana',
							'BV' => 'Bouvet Island',
							'BR' => 'Brazil',
							'OI' => 'British Indian Ocean Territory',
							'BN' => 'Brunei Darussalam',
							'BG' => 'Bulgaria',
							'BF' => 'Burkina Faso',
							'BI' => 'Burundi',
							'KH' => 'Cambodia',
							'CM' => 'Cameroon',
							'CA' => 'Canada',
							'CV' => 'Cape Verde',
							'KY' => 'Cayman Islands',
							'CF' => 'Central African Republic',
							'TD' => 'Chad',
							'CL' => 'Chile',
							'CN' => 'China',
							'CX' => 'Christmas Island',
							'CC' => 'Cocos (Keeling) Islands',
							'CO' => 'Colombia',
							'KM' => 'Comoros',
							'CG' => 'Congo',
							'CD' => 'Congo, The Democratic Republic Of The',
							'CK' => 'Cook Islands',
							'CR' => 'Costa Rica',
							'CI' => 'Cote D&rsquo;Ivoire',
							'HR' => 'Croatia',
							'CU' => 'Cuba',
							'CY' => 'Cyprus',
							'CZ' => 'Czech Republic',
							'DK' => 'Denmark',
							'DJ' => 'Djibouti',
							'DM' => 'Dominica',
							'DO' => 'Dominican Republic',
							'EC' => 'Ecuador',
							'EG' => 'Egypt',
							'SV' => 'El Salvador',
							'GQ' => 'Equatorial Guinea',
							'ER' => 'Eritrea',
							'EE' => 'Estonia',
							'ET' => 'Ethiopia',
							'FX' => 'Falkland Islands (Malvinas)',
							'FO' => 'Faroe Islands',
							'FJ' => 'Fiji',
							'FI' => 'Finland',
							'FR' => 'France',
							'GF' => 'French Guiana',
							'PF' => 'French Polynesia',
							'TF' => 'French Southern Territories',
							'GA' => 'Gabon',
							'GM' => 'Gambia',
							'GE' => 'Georgia',
							'DE' => 'Germany',
							'GH' => 'Ghana',
							'GI' => 'Gibraltar',
							'GR' => 'Greece',
							'GL' => 'Greenland',
							'GD' => 'Grenada',
							'GP' => 'Guadeloupe',
							'GU' => 'Guam',
							'GT' => 'Guatemala',
							'GG' => 'Guernsey',
							'GN' => 'Guinea',
							'GW' => 'Guinea-Bissau',
							'GY' => 'Guyana',
							'HT' => 'Haiti',
							'HM' => 'Heard Island And Mcdonald Islands',
							'VA' => 'Holy See (Vatican City State)',
							'HN' => 'Honduras',
							'HK' => 'Hong Kong',
							'HU' => 'Hungary',
							'IS' => 'Iceland',
							'IN' => 'India',
							'ID' => 'Indonesia',
							'IR' => 'Iran, Islamic Republic Of',
							'IQ' => 'Iraq',
							'IE' => 'Ireland',
							'IM' => 'Isle Of Man',
							'IL' => 'Israel',
							'IT' => 'Italy',
							'JM' => 'Jamaica',
							'JP' => 'Japan',
							'JE' => 'Jersey',
							'JO' => 'Jordan',
							'KZ' => 'Kazakhstan',
							'KE' => 'Kenya',
							'KI' => 'Kiribati',
							'KP' => 'Korea, Democratic People&rsquo;S Republic Of',
							'KR' => 'Korea, Republic Of',
							'KW' => 'Kuwait',
							'KG' => 'Kyrgyzstan',
							'LA' => 'Lao People&rsquo;S Democratic Republic',
							'LV' => 'Latvia',
							'LB' => 'Lebanon',
							'LS' => 'Lesotho',
							'LR' => 'Liberia',
							'LY' => 'Libyan Arab Jamahiriya',
							'LI' => 'Liechtenstein',
							'LT' => 'Lithuania',
							'LU' => 'Luxembourg',
							'MO' => 'Macao',
							'MK' => 'Macedonia, The Former Yugoslav Republic Of',
							'MG' => 'Madagascar',
							'MW' => 'Malawi',
							'MY' => 'Malaysia',
							'MV' => 'Maldives',
							'ML' => 'Mali',
							'MT' => 'Malta',
							'MH' => 'Marshall Islands',
							'MQ' => 'Martinique',
							'MR' => 'Mauritania',
							'MU' => 'Mauritius',
							'YT' => 'Mayotte',
							'MX' => 'Mexico',
							'FM' => 'Micronesia, Federated States Of',
							'MD' => 'Moldova, Republic Of',
							'MC' => 'Monaco',
							'MN' => 'Mongolia',
							'MS' => 'Montserrat',
							'MA' => 'Morocco',
							'MZ' => 'Mozambique',
							'MM' => 'Myanmar',
							'NA' => 'Namibia',
							'NR' => 'Nauru',
							'NP' => 'Nepal',
							'NL' => 'Netherlands',
							'AN' => 'Netherlands Antilles',
							'NC' => 'New Caledonia',
							'NZ' => 'New Zealand',
							'NI' => 'Nicaragua',
							'NE' => 'Niger',
							'NG' => 'Nigeria',
							'NU' => 'Niue',
							'NF' => 'Norfolk Island',
							'MP' => 'Northern Mariana Islands',
							'NO' => 'Norway',
							'OM' => 'Oman',
							'PK' => 'Pakistan',
							'PW' => 'Palau',
							'PS' => 'Palestinian Territory, Occupied',
							'PA' => 'Panama',
							'PG' => 'Papua New Guinea',
							'PY' => 'Paraguay',
							'PE' => 'Peru',
							'PH' => 'Philippines',
							'PN' => 'Pitcairn',
							'PL' => 'Poland',
							'PT' => 'Portugal',
							'PR' => 'Puerto Rico',
							'QA' => 'Qatar',
							'RE' => 'Reunion',
							'RO' => 'Romania',
							'RU' => 'Russian Federation',
							'RW' => 'Rwanda',
							'SH' => 'Saint Helena',
							'KN' => 'Saint Kitts And Nevis',
							'LC' => 'Saint Lucia',
							'PM' => 'Saint Pierre And Miquelon',
							'VC' => 'Saint Vincent And The Grenadines',
							'WS' => 'Samoa',
							'SM' => 'San Marino',
							'ST' => 'Sao Tome And Principe',
							'SA' => 'Saudi Arabia',
							'SN' => 'Senegal',
							'CS' => 'Serbia And Montenegro',
							'SC' => 'Seychelles',
							'SL' => 'Sierra Leone',
							'SG' => 'Singapore',
							'SK' => 'Slovakia',
							'SI' => 'Slovenia',
							'SB' => 'Solomon Islands',
							'SO' => 'Somalia',
							'ZA' => 'South Africa',
							'GS' => 'South Georgia And The South Sandwich Islands',
							'ES' => 'Spain',
							'LK' => 'Sri Lanka',
							'SD' => 'Sudan',
							'SR' => 'Suriname',
							'SJ' => 'Svalbard And Jan Mayen',
							'SZ' => 'Swaziland',
							'SE' => 'Sweden',
							'CH' => 'Switzerland',
							'SY' => 'Syrian Arab Republic',
							'TW' => 'Taiwan, Province Of China',
							'TJ' => 'Tajikistan',
							'TZ' => 'Tanzania, United Republic Of',
							'TH' => 'Thailand',
							'TL' => 'Timor-Leste',
							'TG' => 'Togo',
							'TK' => 'Tokelau',
							'TO' => 'Tonga',
							'TT' => 'Trinidad And Tobago',
							'TN' => 'Tunisia',
							'TR' => 'Turkey',
							'TM' => 'Turkmenistan',
							'TC' => 'Turks And Caicos Islands',
							'TV' => 'Tuvalu',
							'UG' => 'Uganda',
							'UA' => 'Ukraine',
							'AE' => 'United Arab Emirates',
							'GB' => 'United Kingdom',
							'US' => 'United States',
							'UM' => 'United States Minor Outlying Islands',
							'UY' => 'Uruguay',
							'UZ' => 'Uzbekistan',
							'VU' => 'Vanuatu',
							'VE' => 'Venezuela',
							'VN' => 'Viet Nam',
							'VG' => 'Virgin Islands, British',
							'VI' => 'Virgin Islands, U.S.',
							'WF' => 'Wallis And Futuna',
							'EH' => 'Western Sahara',
							'YE' => 'Yemen',
							'ZM' => 'Zambia',
							'ZW' => 'Zimbabwe'
						);
						echo form_dropdown('country', $countries, $rowWeb->country, 'id="country" class="span4"');
?>
					</div>
				</div>				
				<!-- business description -->
				<div class="control-group">
					<label class="control-label" for="">Business Description: </label>
					<div class="controls">
						<textarea rows="6" name="description" class="span8" style="font-size: 12px;font-family: Segoe UI Semibold;"><?php echo $rowWeb->description; ?></textarea>
					</div>
				</div>					
				<!-- date created -->
				<div class="control-group">
					<label class="control-label" for="">Date Created: </label>
					<div class="controls">
						<span class="help-inline" style="padding: 5px 0;"><?php echo isset($rowWeb->date_created) && $rowWeb->date_created != 0 ? date('M d, Y', $rowWeb->date_created) : '<i>Unavailable</i>'; ?></span>
					</div>
				</div>
		</div>
	<?php //echo form_close(); ?>
		<hr>
<?php 
		$this->db->where('website_id', $wid);
		$web_logo = $this->db->get('logo');
		$logo = $web_logo->row_array();
		
		$imglogo = "http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image";
		$img = 'uploads/'.$wid.'/'.$logo['image'];
		if($this->photo_model->image_exists($img)) {
			$imglogo = base_url($img);
		} else {
			$img = 'uploads/'.$logo['image'];
			if($this->photo_model->image_exists($img)) {
				$imglogo = base_url($img);
			}
		}
?>	
			<!-- Logo / Favicon - section (kinoment ko yung form ng logo para maging isang form na lang sya sa detial pati sa dashboard/update_page controller my comment din dun)-->
<?php
			// $form_attrib = array('name' => 'form_logofav', 'id' => 'form_logofav', 'class' => 'form-horizontal fileupload_form');
			// echo form_open_multipart('dashboard/update_page/logofav', $form_attrib);
?>	
		<div class="row-fluid">

			<div class="span6 head">Logo / Favicon</div><div class="span6" style="text-align: right;margin-bottom: 20px;">
				<button class="btn" type="submit"> Save </button>
			</div>
			<div class="control-group">
				<input type="hidden" name="website_id" value="<?php echo $wid ?>" />
				<label class="control-label" for="">Upload Logo: </label>
				<div class="controls">
					<div class="fileupload fileupload-new" data-provides="fileupload">						
						<div class="fileupload-new thumbnail" style="max-width: 200px; max-height: 150px;position:relative;">						
							<img src="<?php echo $imglogo; ?>" />
							<?php
							if($logo['image']){
							?>
								<span style="position: absolute;top: 0;right: 0;">
									<a href="#modal_delete" role="button" data-toggle="modal">
										<img class="remove" id="rem-logo" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete Logo" src="<?php echo base_url(); ?>img/close_button.png" />
									</a>
								</span>
							<?php
								}
							?>	
						</div>
						<div id="logo-preview" class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px;"></div>										
						<div>
							<span class="btn btn-file fileinput-button">
								<span class="fileupload-new">Select image</span>
								<span class="fileupload-exists">Change</span>
								<input type="file" name="logo" id="logoupload" class="fileinput-button" accept="image/*" />
							</span>							
							<a type="button" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>							
						</div>
					</div>
					<span class="help-block muted">Up to 4MB only. (Use *.PNG file to have transparent background.)</span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="nologo">Disable Logo: </label>
				<div class="controls">
					<label class="radio inline">
						<input type="radio" name="nologo" value="1" <?php echo $logo['nologo']==1 || $logo['nologo']=='on' ? 'checked' : ''; ?>>
						Yes
					</label>
					<label class="radio inline">
						<input type="radio" name="nologo" value="0" <?php echo $logo['nologo']==0 || $logo['nologo']=='off' ? 'checked' : ''; ?>>
						No
					</label>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="logosize">Logo Size: </label>
				<div class="controls">
					<label class="radio inline">
						<input type="radio" name="logosize" value="0" <?php echo $logo['logosize']==0 || $logo['logosize']=='off' ? 'checked' : ''; ?>>
						Small
					</label>
					<label class="radio inline">
						<input type="radio" name="logosize" value="1" <?php echo $logo['logosize']==1 || $logo['logosize']=='on' ? 'checked' : ''; ?>>
						Medium
					</label>
					<label class="radio inline">
						<input type="radio" name="logosize" value="2" <?php echo $logo['logosize']==2 || $logo['logosize']=='on' ? 'checked' : ''; ?>>
						Large
					</label>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="">Select Position: </label>
				<div class="controls">
					<label class="radio inline">
						<input type="radio" <?php echo $logo['position'] == 'left' ? 'checked' : '' ?> name="position" value="left"> Left
					</label>
					<label class="radio inline">
						<input type="radio" <?php echo $logo['position'] == 'center' ? 'checked' : '' ?> name="position" value="center"> Center
					</label>
					<label class="radio inline">
						<input type="radio" <?php echo $logo['position'] == 'right' ? 'checked' : '' ?> name="position" value="right"> Right
					</label>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="">Set Color: </label>
				<div class="controls">
					<input type="text" value="<?php echo $logo['color']; ?>" class="span3 color-picker" name="color">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="">Favicon: </label>
				<div class="controls">
					<div class="fileupload fileupload-new" data-provides="fileupload">
						<div class="fileupload-new thumbnail" style="max-width: 50px; max-height: 50px;position:relative;" >
							<img src="<?php echo $rowWeb->favicon ? base_url().'uploads/'. str_replace('uploads/', '',$rowWeb->favicon) : 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image'; ?>">
							<?php
							if($rowWeb->favicon){
							?>
								<span style="position: absolute;top: -3px;right: -1px;">
									<a href="#modal_delete_fav" role="button" data-toggle="modal">
										<i id="rem-logo" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete Favicon" class="icon-remove" style="background-color: white;"></i>
									</a>
								</span>
							<?php
								}
							?>	
						</div>
						<div id="favicon-preview" style="max-width: 50px; max-height: 50px;" class="fileupload-preview fileupload-exists thumbnail">
						</div>										
						<div>
							<span class="btn btn-file fileinput-button">
								<span class="fileupload-new">Select image</span>
								<span class="fileupload-exists">Change</span>
								<input type="file" name="favicon" id="favupload" accept="image/*">
							</span>
							<a type="button" class="btn fileupload-exists" data-dismiss="fileupload" style="float:left; margin-right: 4px">Remove</a>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	echo form_close();
?>
<!-- Modal Delete-->
	<div id="modal_delete" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
		<div class="modal-body" style="background-color: #e34e0d;color: #fff;">
			<form method="post" action="<?php echo base_url().'test/deletelogo'; ?>">
				<p>Are you sure you want to delete your logo?</p>
				<input class="logo_id" name="logo_id" type="hidden" value="<?php echo $logo['website_id']; ?>">
				<p class="pull-right">
					<button id="dwyes" class="btn btn_color" type="submit" style="font-weight: bold;">YES</button>
					<button id="dwno" class="btn btn_color" data-dismiss="modal" aria-hidden="true" type="button" style="font-weight: bold;">NO</button>
				</p>
			</form>
		</div>
	</div>
	<div id="modal_delete_fav" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
		<div class="modal-body" style="background-color: #e34e0d;color: #fff;">
			<form method="post" action="<?php echo base_url().'test/deletefav'; ?>">
				<p>Are you sure you want to delete your favicon?</p>
				<input class="web_id" name="web_id" type="hidden" value="<?php echo $rowWeb->id; ?>">
				<p class="pull-right">
					<button id="dwyes" class="btn btn_color" type="submit" style="font-weight: bold;">YES</button>
					<button id="dwno" class="btn btn_color" data-dismiss="modal" aria-hidden="true" type="button" style="font-weight: bold;">NO</button>
				</p>
			</form>
		</div>
	</div>
<script>
	$(function() {
		$('#rem-logo').tooltip();
		$('#details').delegate('.edit_state', 'click',function(){
			$('input, select, textarea').removeAttr('disabled');
			$('#siteName').focus();
			$(this).hide();
			$('.save_state').show();
		});
	});
</script>

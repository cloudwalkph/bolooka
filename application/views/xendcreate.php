<?php
$exceptionFlag = false;
// initialize SOAP client
$wsdl = 'https://www.xend.com.ph/api/ShipmentService.asmx?WSDL';
$client = new soapclient($wsdl, array());
$funcs = $client->__getFunctions();
// initialize SOAP header
$headerbody = array('UserToken' => '495627EA-6C8A-440E-B158-8B70511FD569'); // usertoken
// $headerbody = array('UserToken' => 'E49E3066-401E-4A83-8F3C-CF05A7EAE053');//developer id
$header = new SOAPHeader('https://www.xend.com.ph/api/', 'AuthHeader', $headerbody);
$client->__setSoapHeaders($header);
$time = time();
// shipment parameters
$param = array(
	'WayBillNo' => '',
	'ServiceTypeValue' => $xendservice,
	'ShipmentTypeValue' => 'Parcel',
	'PurposeOfExportValue' => 'Other',
	'Description' => $description,
	'ClientReference' => '',
	'SpecialInstructions' => '',
	'CountryManufactured' => '',
	'Weight' => 0.50,
	'DimensionL' => 0.00,
	'DimensionW' => 0.00,
	'DimensionH' => 0.00,
	'DeclaredValue' => 0.00,
	'Status' => '',
	'DateCreated' => time(),
	'DatePrinted' => time(),
	'RecipientName' => $fname.' '.$lname,
	'RecipientCompanyName' => '',
	'RecipientAddress1' => $address1,
	'RecipientAddress2' => $address2,
	'RecipientCity' => $city,
	'RecipientProvince' => 'none',
	'RecipientPostalCode' => $postal,
	'RecipientCountry' => $country,
	'RecipientPhoneNo' => $telephone,
	'RecipientEmailAddress' => $email,
	'ShippingFee' => 300.00,
	'InsuranceFee' => 0.00,
	'IsInsured' => 0
);

 try
{
	$result = $client->Create(array('shipment' => $param));
}
catch (SoapFault $soapfault)
{
	$exceptionFlag = true;
	$exception = $soapfault->getMessage();
	preg_match_all('/: (.*?). at/s', $exception, $error, PREG_SET_ORDER);
	echo $error[0][1];
}
if(!$exceptionFlag)
{
	echo $result->CreateResult;
}

?>
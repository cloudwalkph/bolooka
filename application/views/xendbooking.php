<?php
$exceptionFlag = false;
// initialize SOAP client
$wsdl = 'https://www.xend.com.ph/api/BookingService.asmx?WSDL';
$client = new soapclient($wsdl, array());
$funcs = $client->__getFunctions();
// initialize SOAP header
// $headerbody = array('UserToken' => '495627EA-6C8A-440E-B158-8B70511FD569'); // usertoken
$headerbody = array('UserToken' => 'E49E3066-401E-4A83-8F3C-CF05A7EAE053');//developer id
$header = new SOAPHeader('https://www.xend.com.ph/api/', 'AuthHeader', $headerbody);
$client->__setSoapHeaders($header);
$time = time();
// shipment parameters

//booking parameters
$param2 = array(
	'BookingDate' => $bookdate,
	'Remarks' => 'TEST ONLY-NO PICKUP',
	'FirstName' => $bookfname,
	'LastName' => $booklname,
	'Street1' => $bookadd1,
	'Street2' => $bookadd2,
	'City' => $bookcity,
	'Province' => $bookprov,
	'PostalCode' => $bookpostal,
	'Landmark' => $bookland
);
// execute SOAP method

 try
{
	$result = $client->ScheduleDev($param2);
}
catch (SoapFault $soapfault)
{
	$exceptionFlag = true;
	$exception = $soapfault->getMessage();
	preg_match_all('/: (.*?). at/s', $exception, $error, PREG_SET_ORDER);
	print_r($error);
}
if(!$exceptionFlag)
{
	echo $result->ScheduleDevResult;
}

?>
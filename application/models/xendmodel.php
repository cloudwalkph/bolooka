<?php
	class Xendmodel extends CI_Model 
	{
		function booking()
		{
			$exceptionFlag = false;
			$wsdl = 'https://www.xend.com.ph/api/BookingService.asmx?WSDL';
			
			$client = new soapclient($wsdl, array());
			$funcs = $client->__getFunctions();
			
			$headerbody = array('UserToken' => 'E49E3066-401E-4A83-8F3C-CF05A7EAE053');//developer id
			$header = new SOAPHeader('https://www.xend.com.ph/api/', 'AuthHeader', $headerbody);
			$client->__setSoapHeaders($header);
			$time = time();
			
			//booking parameters
			$param = array(
				'BookingDate' => date('Y-m-d\TH\:i\:s\.u', strtotime('1/12/2013')),
				'Remarks' => 'TEST ONLY-NO PICKUP',
				'FirstName' => 'Juan',
				'LastName' => 'Dela Cruz',
				'Street1' => 'Malvar St. Ts Cruz',
				'Street2' => '',
				'City' => 'Quezon City',
				'Province' => 'Camarines Sur',
				'PostalCode' => '12345',
				'Landmark' => 'testing'
			);
			
			try
			{
				$result = $client->ScheduleDev($param);
			}
			
			catch (SoapFault $soapfault)
			{
					$exceptionFlag = true;
					$exception = $soapfault->getMessage();
					preg_match_all('/: (.*?). at/s', $exception, $error, PREG_SET_ORDER);
					return $error[0][1];
			}
			
			if(!$exceptionFlag)
			{
				return $result->ScheduleDevResult;
			}
		}
		
		function create()
		{
			$exceptionFlag = false;
			$wsdl = 'https://www.xend.com.ph/api/ShipmentService.asmx?WSDL';
			
			$client = new soapclient($wsdl, array());
			$funcs = $client->__getFunctions();
			// initialize SOAP header
			$headerbody = array('UserToken' => '495627EA-6C8A-440E-B158-8B70511FD569'); // usertoken
			// $headerbody = array('UserToken' => 'E49E3066-401E-4A83-8F3C-CF05A7EAE053');//developer id
			$header = new SOAPHeader('https://www.xend.com.ph/api/', 'AuthHeader', $headerbody);
			$client->__setSoapHeaders($header);
			$time = time();
			
			$param = array(
				'WayBillNo' => '',
				'ServiceTypeValue' => 'MetroManilaExpress',
				'ShipmentTypeValue' => 'Parcel',
				'PurposeOfExportValue' => 'Other',
				'Description' => 'testing only',
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
				'RecipientName' => 'Pedro Penduko',
				'RecipientCompanyName' => '',
				'RecipientAddress1' => 'Malvar St. TS Cruz',
				'RecipientAddress2' => 'Novaliches',
				'RecipientCity' => 'Quezon City',
				'RecipientProvince' => 'Metro Manila',
				'RecipientPostalCode' => '12345',
				'RecipientCountry' => 'Philippines',
				'RecipientPhoneNo' => '09124329913',
				'RecipientEmailAddress' => 'hbg_009@ymail.com',
				'ShippingFee' => 0.00,
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
				return $error[0][1];
			}
			
			if(!$exceptionFlag)
			{
				return $result->CreateResult;
			}
		}
	}	
?>
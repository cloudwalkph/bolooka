<?php



	$uploaddir = dirname($_SERVER['SCRIPT_FILENAME'])."/uploads/";
	$useid = $this->session->userdata('uid');
	$time = time();

	/* if(isset($_REQUEST['wids2']))
	{ */
		//echo 'wid='.$_GET['wid'].'album='.$_GET['albumid'];
		$webdi = $this->session->userdata('wids2');
		$albumid = $this->session->userdata('albumids2');
	/* } */

/*-------------------------------------------------------------------------

* First part of this script is for regular upload method (RFC based) 

*/

if(!isset($_REQUEST['chunkedUpload']))

{

	

	function get_extension($file_name){

    $ext = explode('.', $file_name);

    $ext = array_pop($ext);

    return strtolower($ext);

	}

	

	function exit_status($str){

    echo $str;

    exit;

	}

	if(count($_FILES) > 0)

	{

		$arrfile = pos($_FILES);

		$filenameto = basename($arrfile['name']);

		/* $filenameto = str_replace(" ","_",$filenameto);

		$uploadfile = $uploaddir . $filenameto; */

		$allowed_ext = array('jpg','jpeg','png','gif');

		$findExtension = get_extension(basename($arrfile['name']));

		if(!in_array($findExtension,$allowed_ext)){

        exit_status('Only '.implode(',',$allowed_ext).' files are allowed!');

		}

			//echo "INSERT INTO gallery (web_id, albums, created)VALUES('$webdi','$albumid','$time')";
			
		 $get_newpic = $this->db->query("INSERT INTO gallery (web_id, albums, created) VALUES ('$webdi','$albumid','$time')");
		$slectpic = $this->db->insert_id();

		if($findExtension == 'png')
		{
			$newname = $slectpic.'.png';
		}
		else
		{
			 $newname = $slectpic.'.jpg';
		}
		 
		

		$uploadfile = $uploaddir.$newname;

		if (move_uploaded_file($arrfile['tmp_name'], $uploadfile))

		echo "File " . basename($arrfile['name']) . " was successfully uploaded.";
		$this->db->query("UPDATE gallery SET image='$newname' WHERE id='$slectpic'");
		$rtime = time();

	 	//$this->db->query("INSERT INTO `shop` (`gallery_id`, `album_id`, `website_id`, `time`) VALUES('$slectpic','$albumid','$webdi','$rtime')"); 
		 /* $this->db->query("UPDATE `albums` SET `primary`='$slectpic' WHERE `id`='$albumid'  AND `primary`= '' ");  */
	}
	//echo 'haha'.count($_FILES).'hoho';



	echo '<br>'; // At least one symbol should be sent to response!!!

}

/*-------------------------------------------------------------------------

* The second part is for chunked upload method used by silverlight uploader

*/

else

{

	error_reporting(E_ERROR);

	set_error_handler ('err_handler');



	$filename = isset($_GET["FileName"]) ? str_replace("../", "", $_GET["FileName"]) : "";

	$complete = isset($_GET["Complete"]) ? strtolower($_GET["Complete"]) == "true" ? true : false : true;

	$querySize = isset($_GET["QuerySize"]) ? strtolower($_GET["QuerySize"]) == "true" ? true : false : false;

	$startByte = isset($_GET["StartByte"]) ? (int)$_GET["StartByte"] : 0;

	$comment = isset($_GET["Comment"]) ? $_GET["Comment"] : "";

	$tag = isset($_GET["Tag"]) ? $_GET["Tag"] : "";

	$isMultiPart = isset($_GET["isMultiPart"]) ? $_GET["isMultiPart"] == "true" : false;

	$dirPath = $uploaddir;



	$filePath = $dirPath . "/" . $filename;





	if ($querySize)

	{

		if (file_exists($dirPath) && is_dir($dirPath))

		{

			if (file_exists($filePath))

			{

				print filesize($filePath);

			}

			else

				print "0";

		}

		else print "The path for file storage not found on the server.";

	}

	else

	{

		//if mulltipart mode and there is no file form field in request , then write error

		if($isMultiPart && count($_FILES) <= 0)

		{

			echo "Error: No chunk for save.";	

			exit;

		}

		if ($startByte > 0 && file_exists($filePath))

		{

			$isCreate = false;

			$file = fopen($filePath, "a");

		}

		else

		{

			$isCreate = true;

			$file = fopen($filePath, "w");

		}

			

		if (!is_writable($filePath))

		{

			print "Error: cannot write to the specified directory.";

			exit;

		}

			

		//logic to read and save chunk posted with multipart

		//Multipart allow us to send form data in request body

		if($isMultiPart)

		{

			$filearr = pos($_FILES);		

			if(!$input = file_get_contents($filearr['tmp_name']))

			{

				echo "Error: Can't read from file.";

				exit;

			}

		}

		//raw data

		else

			$input = file_get_contents("php://input");

		if(!fwrite($file, $input)) 

			echo "Error: Can't write to file.";

		if($file)

			fclose($file);

			

		if ($complete)

		{

			

			echo "File " . basename($filePath) . " was successfully uploaded.<br/>";

			// Place here the code making postprocessing of the uploaded file (moving to other location, database, etc).

		}

		else

		{

			if ($isCreate) print "Creating file..." ;

			else print "Write chunk since byte " . $startByte;

		}

	}



	function err_handler ($errno, $errstr, $errfile, $errline)

	{

		print "Write error: " . $errstr;

	}

}



?> 
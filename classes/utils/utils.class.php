<?php

class Utils extends Object {

	private static $aInstance = NULL;

	public static function &getInstance() {

		if (empty(self::$aInstance)) {
			self::$aInstance = new self;
		}
		return self::$aInstance;
	}

	function deleteDir($path) {

		if (!is_dir( $path )) {
			return false;
		}

		@chmod($path,0777);
		$directory = dir($path);
		
		while(($entry = $directory->read()) !== false) { 
			
			if ($entry != "." && $entry != "..") { 
				
				if (is_dir($path."/".$entry)) { 
					deleteDir($path."/".$entry); 
				} else { 
					@chmod($path."/".$entry,0777);
					@UnLink ($path."/".$entry); 
				}
			} 
		} 
		
		$directory->close(); 
		@rmdir($path);

		return true;
	}

	function readDir( $dir ) {

		$temArr = array();

		if ($handle = opendir($dir)) { 
			while (false !== ($file = readdir($handle))) { 

					if ($file != "." && $file != "..") {
						array_push($temArr, array("file_name"=>$file));				
					} 
			} 
			closedir($handle); 

			return $temArr;
		}  else {

			return false;
		}
	}

	public static function goURL( $url, $delay=0) {

		echo ("<meta http-equiv='Refresh' content='". $delay . "; URL=" . $url . "'>");
	}
}
?>
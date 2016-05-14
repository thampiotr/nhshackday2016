<?php

		function debugLog($msg) {
			if (isset($GLOBALS['debugLogging']) && $GLOBALS['debugLogging']) {
				echo 'DEBUG: '.$msg.'<br>';
			}
		}

 		function endsWith($haystack, $needle) {
                // Horrible but that's apparently the way to do it in PHP...
                return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
        }       

        function getRequestKey($condition, $intervention, $outcome) {
        		$combinedKey = $condition.$intervention.$outcome;
    			if (empty(trim($condition)) || empty(trim($intervention)) || empty(trim($outcome))) {
    				header("HTTP/1.1 500 Internal Server Error");
    				throw new Exception("All parameters need to be provided and non-empty", 1);    				
    			}
                return md5($combinedKey);
        }

        function getCacheTmpPath($name) {
                return sys_get_temp_dir().DIRECTORY_SEPARATOR.'nhshackday'.DIRECTORY_SEPARATOR.$name. DIRECTORY_SEPARATOR;
        }

        function downladAndUnzip($url, $pathToDownladDirectory) {
                debugLog('url: '.$url);          
                $zipFileName = 'tmp.zip';
                $test_response = file_get_contents($url);      
                mkdir($pathToDownladDirectory, 0777, true);
                file_put_contents($pathToDownladDirectory.$zipFileName, $test_response);
                $zip = new ZipArchive();
                $unzip_successful = $zip->open($pathToDownladDirectory.$zipFileName);
                 if($unzip_successful === TRUE) {
                     $zip->extractTo($pathToDownladDirectory);
                     $zip->close();
                 } else {
                     header("HTTP/1.1 500 Internal Server Error");              
                     throw new Exception('Could not unzip file '.$pathToDownladDirectory.$zipFileName);    
                 }
        }

        function readAllXMLsFromDirectory($pathToDownladDirectory) {
                $allXMLs = array();
                $files = scandir($pathToDownladDirectory);
                foreach ($files as $file) {
                        if (endsWith($file, '.xml')) {
                                $xmlContent = new SimpleXMLElement(file_get_contents($pathToDownladDirectory.$file));
                                array_push($allXMLs, $xmlContent);
                        }
                }
                return $allXMLs;
        }

        function buildRequestURL($condition, $intervention, $outcome) {
                  return 'https://clinicaltrials.gov/ct2/results/download?down_stds=all&down_typ=results'.
                        '&down_flds=shown&down_fmt=plain&term='
                        .urlencode($condition) //Condition
                        .'&rslt=With&intr='
                        .urlencode($intervention) //Intervention
                        .'&outc='
                        .urlencode($outcome) //Outcome
                        .'&show_down=Y';
        }

        function getData($condition, $intervention, $outcome) {
                $cacheKey = getRequestKey($condition, $intervention, $outcome);
                debugLog('cacheKey: '.$cacheKey);
                $cachePath = getCacheTmpPath($cacheKey);
                debugLog('cachePath: '.$cachePath);
                $allXMLs = array();
                if (!file_exists($cachePath)) { 
                	debugLog('Cache MISS');                   
                    downladAndUnzip(buildRequestURL($condition, $intervention, $outcome), $cachePath);
                    $allXMLs = readAllXMLsFromDirectory($cachePath);
                } else {
                	debugLog('Cache HIT');                   
                }
                return readAllXMLsFromDirectory($cachePath);            
        }

        function analyze($allXMLs, $condition, $intervention, $outcome) {
        	 //Integration with Andrew's Code Here
            //First we take the array of XML objects and run the main parsing function
            $output_array = array();

            //echo "<pre>";print_r($allXMLs);echo "</pre>";
            foreach ($allXMLs as $key=>$xmlObject)
            {
               array_push($output_array,trialParser($xmlObject, $outcome));
            }

            return json_encode($output_array, JSON_PRETTY_PRINT);
        }


?>
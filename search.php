<html>
<h1>Search results</h1>
Search terms:
<ul>
	<li>Condition: </li>
        <?php
        if(isset($_POST['condition'])) {
                echo $_POST['condition'];
                $condition = $_POST['condition'];
        } else {
                $condition = "";
        }
        ?>
	<li>Intervention: </li>
        <?php
        if(isset($_POST['intervention'])) {
                echo $_POST['intervention'];
                $intervention = $_POST['intervention'];
        } else {
                $intervention = "";
        }
        ?>
	<li>Outcome: </li>
        <?php
        if(isset($_POST['outcome'])) {
                echo $_POST['outcome'];
                $outcome = $_POST['outcome'];
        } else {
                $outcome = "";
        }
        ?>
</ul>
<?php
        function endsWith($haystack, $needle) {
                // Horrible but that's apparently the way to do it in PHP...
                return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
        }       

        function getRequestKey($condition, $intervention, $outcome) {
                return md5($condition.$intervention.$outcome);
        }

        function getCacheTmpPath($name) {
                return sys_get_temp_dir().DIRECTORY_SEPARATOR.'nhshackday'.DIRECTORY_SEPARATOR.$name. DIRECTORY_SEPARATOR;
        }

        function downladAndUnzip($url, $pathToDownladDirectory) {
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

        $cacheKey = getRequestKey('condition', 'intervention', 'outcome');
        $cachePath = getCacheTmpPath($cacheKey);
        $allXMLs = array();
        if (!file_exists($cachePath)) {
                echo "<h2>Cache MISS - downloading ZIP</h2>";                
                downladAndUnzip(buildRequestURL($condition, $intervention, $outcome), $cachePath);
                $allXMLs = readAllXMLsFromDirectory($cachePath);
        } else {
                echo "<h2>Cache HIT - Reading from hard drive</h2>";                
        }

        $allXMLs = readAllXMLsFromDirectory($cachePath);        

        echo "<br>XMLs:<pre> Size: ".sizeof($allXMLs).'<br>';
        print_r($allXMLs);
        echo "</pre>";

	//$response = file_get_contents('https://clinicaltrials.gov/show/NCT00001372?displayxml=true');
	//$response = new SimpleXMLElement($response);
	//print_r($response->asXML())       
        echo "Test request key " . $cacheKey . '<br>';
        echo "Tmp cache path " . getCacheTmpPath($cacheKey) . '<br>';

?>
</html>

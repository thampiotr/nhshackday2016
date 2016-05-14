<html>
<h1>Hello NHS Hack Day</h1>
<?php
// Test scraping
 $test_response = file_get_contents('https://clinicaltrials.gov/search?cond=brain+fever&studyxml=true');
 file_put_contents('downloaded_queries/tmp.zip', $test_response);

 $zip = new ZipArchive();
 $unzip_successful = $zip->open('downloaded_queries/tmp.zip');
 if($unzip_successful === TRUE) {
     $zip->extractTo('downloaded_xml/');
     $zip->close();
 } else {
     echo "could not unzip";
 }
 //$test_xml = new SimpleXMLElement($test_response);


 echo "test php";
 //echo $test_xml;
?>
</html>

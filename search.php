<?php
include('common.php');
include('functions.php');

if(isset($_POST['condition'])) {    
    $condition = $_POST['condition'];
} else {
    $condition = "";
}

if(isset($_POST['intervention'])) {
        $intervention = $_POST['intervention'];
} else {
        $intervention = "";
}

if(isset($_POST['outcome'])) {        
        $outcome = $_POST['outcome'];
} else {
        $outcome = "";
}

?>
<html>
<h1>Search results</h1>
Search terms:
<ul>
	<li>Condition: </li>
        <?php
                echo $condition;
        ?>
	<li>Intervention: </li>
        <?php
                echo $intervention;
        ?>
	<li>Outcome: </li>
        <?php
                echo $outcome;
        ?>
</ul>
<?php
       
       $GLOBALS['debugLogging'] = true;

       debugLog('Condition: '.$condition);
       debugLog('Intervention: '.$intervention);
       debugLog('Outcome: '.$outcome);

        $allXMLs = getData($condition, $intervention, $outcome);
        $result = analyze($allXMLs, $condition, $intervention, $outcome);
        echo $result;
        /*echo "<br>XMLs:<pre> Size: ".sizeof($allXMLs).'<br>';
        print_r($result);
        echo "</pre>";*/

	//$response = file_exists(filename)get_contents('https://clinicaltrials.gov/show/NCT00001372?displayxml=true');
	//$response = new SimpleXMLElement($response);
	//print_r($response->asXML())       
        // echo "Test request key " . $cacheKey . '<br>';
        // echo "Tmp cache path " . getCacheTmpPath($cacheKey) . '<br>';

?>
</html>

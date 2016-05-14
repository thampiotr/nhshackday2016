<?php
include('common.php');

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
       

        $allXMLs = getData($condition, $intervention, $outcome);

        echo "<br>XMLs:<pre> Size: ".sizeof($allXMLs).'<br>';
        print_r(json_encode($allXMLs));
        echo "</pre>";

	//$response = file_get_contents('https://clinicaltrials.gov/show/NCT00001372?displayxml=true');
	//$response = new SimpleXMLElement($response);
	//print_r($response->asXML())       
        // echo "Test request key " . $cacheKey . '<br>';
        // echo "Tmp cache path " . getCacheTmpPath($cacheKey) . '<br>';

?>
</html>

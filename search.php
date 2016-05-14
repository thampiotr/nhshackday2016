<?php
include('unzip_query.php');
?>
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
	$response = perform_query($condition, $intervention, $outcome);
	//$response = new SimpleXMLElement($response);
	//print_r($response->asXML());
        echo "response is: " . $response;
?>
</html>

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
<h1>Contents of NCT00001372</h1>
<pre>
<?php
	$url = 'https://clinicaltrials.gov/ct2/results/download?down_stds=all&down_typ=results'.
	'&down_flds=shown&down_fmt=plain&term='
	.urlencode($condition) //Condition
	.'&rslt=With&intr='
	.urlencode($intervention) //Intervention
	.'&outc='
	.urlencode($outcome) //Outcome
	.'&show_down=Y';

	//$response = file_get_contents('https://clinicaltrials.gov/show/NCT00001372?displayxml=true');
	//$response = new SimpleXMLElement($response);
	//print_r($response->asXML())
        echo "url is " . $url;
?>

</pre>
</html>

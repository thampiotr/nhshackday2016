<html>
<h1>Search results</h1>
Search terms:
<ul>
	<li>Search term: </li>
	<li>Condition: </li>
	<li>Outcome: </li>
</ul>
<h1>Contents of NCT00001372</h1>
<pre>
<?php

	$url = 'https://clinicaltrials.gov/ct2/results/download?down_stds=all&down_typ=results'+
	'&down_flds=shown&down_fmt=plain&term='
	+'atrial+fibrillation' //Search term
	+'&rslt=With&intr='
	+'warfarin%2C+apixaban' //Intervention
	+'&outc='
	+'bleeding' //Outcome
	+'&show_down=Y';

	$response = file_get_contents('https://clinicaltrials.gov/show/NCT00001372?displayxml=true');
	$response = new SimpleXMLElement($response);
	print_r($response->asXML())
?>

</pre>
</html>
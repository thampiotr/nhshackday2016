<html>
<h1>Search results</h1>

<h1>Contents of NCT00001372</h1>
<pre>
<?php
	$response = file_get_contents('https://clinicaltrials.gov/show/NCT00001372?displayxml=true');
	$response = new SimpleXMLElement($response);
	print_r($response->asXML())
?>

</pre>
</html>
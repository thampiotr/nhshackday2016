<html>
<h1>Hello NHS Hack Day</h1>

<form action='search.php' method='post'>
  Condition:<br>
  <input type="text" name="condition"><br>
  Intervention:<br>
  <input type="text" name="intervention"><br>
  Outcome:<br>
  <input type="text" name="outcome"><br>
  <input type="submit" value="Search">
</form>

<pre>
<?php
	//$response = file_get_contents('https://clinicaltrials.gov/show/NCT00001372?displayxml=true');
	// print_r($response);
?>
</pre>
</html>

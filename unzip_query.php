<?php
function scrape_results($url) {
 $test_response = file_get_contents($url);
 file_put_contents('downloaded_queries/tmp.zip', $test_response);

 $zip = new ZipArchive();
 $unzip_successful = $zip->open('downloaded_queries/tmp.zip');
 if($unzip_successful === TRUE) {
     $zip->extractTo('downloaded_xml/');
     $zip->close();
 } else {
     die("could not unzip");
 }
}

function build_url($condition, $intervention, $outcome) {
	$url = 'https://clinicaltrials.gov/ct2/results/download?down_stds=all&down_typ=results'.
	'&down_flds=shown&down_fmt=plain&term='
	.urlencode($condition) //Condition
	.'&rslt=With&intr='
	.urlencode($intervention) //Intervention
	.'&outc='
	.urlencode($outcome) //Outcome
	.'&show_down=Y';

        return $url;
}

function perform_query($condition, $intervention, $outcome) {
    // If the query is cached, don't search again.
    $cached = false;

    if($cached) {
        // Results already exist.
    } else {
        $url = build_url($condition, $intervention, $outcome);
        scrape_results($url);
    }
}
?>
</html>

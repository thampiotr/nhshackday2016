<?php
include('common.php');
include('functions.php');
?>
<?php

        $GLOBALS['debugLogging'] = false;

        if(isset($_GET['condition'])) {    
            $condition = $_GET['condition'];
        } else {
            $condition = "";
        }

        if(isset($_GET['intervention'])) {
                $intervention = $_GET['intervention'];
        } else {
                $intervention = "";
        }

        if(isset($_GET['outcome'])) {        
                $outcome = $_GET['outcome'];
        } else {
                $outcome = "";
        }        

        debugLog('Condition: '.$condition);
        debugLog('Intervention: '.$intervention);
        debugLog('Outcome: '.$outcome);

        $allXMLs = getData($condition, $intervention, $outcome);
        $result = analyze($allXMLs, $condition, $intervention, $outcome);        

        header('Content-Type: application/json');
        echo $result;
?>

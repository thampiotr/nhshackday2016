<?php
include('common.php');
?>
<?php
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

        echo $condition.$intervention.$outcome;
        $allXMLs = getData($condition, $intervention, $outcome);
        print_r(json_encode($allXMLs));
?>

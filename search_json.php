<?php
include('common.php');
include('functions.php');
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
        $allXMLs = getData($condition, $intervention, $outcome);
        header('Content-Type: application/json');
        print_r(analyze($allXMLs, $condition, $intervention, $outcome));
?>

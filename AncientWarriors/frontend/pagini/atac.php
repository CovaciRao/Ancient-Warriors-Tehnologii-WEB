<?php

    if(isset($_GET['id'])){
    include(__ROOT__.'/backend/actiuniLupta.php');
    
    atacSat($_GET['id']);


    }
    else{
        echo "Selectează o lume!";
    }



?>
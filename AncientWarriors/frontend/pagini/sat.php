<?php

    if(isset($_GET['id'])){
    include(__ROOT__.'/backend/actiuniLupta.php');
    
    listareSat($_GET['id']);


    }
    else{
        echo "Ești nevoit să selectezi o lume!";
    }



?>
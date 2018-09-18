<?php
    session_start();
    define('__ROOT__',dirname(dirname(__FILE__)));
    include(__ROOT__ . "/sistem/conectare.php");
    include(__ROOT__ ."/sistem/pager.php");

    if(isset($_GET['nonUI'])){
        getPage();
    }
    else{
        include("webdesign/templates/ui.php");
    }
?>
<?php
function getPage(){
    if(isset($_GET['page'])){ 
       
        $page = str_replace("..//", "", $_GET['page']);
        
        include("pagini/" . $page . ".php");
        
        
        /* if($_GET['page'] === "inregistrare"){
            include("pagini/inregistrare.php");
        }
        elseif($_GET['page'] === "logare"){
            include("pagini/logare.php");
        }

        else{
            echo "link invalid";
        } */
    }
    elseif(isset($_GET['bPage'])){
        if($_GET['bPage'] === "optiuniConturi"){
            
            include("../backend/optiuniConturi.php");
        }
        elseif($_GET['bPage'] === "actiuniOras"){
            include("../backend/actiuniOras.php");  
        }
        elseif($_GET['bPage'] === "actiuniArmata"){
            include("../backend/actiuniArmata.php");  
        }
    }
    else
    {
        if(isset($_SESSION['loggedIn'])){
            include("pagini/loggedIn.php");
        }
        else{
            include("pagini/welcome.php");
        }
    }       
}
?>
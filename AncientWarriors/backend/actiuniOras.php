<?php
function getResurse(){
    global $db;
    $id = $_SESSION['loggedIn'];
    $sql = "SELECT * FROM resurse WHERE id='$id'";
    $stmt = $db->query($sql);
    $result = $stmt->fetchAll();


?>


<fieldset>
    <legend style="text-align:center;border:1px solid black;"><b>Resurse</b></legend>
    <span class="quarterWidth">
        <img height="42" width="42" src='webdesign/imagini/resurse/lemn.png'><br>
        <?php echo "<b>" . $result[0]['lemn'] . "</b>"; ?>
    </span>
        <span class="quarterWidth">
        <img height="42" width="42" src='webdesign/imagini/resurse/fier.png'><br>
        <?php echo "<b>" . $result[0]['fier']. "</b>"; ?>
    </span>
    <span class="quarterWidth">
        <img height="42" width="42" src='webdesign/imagini/resurse/aur.png'><br>
        <?php echo "<b>" . $result[0]['aur'] . "</b>"; ?>
    </span>
    <span class="quarterWidth">
        <img height="42" width="42" src='webdesign/imagini/resurse/hrana.png'><br>
        <?php echo "<b>" . $result[0]['hrana'] . "</b>"; ?>
    </span>
</fieldset>
<br><br>
<?php
}

function creareOras(){
    // luam cladirile orasului;
    global $db;
    if(isset($_SESSION['OrasErrorMessage'])){
        echo $_SESSION['OrasErrorMessage'];
        unset($_SESSION['OrasErrorMessage']);
    }
    $id = $_SESSION['loggedIn'];
    $sql = "SELECT * FROM ancients WHERE id='$id'";
    $stmt = $db->query($sql);
    $result = $stmt->fetchAll();
    $cladirileMele = explode(",",$result[0]['cladiri']);
    
    //luarea cladirile valabile
    $sql = "SELECT * FROM cladiri";
    $stmt = $db->query($sql);
    $toateCladirile = $stmt->fetchAll(PDO::FETCH_GROUP);
    
    // desenam orasul
    $i=0;
    echo "<div id='cldSustin'>";
        for($y = 0;$y < 4;$y++)
        {
            for($x = 0;$x < 3;$x++){

                if($cladirileMele[$i] === "0"){
                    $text = "<img style='height:100%;weight:100%;' src='webdesign/imagini/imgcladiri/iarba.jpg'>"; 
                }
                else{
                    if(isset($toateCladirile[$cladirileMele[$i]][0]['imagine'])){
                        $text = "<img style='height:100%;weight:100%;' src='webdesign/imagini/imgcladiri/" . $toateCladirile[$cladirileMele[$i]][0]['imagine'] . "'>";
                    }
                    else {
                        $text = $toateCladirile[$cladirileMele[$i]][0]['nume'];
                    }
                }
                echo "<span id='" . $i . "' class='boxCld'>" .$text . "</span>"; 
                $i++;   
            }
        }
    echo "</div>";
    echo "<div id='optiunilecladirilor'>";
            echo "<span id='locatieCladire' style='display:none'></span>";
            foreach($toateCladirile as $key => $cladirea){
            echo "<div id='" .$key ."' class='cladireBox'>" . $cladirea[0]['nume'] . "<br>" .
                    "<img height='25' width='25' src='webdesign/imagini/resurse/lemn.png'>" . $cladirea[0]['costlemn'] .
                    "<img height='25' width='25' src='webdesign/imagini/resurse/fier.png'> " . $cladirea[0]['costfier'] . "<br>" .
                    "<img height='25' width='25' src='webdesign/imagini/resurse/aur.png'> " . $cladirea[0]['costaur'] .
                    "<img height='25' width='25' src='webdesign/imagini/resurse/hrana.png'> " . $cladirea[0]['costhrana'] .
                    "</div>";
            }
    
        
    echo "</div>";
    ?>
<script>
    $(".boxCld").click(function(event){
        var id = $(this).attr('id');
        $("#locatieCladire").text(id);
        $("#optiunilecladirilor").css('left',event.pageX);
        $("#optiunilecladirilor").css('top',event.pageY);
        $("#optiunilecladirilor").toggle();
    });
    
    $(".cladireBox").click(function(){
        var idClad = $(this).attr('id');
        var locId =  $("#locatieCladire").text();
        $.post("?bPage=actiuniOras",{
            locatie: locId,
            idCladire: idClad
        }).done(function(){
            $("#orasArea").load("?bPage=actiuniOras&creareOras&nonUI");
        });
    });

</script>
<?php
}

function creazaCladire($locatie,$idCladire){
    global $db;
    
    $sql = "SELECT * FROM cladiri WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute(array($idCladire));
    //Daca exista cladirea
    if($stmt->rowCount() > 0)
    {
        //informatii despre cladire
        $rezultatCladire = $stmt->fetchAll();
        
        $id = $_SESSION['loggedIn'];
        $sql = "SELECT * FROM resurse INNER JOIN ancients ON ancients.id = resurse.id  WHERE resurse.id='$id'";
        $stmt = $db->query($sql);
        $result = $stmt->fetchAll();
        // resursele curente
        $currencyArray = array("costlemn" => $result[0]['lemn'],"costfier" => $result[0]['fier'],"costaur" => $result[0]['aur'],"costhrana" => $result[0]['hrana']);
        $newCurrency = array();
        $couldNotAfford = 0;
        
        foreach($currencyArray as $currency => $amount){
            echo "COST: " . $rezultatCladire[0][$currency] . " my  " . $currency . " " . $amount . "<br>";
            if($rezultatCladire[0][$currency] > $amount){
                $couldNotAfford = 1;
                break;
            }
            else{
                $newCurrency += array($currency => $amount - $rezultatCladire[0][$currency]);
            }
        }
        #var_dump($newCurrency);
         if($couldNotAfford === 0){
             // you can afford it
             
             $orasulNostruArray = explode(",",$result[0]['cladiri']);
             if($orasulNostruArray[$locatie] === "0"){
                 //spot empty you can build
                 
                 $orasulNostruArray[$locatie] = $idCladire;
                 $orasulNostruArray = implode(",",$orasulNostruArray);
                 
                 $sql = "UPDATE ancients SET cladiri='$orasulNostruArray' WHERE id='$id'";
                 $db->query($sql);
                 
                 $sql = "UPDATE resurse SET lemn=$newCurrency[costlemn],fier=$newCurrency[costfier],aur=$newCurrency[costaur],hrana=$newCurrency[costhrana] WHERE id='$id'";
                 $db->query($sql);
             }
             else{
                 $_SESSION['OrasErrorMessage'] = "Există o clădire în acea locație!";
             }
         }
         else{
                $_SESSION['OrasErrorMessage'] = "<b><center>Nu se poate crea clădirea!</center></b>";
             }
    }
    else{
        $_SESSION['OrasErrorMessage'] = "<b><center>Clădirea nu există!</b></center>";
    }  
}

if(isset($_GET['creareOras'])){
    creareOras();
}

if(isset($_POST['locatie'])){
    creazaCladire($_POST['locatie'], $_POST['idCladire']);
}



?>
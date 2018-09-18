<?php

    function listArmataMea($id){
        global $db;
        
        $sql ="SELECT * FROM unitatiarmata";
        $stmt = $db->query($sql);
        $unitatiArmata = $stmt->fetchAll();
        
        $sql = "SELECT armata,puterearmata FROM resurse WHERE id='$id'";
        $stmt=$db->query($sql);
        $result = $stmt->fetch();
        
        if(isset($result['armata'])){
        $armataArray = explode(",",$result['armata']);
        
        foreach($armataArray as $unitate){
                $ex = explode(":",$unitate);
            
                foreach($unitatiArmata as $unitateArmata){
                    #echo "<br><br> ex0 e " . $ex[0] . "-" . $unitateArmata['id'];
                    if($ex[0] === $unitateArmata['id']){
                        #gasit
                        $numeUnitate = $unitateArmata['nume'];
                        break;
                    }

                }

                echo "<br><b>" . $ex[1] . " " . $numeUnitate . "</b>";
            }
        }
    }


    function listUnitatiDeCumparat(){
        global $db;
        $sql ="SELECT * FROM unitatiarmata";
        $stmt = $db->query($sql);
        echo "<form action=?bPage=actiuniArmata&recrutare method=POST>";
        while($result = $stmt->fetch()){
            echo "<b><input name='" . $result['id'] . "'type=number value=0 min=0>" . $result['nume'] . "(" . $result['puterearmata'] .  " Putere) - " . $result['plata'] . " aur " . "<b><br>";
        }
        echo "<input type=submit>";
        echo "</form>";
        
    }
    
    function cumparaUnitati(){
        global $db;
        
        $sql ="SELECT * FROM unitatiarmata";
        $stmt = $db->query($sql);
        $unitatiArmata = $stmt->fetchAll();
        
        $aranjareUnitatiArmata = array();
        foreach($unitatiArmata as $data){
            $aranjareUnitatiArmata[$data['id']] = $data;
        }
        
        $contId = $_SESSION['loggedIn'];
        $sql = "SELECT * FROM resurse WHERE id='$contId'";
        $stmt=$db->query($sql);
        $utilizator = $stmt->fetch();
        $armataMeaArray = array();
        if(isset($utilizator['armata'])){
        $armataArray = explode(",",$utilizator['armata']);
            foreach($armataArray as $unitate){
                $ex = explode(":",$unitate);
                $armataMeaArray[$ex[0]] = $ex[1];
                #var_dump($armataMeaArray);
            }
        }
        
        $costTotal = 0;
        $putereLuptaAdaugata = 0;
        
        foreach($_POST as $id => $amount){
            if($amount > 0 ){
                if(isset($aranjareUnitatiArmata[$id])){
                    $costTotal += $aranjareUnitatiArmata[$id]['plata'] * $amount;
                    $putereLuptaAdaugata += $aranjareUnitatiArmata[$id]['puterearmata'] * $amount;
                    if(isset($armataMeaArray[$id])){
                        $armataMeaArray[$id] += $amount;
                    }
                    else{
                        $armataMeaArray[$id] = $amount;
                    }
                }
                else{
                    exit;
                }
            }
        }
        
        
        #var_dump($armataMeaArray);
        if($utilizator['aur'] >= $costTotal){
            echo "<center><b><h3><font face=verdana size='7' color='red'>Unitățile au fost cumpărate cu succes!</font></h3></b></center>";
            echo "<center><img src='webdesign/imagini/background/rosold.jpg'></center><br>";
            
            $adaugareArmataNoua = "";
            foreach ($armataMeaArray as $id => $amount){
                $adaugareArmataNoua .= $id . ":" . $amount . ",";
            }
            if (substr($adaugareArmataNoua, -1)== ","){
                $adaugareArmataNoua = substr($adaugareArmataNoua, 0 , -1);
            }
            #echo $adaugareArmataNoua;
            
            $sql = "UPDATE resurse SET aur = aur-'$costTotal' WHERE id='$contId'";
            $db->query($sql);
 
            $sql = "UPDATE resurse SET armata='$adaugareArmataNoua' , puterearmata = puterearmata +'$putereLuptaAdaugata' WHERE id='$contId'";
            #echo $sql;
            $db->query($sql);
        }
        
    }
    if(isset($_GET['recrutare'])){
        cumparaUnitati();
    }
  
?>
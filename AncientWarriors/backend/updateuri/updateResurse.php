<?php
    include("E:\LicentaWorth\wamp64\www\AncientWarriorsLicenta\sistem\conectare.php");
    global $db;
    $sql = "SELECT * FROM cladiri";
    $stmt = $db->query($sql);
    $toatecladirile = $stmt->fetchAll();

    
    $sql = "SELECT * FROM ancients";
    $stmt = $db->query($sql);
    $satJucator = $stmt->fetchAll();
    
    foreach ($satJucator as $sat){
        $aincomelemn = 0;
        $aincomefier = 0;
        $aincomeaur = 0;
        $aincomehrana = 0;
        $cladiriJucator = explode(",",$sat['cladiri']);
        foreach($cladiriJucator as $cladire){
            if($cladire != 0){
                foreach($toatecladirile as $infoCladire)
                    if($infoCladire['id'] == $cladire){
                                $aincomelemn += $infoCladire['incomelemn'];
                                $aincomefier += $infoCladire['incomefier'];
                                $aincomeaur += $infoCladire['incomeaur'];
                                $aincomehrana += $infoCladire['incomehrana'];
                        break;
                    }
            }
        }
        $sql = "UPDATE resurse SET lemn=lemn + $aincomelemn,fier=fier + $aincomefier,aur=aur + $aincomeaur,hrana=hrana + $aincomehrana WHERE id = $sat[id]";
        $db->query($sql);
    }

?>


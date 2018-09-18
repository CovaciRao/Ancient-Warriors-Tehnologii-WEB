<?php

function listareaJucatorilor(){
    global $db;
    
    
   $sql = "SELECT * FROM ancients";
   $stmt = $db->prepare($sql);
   $stmt->execute();
   
   $result = $stmt->fetchAll();
   
   foreach($result as $row){
       echo "<b><a href='?page=sat&id=" . $row['id'] . "'>" . $row['nume'] . "</a><br></b>";
   }
}

function listareSat($id){
    global $db;
    include(__ROOT__."/backend/actiuniArmata.php");
    echo "<h4>PUTEREA ARMATEI SATULUI</h4> ";
    listArmataMea($id);
    echo "<h4>RESURSELE SATULUI</h4> ";
    resurseleSatului($id);
    echo "<a href='?page=atac&id=" . $id . "'><button>Atac</button></a>";
}

function resurseleSatului($id){
    global $db;
    $sql = "SELECT * FROM resurse WHERE id='$?'";
    $stmt = $db->prepare($sql);
    $stmt->execute(array($id));
    $result = $stmt->fetchAll();


}

function atacSat($id){
    global $db;
    $adversarResult = rowResurse($id);
    $jucatorResult = rowResurse($_SESSION['loggedIn']);
    
    $contId = $_SESSION['loggedIn'];
    $sql = "SELECT * FROM resurse WHERE id='$contId'";
    $stmt=$db->query($sql);
    $utilizatore = $stmt->fetch();
    #var_dump($utilizatore);
    
    $bonus = 100;
    $pierdere = 2;
    
    
    if($jucatorResult[0]['puterearmata'] > $adversarResult[0]['puterearmata']){
        echo '<center><img src="../webdesign/imagini/background/victorie.jpg" alt="icon""/></center><br>';
        echo "<center><h3><font face=verdana size='7' color='red'>Trupele tale au fost victorioase!</font></h3></center>";
        $sql = "UPDATE resurse SET aur = aur+'$bonus', fier = fier+'$bonus', hrana = hrana+'$bonus', lemn = lemn+'$bonus' WHERE id='$contId'";
        $db->query($sql);

    }
    else{
        echo '<center><img src="../webdesign/imagini/background/infrangere.jpg" alt="icon" align="middle"/><br></center';
        echo "<center><h3><font face=verdana size='7' color='red'>Trupele tale au fost înfrânte!</font></h3></center>";
        $sql = "UPDATE resurse SET puterearmata=puterearmata/'$pierdere' WHERE id='$contId'";
        $db->query($sql);

    }
}
function rowResurse($id){
    global $db;
    $sql = "SELECT * FROM resurse WHERE id=?";
    $stmt = $db->prepare($sql);
    $stmt->execute(array($id));
    return $stmt->fetchAll();
}
?> 


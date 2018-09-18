<?php
    include(__ROOT__ . "/backend/actiuniOras.php");
    include(__ROOT__."/backend/actiuniArmata.php");
    getResurse();
    echo "<h3>Puterea armatei:</h3>";
    echo "<img height='100' width='100' src='webdesign/imagini/armata/chinez.png'> ";
    echo "<img height='100' width='100' src='webdesign/imagini/armata/apas.png'> ";
    echo "<img height='100' width='100' src='webdesign/imagini/armata/roman.png'> ";
    echo "<img height='100' width='100' src='webdesign/imagini/armata/egipt.png'> ";
    echo "<img height='100' width='100' src='webdesign/imagini/armata/teuton.png'><br>";
    listArmataMea($_SESSION['loggedIn']);
    
    echo "<h3>Armata ta</h3> ";
   listUnitatiDeCumparat();
?>
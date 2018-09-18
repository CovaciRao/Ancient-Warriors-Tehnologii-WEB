<?php
    if(isset($_SESSION['loggedIn'])){
?>
        <div id="top">
            <h1 class="floatStanga"></h1>
            <div id="optiuniConturi" class="floatDreapta">
                <a href="?bPage=optiuniConturi&action=logout&nonUI"><button type="button" class="btn btn-dark">Deconectare</button><br></a>
                <a href="?page=ancients"><button type="button" class="btn btn-dark">Orașul meu</button><br></a>
                <a href="?page=armata"><button type="button" class="btn btn-dark">Armata mea</button><br></a>
                <a href="?page=altiJucatori"><button type="button" class="btn btn-dark">Alți jucători</button></a>
            </div>
        </div>
<?php
    }
 else {
     ?>
        <div id="top">
            <h1 class="floatStanga"></h1>
            <div id="optiuniConturi" class="floatDreapta">
                <a href="?page=inregistrare"><button type="button" class="btn btn-dark">Înregistrare</button></a><br>
                <a href="?page=logare"><button type="button" class="btn btn-dark">Logare</button></a>
            </div>

        </div>
    <?php
}
?>
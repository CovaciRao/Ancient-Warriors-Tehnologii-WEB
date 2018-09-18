<?php
    if(isset($_GET['message'])){
        echo $_GET['message'] . "<br>";
    }
    
    if(isset($_POST['submit'])){
        $secretKey = "6Lc-vV0UAAAAAHP40Ek4DoduXN0NFSNFOXWKeShv";
        $responseKey = $_POST['g-recaptcha-response'];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey";
        $response = fille_get_contents($url);
        $response = json_decode($response);
        
    }
?>

Inregistreaza-te:

<form action="?bPage=optiuniConturi&action=inregistrare&nonUI" method="post">
    Username: <input type="text" name="username" pattern=".{4,20}" title="Minim 6 caractere,maxim 15 caractere" required><br>
    Parola: <input type="password" name="password" pattern=".{6,15}" title="Minim 6 caractere,maxim 15 caractere" required><br>
    Email : <input type="email" name="email" required><br>
    <input type="submit" name="submit">
    <div class="g-recaptcha" data-sitekey="6Lc-vV0UAAAAAFxe3kJBcu0SJJK3bwzi2r24YpzG"></div>
</form>


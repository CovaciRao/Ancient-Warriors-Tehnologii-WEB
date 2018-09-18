<?php
function inregistrareAccount($username,$password,$email){
    global $db;
    if(preg_match("/^[a-zA-Z0-9]+$/", $username) !== 0){
        
        if (strlen($username) < 20 || strlen($username) > 4){
            $hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
            $sql = "INSERT INTO useri (username,password,email) VALUES(?,?,?)";
            $stmt = $db->prepare($sql);
            $stmt->execute(array($username,$hash,$email));
            if($stmt->rowCount() >0){
                $id = $db->lastInsertId();
                $satjucator = "Satul lui " . $username;
                $sql = "INSERT INTO ancients (id,nume) VALUES ('$id','$satjucator')";
                $db->query($sql);
                $sql = "INSERT INTO resurse (id) VALUES ('$id')";
                $db->query($sql);
                $_SESSION['loggedIn'] = $id;
                 header("location: ?page=loggedIn&message=Inregistrat"); 
            }
            else{
                header("location: ?page=inregistrare&message=failed"); 
            }
        }
        else{
            header("location: ?page=inregistrare&message=failedlungimenumenepermisa");
        }
    }
    else{
        header("location: ?page=inregistrare&message=failedCaractereNepermise"); 
    }
}
function logare($username,$password){
    global $db;
    
    $sql = "SELECT * FROM useri WHERE username=:username";
    $stmt = $db->prepare($sql);
    $stmt->execute(array(':username' => $username));
    if($stmt->rowCount() > 0){
        $result = $stmt->fetchAll();
        $hash = $result[0]['password'];
        if(password_verify($password, $hash)){
            $_SESSION['loggedIn'] = $result[0]['id'];
            header("location: ?page=loggedIn&message=esticonectat");
        }
        else{ 
            #parola sau cont incorecte
            header("location: ?page=inregistrare&message=loginFailed");
        }
    }
    else{ 
        #parola sau cont incorecte
        header("location: ?page=inregistrare&message=loginFailed");
    }

}
function logout(){
    session_destroy();
    header("location: ?");
}
if($_GET['action'] === "inregistrare")
    {
    inregistrareAccount($_POST['username'],$_POST['password'],$_POST['email']);
    }
elseif($_GET['action'] === "logare")
    {
    logare($_POST['username'],$_POST['password']);
    }
elseif($_GET['action'] === "logout")
    {
    logout();
    }
?> 
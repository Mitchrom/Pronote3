<?php
$pdo = new PDO(
    'mysql:host=localhost;dbname=pronote;charset=utf8',
    'root',
    ''
);

session_start();
@$nom = $_POST["nom"];
@$prenom = $_POST["prenom"];
@$login = $_POST["login"];
@$pass = $_POST["pass"];
@$repass = $_POST["repass"];
@$valider = $_POST["valider"];
$erreur = "";
if (isset($valider)) {
    if (empty($nom)) $erreur = "Nom laissé vide!";
    elseif (empty($prenom)) $erreur = "Prénom laissé vide!";
    elseif (empty($prenom)) $erreur = "Prénom laissé vide!";
    elseif (empty($login)) $erreur = "Login laissé vide!";
    elseif (empty($pass)) $erreur = "Mot de passe laissé vide!";
    elseif ($pass != $repass) $erreur = "Mots de passe non identiques!";
    else {

        $sel = $pdo->prepare("select id from user where login=? limit 1");
        $sel->execute(array($login));
        $tab = $sel->fetchAll();
        if (count($tab) > 0)
            $erreur = "Login existe déjà!";
        else {
            $ins = $pdo->prepare("insert into user(nom,prenom,login,pass) values(?,?,?,?)");
            if ($ins->execute(array($nom, $prenom, $login, md5($pass))))
                header("location:login.php");
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <style>
        * {
            font-family: arial;
        }

        body {
            margin: 20px;
        }

        input {
            border: solid 1px #2222AA;
            margin-bottom: 10px;
            padding: 16px;
            outline: none;
            border-radius: 6px;
        }

        .erreur {
            color: #CC0000;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h1>Inscription</h1>
    <div class="erreur"><?php echo $erreur ?></div>
    <form name="fo" method="post" action="">
        <input type="text" name="nom" placeholder="Nom" value="<?php echo $nom ?>" /><br />
        <input type="text" name="prenom" placeholder="Prénom" value="<?php echo $prenom ?>" /><br />
        <input type="text" name="login" placeholder="Login" value="<?php echo $login ?>" /><br />
        <input type="password" name="pass" placeholder="Mot de passe" /><br />
        <input type="password" name="repass" placeholder="Confirmer Mot de passe" /><br />
        <input type="submit" name="valider" value="S'authentifier" />
    </form>
</body>

</html>

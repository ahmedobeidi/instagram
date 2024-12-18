<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter</title>
   
</head>
<body>
    <form action="../../backend/process_connexion.php" method="post">
        <div>
            <h1>Se connecter</h1>
            <?php
            session_start();
            if (isset($_SESSION["mdp"])) {
                echo "<p style='color: red; text-align: center;'>" . $_SESSION["mdp"] . "</p>";
                unset($_SESSION["mdp"]);
            }
            ?>
            <label for="nom">Nom :</label><br>
            <input type="text" name="nom" id="nom" placeholder="Entrez votre nom" value="" autocomplete="off" required>
        </div>
        <br>
        <div>
            <label for="password">Mot de passe :</label><br>
            <input type="password" name="password" id="password" placeholder="Entrez votre mot de passe" required>
        </div>
        <br>
        <div>
            <input type="submit" value="Se connecter">
        </div>
    </form>
</body>
</html>

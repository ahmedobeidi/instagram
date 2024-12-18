



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
    session_start();
    
    if (isset($_SESSION["erreur"])) {
        echo "<p style='color: red; text-align: center;'>" . $_SESSION["erreur"] . "</p>";
        unset($_SESSION["erreur"]);
        session_destroy();
    }


   
    ?>
<form action="../..//backend/process_inscription.php" method="post" >

<div>
            <label for="nom">Nom :</label><br>
            <input type="text" name="nom" id="nom" placeholder="Entrez votre nom" value="" autocomplete="off"  required>
        </div>
        <br>
        
       
        <div>
            <label for="password">Mot de passe :</label><br>
            <input type="password" name="password" id="password" placeholder="Entrez votre mot de passe" required>
        </div>
        <br>
        
      
        <div>
            <input type="submit" value="S'inscrire">
        </div>
    </form>

  
</body>
</html>
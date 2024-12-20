<?php
session_start();
require_once '../db/connect_db.php'; 



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
    if (isset($_POST['nom']) && isset($_POST['password'])) {
        
        $username = htmlspecialchars(trim($_POST['nom']));
        $password = trim($_POST['password']);

        
        if (empty($username) || empty($password)) {
            $_SESSION["erreur"] = "Erreur : Tous les champs sont obligatoires.";
            header("Location: ../frontend/pages/inscription.php");
            exit;
        }

     

        try {
            
            $sql = "SELECT * FROM user WHERE username = :username";
            $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                
                $_SESSION["erreur"] = "Erreur : Le pseudo '$username' est déjà pris.";
                header("Location: ../frontend/pages/inscription.php");
                exit;
            }


           
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user (username, password) VALUES (:username, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':username' => $username,
                ':password' => $hashedPassword
            ]);

            
            $_SESSION["user"] = $username;
            $_SESSION["user_id"] = $pdo->lastInsertId();
            
            header("Location: ../index.php");
            exit;

        } catch (PDOException $error) {
            $_SESSION["erreur"] = "Erreur lors de la requête : " . $error->getMessage();
            header("Location: ../frontend/pages/inscription.php");
            exit;
        }

    } 
} 
?>
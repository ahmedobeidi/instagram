<?php

session_start();
require_once '../db/connect_db.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nom']) && isset($_POST['password'])) {
        $username = htmlspecialchars(trim($_POST['nom']));
        $password = trim($_POST['password']);

        if (empty($username) || empty($password)) {
            $_SESSION["mdp"] = "Erreur : Tous les champs sont obligatoires.";
            header("Location: ../..//frontend/pages/connexion.php");
            exit;
        }

        try {
           
            
            $sql = "SELECT * FROM user WHERE username = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);


            if ($user && password_verify($password, $user['password'])) {
                
                $_SESSION['user'] = $user['username'];
                $_SESSION["user_id"] = $user["id"];
                header("Location:../frontend/pages/profil.php");
                exit;
            } else {
                
                $_SESSION["mdp"] = "Nom d'utilisateur ou mot de passe incorrect.";
                header("Location: ../frontend/pages/connexion.php");
                exit;
            }
        } catch (PDOException $error) {
            $_SESSION["mdp"] = "Erreur lors de la requête : " . $error->getMessage();
            header("Location: ../frontend/pages/connexion.php");
            exit;
        }
    }
} else {
    header("Location: ../../frontend/pages/connexion.php");
    exit;
}
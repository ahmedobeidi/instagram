<?php
require_once '../db/connect_db.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['photo_id'])) {
    $user_id = $_SESSION['user_id'];
    $photo_id = $_POST['photo_id'];

    try {
        // Vérifier si l'utilisateur a déjà liké cette photo
        $check_sql = "SELECT * FROM liker WHERE user_id = :user_id AND photo_id = :photo_id";
        $stmt = $pdo->prepare($check_sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':photo_id', $photo_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            // Ajouter le like
            $insert_sql = "INSERT INTO liker (user_id, photo_id) VALUES (:user_id, :photo_id)";
            $stmt = $pdo->prepare($insert_sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':photo_id', $photo_id, PDO::PARAM_INT);
            $stmt->execute();

            // Incrémenter le compteur de likes
            $sql_increment_like = "UPDATE photo SET likes_count = likes_count + 1 WHERE id = :photo_id";
            $stmt_increment = $pdo->prepare($sql_increment_like);
            $stmt_increment->bindParam(':photo_id', $photo_id, PDO::PARAM_INT);
            $stmt_increment->execute();
        } else {
            
            $delete_sql = "DELETE FROM liker WHERE user_id = :user_id AND photo_id = :photo_id";
            $stmt = $pdo->prepare($delete_sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':photo_id', $photo_id, PDO::PARAM_INT);
            $stmt->execute();

            // Décrémenter le compteur de likes
            $sql_decrement_like = "UPDATE photo SET likes_count = likes_count - 1 WHERE id = :photo_id";
            $stmt_decrement = $pdo->prepare($sql_decrement_like);
            $stmt_decrement->bindParam(':photo_id', $photo_id, PDO::PARAM_INT);
            $stmt_decrement->execute();
        }

        
        header('Location: ../frontend/pages/profil.php');
        exit;

    } catch (PDOException $erreur) {
        echo "Error: " . $erreur->getMessage();
        exit;
    }
}
?>
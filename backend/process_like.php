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

            // Met à jour l'état dans la session pour cette photo
            $_SESSION['like_status_' . $photo_id] = 'liked';
        } else {
            // Supprimer le like
            $delete_sql = "DELETE FROM liker WHERE user_id = :user_id AND photo_id = :photo_id";
            $stmt = $pdo->prepare($delete_sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':photo_id', $photo_id, PDO::PARAM_INT);
            $stmt->execute();

            // Met à jour l'état dans la session pour cette photo
            $_SESSION['like_status_' . $photo_id] = 'disliked';
        }

        // Redirige vers la page d'origine après traitement
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
}
?>

<?php
session_start();

require_once '../../db/connect_db.php';

if (isset($_POST['photo_id'])) {
    $user_id = $_SESSION['user_id'];
    $photo_id = $_POST['photo_id'];

    // Vérifier si l'utilisateur a déjà liké la photo
    $check_sql = "SELECT * FROM liker WHERE user_id = :user_id AND photo_id = :photo_id";
    $stmt = $pdo->prepare($check_sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':photo_id', $photo_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        // L'utilisateur n'a pas encore liké, donc on enregistre un like
        $insert_sql = "INSERT INTO liker (user_id, photo_id) VALUES (:user_id, :photo_id)";
        $stmt = $pdo->prepare($insert_sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':photo_id', $photo_id, PDO::PARAM_INT);
        $stmt->execute();

        // Enregistrer dans la session que l'utilisateur a aimé la photo
        $_SESSION['like_status_' . $photo_id] = 'liked';
    } else {
        // L'utilisateur a déjà liké, on retire le like
        $delete_sql = "DELETE FROM liker WHERE user_id = :user_id AND photo_id = :photo_id";
        $stmt = $pdo->prepare($delete_sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':photo_id', $photo_id, PDO::PARAM_INT);
        $stmt->execute();

        
        $_SESSION['like_status_' . $photo_id] = 'disliked';
    }

   
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
?>

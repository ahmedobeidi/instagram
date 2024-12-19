<?php
require_once '../db/connect_db.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../../frontend/pages/connexion.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $sms = $_POST['sms'];
    $photo_id = $_POST['id'];
    $user_id = $_SESSION['user_id']; 

   
    $sql_insert = "INSERT INTO commentaire (photo_id, user_id, sms) VALUES (:photo_id, :user_id, :sms)";
    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->bindParam(':photo_id', $photo_id);
    $stmt_insert->bindParam(':user_id', $user_id);
    $stmt_insert->bindParam(':sms', $sms);

    try {
        $stmt_insert->execute();
        
        header("Location: ../frontend/pages/commentaire.php?id=$photo_id");
    } catch (PDOException $e) {
        echo "Erreur lors de l'insertion du commentaire : " . $e->getMessage();
    }
}
?>

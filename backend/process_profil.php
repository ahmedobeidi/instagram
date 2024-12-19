<?php
session_start();
require_once '../db/connect_db.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && isset($_FILES['photo'])) {

    $user_id = $_POST['user_id'];
    $texteimage = $_POST['texteimage'];
    $photo = $_FILES['photo'];

    
    if ($photo['error'] === UPLOAD_ERR_OK) {
       
        $uploadDir = '../assets/';
        $fileName = uniqid() . basename($photo['name']);
        $uploadPath = $uploadDir . $fileName;

      
        if (move_uploaded_file($photo['tmp_name'], $uploadPath)) {
            $url_photo = $uploadPath;

            
            try {
                $sql = "INSERT INTO photo (user_id, photo_url, texteimage) VALUES (:user_id, :photo_url, :texteimage)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindParam(':photo_url', $url_photo, PDO::PARAM_STR);
                $stmt->bindParam(':texteimage', $texteimage, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    echo "Image ajoutée avec succès.";
                } else {
                    echo "Erreur lors de l'ajout de l'image.";
                }
            } catch (PDOException $e) {
                echo "Erreur de base de données : " . $e->getMessage();
            }
        } else {
            echo "Erreur lors du téléchargement de l'image.";
        }
    } else {
        echo "Erreur d'upload d'image.";
    }
}

// Supprimer une image
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete']) && isset($_POST['photo_id'])) {

    $user_id = $_SESSION['user_id'];
    $photo_id = $_POST['photo_id'];

    try {
        
        $sql = "SELECT photo_url FROM photo WHERE id = :photo_id AND user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':photo_id', $photo_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $photo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($photo) {
            
            $file_path = $photo['photo_url'];
            if (file_exists($file_path)) {
                unlink($file_path);  
            }

          
            $delete_sql = "DELETE FROM photo WHERE id = :photo_id AND user_id = :user_id";
            $stmt = $pdo->prepare($delete_sql);
            $stmt->bindParam(':photo_id', $photo_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

          
            echo "Image supprimée avec succès.";
        } else {
            echo "Photo introuvable ou vous n'avez pas l'autorisation de la supprimer.";
        }

    } catch (PDOException $erreur) {
        echo "Erreur : " . $erreur->getMessage();
    }
}
?>
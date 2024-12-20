<?php
session_start();
require_once '../db/connect_db.php'; 

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    
    // Préparer la requête SQL en utilisant un paramètre pour éviter l'injection SQL
    $stmt = $pdo->prepare("SELECT * FROM user WHERE username LIKE ?");
    $searchTerm =  $query;
    $stmt->execute([$searchTerm]);  
    

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  

    if ($result) {
        // Affichage des résultats
        foreach ($result as $row) {
            
            echo "<div>";
            echo "<a href = '../frontend/pages/profil.php?id=" . $row["id"] . " '>Profil de : " . htmlspecialchars($row["username"]) . "</a>";
            
        }
    } else {
        echo "Aucun résultat trouvé";
    }
}
?>
<?php
require_once './db/connect_db.php';
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: ./frontend/pages/connexion.php");
    exit;
} else {
    $user = $_SESSION["user"];
}


 $sql = "SELECT user.username,photo_url, texteimage, photo.id, user_id FROM photo
 INNER JOIN user WHERE user.id = photo.user_id
  ORDER BY id DESC;";
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    echo $error->getMessage();
    exit;
}



?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram - Accueil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow-md py-4">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <div class="text-3xl font-bold text-blue-600">
                <a href="">Instagram</a>
            </div>
            <div class="space-x-6">
                <a href="" class="text-gray-700 hover:text-blue-600">Accueil</a>
                <a href="./frontend/pages/connexion.php" class="text-gray-700 hover:text-blue-600">Connexion</a>
                <a href="./frontend/pages/inscription.php" class="text-gray-700 hover:text-blue-600">S'inscrire</a>
                <a href="./frontend/pages/profil.php?id=<?= $user_id = $_SESSION['user_id']; ?>" class="text-gray-700 hover:text-blue-600">Profil </a>
            </div>
        </div>
    </nav>

    <!-- Section d'introduction -->
    <section class="mt-12 text-center">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-3xl font-semibold text-gray-800"><?= htmlspecialchars($user) ?></h1>
            <p class="mt-4 text-lg text-gray-600">Connectez-vous avec vos amis et découvrez des photos intéressantes.</p>
        </div>
    </section>

    <!-- Galerie de publications -->
    <section class="mt-12">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($photos as $image):
                
                ?>
                <?php
                    // Récupérer le nombre de likes pour chaque photo
                    $sql_like_count = "SELECT COUNT(*) AS likes_count FROM liker WHERE photo_id = :photo_id";
                    $stmt_like_count = $pdo->prepare($sql_like_count);
                    $stmt_like_count->bindParam(':photo_id', $image['id'], PDO::PARAM_INT);
                    $stmt_like_count->execute();
                    $like_count = $stmt_like_count->fetch(PDO::FETCH_ASSOC);
                ?>
                
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <img src="<?= ".../" . $image['photo_url'] ?>" alt="Publication" class="w-full h-64 object-cover">
                    <div class="p-4">
                        <p class="text-sm text-gray-700"><?= htmlspecialchars($image['texteimage']) ?></p>
                        <p class="text-xs text-gray-500"><?= $image['username'] ?></p> <!-- Vous pouvez également ajouter une jointure pour afficher le nom de l'utilisateur si nécessaire -->
                        <a href="./frontend/pages/commentaire.php?id=<?= $image['id'] ?>">voir tout les commentaires</a>
                        <div class="flex items-center mt-3 space-x-4">
                            <form action="./backend/process_like.php" method="POST" id="like-form-<?= $image['id'] ?>">
                                <input type="hidden" name="photo_id" value="<?= $image['id'] ?>">
                                <input type="submit" name="like" value="Aimer" 
                                       class="text-red-600 hover:text-red-800 text-sm font-semibold transition duration-200">
                            </form>
                            <span class="text-gray-600"><?= $like_count['likes_count'] ?> J'aime</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto px-6 py-4 text-center">
            <p>&copy; 2024 Instagram Clone. Tous droits réservés.</p>
        </div>
    </footer>

</body>

</html>
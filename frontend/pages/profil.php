<?php
require_once '../../db/connect_db.php';
session_start();

if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
} else {
    header("Location: ../index.php ");
}

$sql = "SELECT photo_url, texteimage, id FROM photo WHERE user_id = :user_id;";
try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_STR);
    $stmt->execute();
    $photo = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Profil Instagram</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<div class="max-w-6xl mx-auto mt-10 bg-white shadow-xl rounded-lg overflow-hidden">
    
    <div class="p-8 flex items-center border-b">
        <div class="flex-shrink-0">
            <div class="w-20 h-20 rounded-full bg-gray-300"></div>
        </div>
        <div class="ml-6 flex-1">
            <div class="flex items-center space-x-6">
                <h1 class="text-3xl font-semibold text-gray-800"><?= htmlspecialchars($user) ?></h1>
                <button class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">Suivre</button>
            </div>
            <div class="mt-2 flex space-x-10 text-gray-700">
                <div>
                    <span class="font-semibold">150</span> publications
                </div>
                <div>
                    <span class="font-semibold">300</span> abonnés
                </div>
                <div>
                    <span class="font-semibold">180</span> abonnements
                </div>
            </div>
            <p class="mt-4 text-gray-600">Ceci est la biographie de l'utilisateur. Partagez quelque chose d'intéressant sur vous ici !</p>
        </div>
    </div>

   
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 p-8">
        <?php foreach ($photo as $image): ?>
            <?php
                // Récupérer le nombre de likes pour chaque photo
                $sql_like_count = "SELECT COUNT(*) AS likes_count FROM liker WHERE photo_id = :photo_id";
                $stmt_like_count = $pdo->prepare($sql_like_count);
                $stmt_like_count->bindParam(':photo_id', $image['id'], PDO::PARAM_INT);
                $stmt_like_count->execute();
                $like_count = $stmt_like_count->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="flex flex-col">
                <img src="<?= "../" . $image['photo_url'] ?>" alt="Publication" class="w-full h-full object-cover rounded-t-lg">
                <p class="text-center text-sm mt-2 text-gray-800 bg-white bg-opacity-80 p-2"><?= htmlspecialchars($image['texteimage']) ?></p>

                <!-- Affichage du compteur de likes -->
                <div class="flex items-center justify-center mt-3 space-x-4 p-2 bg-white bg-opacity-90">
                <form action="../../backend/process_like.php" method="POST" id="like-form-<?= $image['id'] ?>">
    <input type="hidden" name="photo_id" value="<?= $image['id'] ?>">
    <input type="submit" name="like" value="Aimer" 
           class="text-red-600 hover:text-red-800 text-sm font-semibold transition duration-200">
</form>


                    <p class="text-center text-sm text-gray-700"><?= $like_count['likes_count'] ?> J'aime</p>
                </div>

                <!-- Bouton Supprimer -->
                <form action="../../backend/process_profil.php" method="POST" class="mt-3">
                    <input type="hidden" name="photo_id" value="<?= $image['id'] ?>">
                    <button type="submit" name="delete" class="text-red-600 hover:text-red-800 text-sm font-semibold transition duration-200">
                        Supprimer
                    </button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Section Ajouter une publication -->
    <div class="p-8 bg-gray-50 border-t">
        <form enctype="multipart/form-data" action="../../backend/process_profil.php" method="post" class="space-y-6">
            <input type="hidden" name="user_id" value="<?= $_SESSION["user_id"] ?>">

            <div class="space-y-4">
                <label for="photo" class="block text-lg font-medium text-gray-700">Choisir une image</label>
                <input type="file" name="photo" id="photo" accept="image/*" required class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>

            <div class="space-y-4">
                <label for="texteimage" class="block text-lg font-medium text-gray-700">Description</label>
                <input type="text" name="texteimage" id="texteimage" required class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>

            <button type="submit" class="w-full bg-green-500 text-white py-3 rounded-lg text-lg font-semibold hover:bg-green-600 transition duration-300">Ajouter une publication</button>
        </form>
    </div>

</div>

</body>
</html>

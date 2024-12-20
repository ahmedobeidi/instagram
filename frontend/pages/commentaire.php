<?php 
require_once '../../db/connect_db.php';
session_start();


if (!isset($_SESSION["user"])) {
    header("Location: ../../frontend/pages/connexion.php");
    exit;
} else {
    $user = $_SESSION["user"];
}

$img = $_GET['id'];

$sql = "SELECT user.username, photo_url, texteimage, photo.id, user_id FROM photo 
INNER JOIN user ON user.id = photo.user_id WHERE photo.id = :img";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':img', $img, PDO::PARAM_INT);
    $stmt->execute();
    $photo = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    echo "Erreur lors de la requête : " . $error->getMessage();
    exit;
}


// Récupérer les commentaires associés à l'image
$sql =  "SELECT commentaire.sms, user.username FROM commentaire
         INNER JOIN user ON user.id = commentaire.user_id
         WHERE commentaire.photo_id = :img";
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":img" => $img]);
    $commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC); 
} catch (PDOException $error) {
    echo "Erreur lors de la requête : " . $error->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment page</title>
    <!-- <link rel="stylesheet" href="../css/output.css"> -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100">

<header>
    <!-- Navbar -->
    <nav class="bg-white shadow-md py-4">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <div class="w-[150px]">
                <a href="../../index.php"><img src="../../assets/logo.png" alt="Logo"></a>
            </div>
            <div class="space-x-6">
                <a href="../../index.php" class="text-gray-700 hover:text-blue-600">Accueil</a>
                <a href="./profil.php?id=<?= $user_id = $_SESSION['user_id']; ?>" class="text-gray-700 hover:text-blue-600"><?= htmlspecialchars($user) ?></a>
            </div>
        </div>
    </nav>
</header>

<main class="flex flex-col justify-center items-center h-[100vh]">
    <section>
        
        <article class="flex flex-col gap-3">
            <!-- Vérification et affichage de l'image -->
            <?php if ($photo): ?>
                <p class="text-xs text-gray-500">Photo poste par <span class="text-red-500"><?= $photo['username'] ?></span> </p>
                <img src="<?= "../". $photo['photo_url'] ?>" alt="Publication" class="w-full h-64 object-cover rounded-lg shadow-md">
           
            <?php endif; ?>
        </article>

        <!-- Affichage des commentaires -->
        <article class="flex flex-col gap-2 xl:justify-center px-4 md:px-6 lg:px-8">
            <?php foreach ($commentaires as $commentaire): ?>
                <div class="flex items-start p-2 gap-3 sm:p-3 md:p-4 shadow-lg">
                    <p class="text-white font-sans font-medium text-sm sm:text-base md:text-lg">
                        <h3 class="block font-medium"><?= htmlspecialchars($commentaire['username']) ?>: </h3>
                        <span class="font-light text-red-400"><?= htmlspecialchars($commentaire['sms']) ?></span>
                    </p>
                </div>
            <?php endforeach; ?>
        </article>

        <!-- Formulaire pour ajouter un commentaire -->
        <form action="../../backend/process_commentaire.php" method="post" class="flex items-center justify-between px-3 py-4 bg-gray-800 rounded-lg shadow-lg">
            <input type="text" name="sms" id="sms" placeholder="Ajoutez un commentaire" class="bg-black text-white w-[70%] p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <input type="hidden" name="id" id="id" value="<?= $img ?>">
            <button type="submit" class="bg-indigo-500 p-2 rounded-lg hover:bg-indigo-600 transition duration-200 w-[20%]">Ajouter</button>
        </form> 
    </section>
</main>

</body>
</html>
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../css/output.css">
    <style>
        @media only screen and (max-width: 1024px) {
            #sidenav {
                display: none;
            }
        }
    </style>
    <script defer src="../js/main.js"></script>
</head>

<body>
    <!-- sidenav -->

    <main class="lg:flex lg:flex-row">

        <section class="lg:w-[20vw]">
            <div id="sidenav" class="fixed lg:h-[100vh] lg:w-[20vw] z-10 overflow-x-hidden flex flex-col px-8 py-10 gap-5 border-r-[2px] border-r-off-gray">
                <a href=""><img src="../../assets/logo.png" alt="logo" class="w-[103px] h-[29px] mb-6"></a>
                <div class="flex flex-row gap-3 items-center hover:bg-off-gray">
                    <img src="../../assets/home-icon.jpg" alt="" class="w-8 h-8">
                    <a href="../../index.php" class="">Home</a>
                </div>

                <div class="flex flex-row gap-3 items-center bg-off-gray">
                    <img src="../../assets/profile-icon.png" alt="" class="w-8 h-8">
                    <a href="" class="">Profile</a>
                </div>
            </div>
        </section>

        <section class="lg:w-[79vw]">
            <div class="px-4 py-6 lg:w-[80vw]">
                <div class="flex flex-col items-center">
                    <div class="flex flex-row items-center justify-between w-full mb-4 md:justify-around">
                        <img src="../../assets/300.png" alt="Profile Picture" class="w-[80px] rounded-full lg:w-[150px]">
                        <div class="flex flex-row gap-6 text-center md:text-left">
                            <p class="mb-2 text-[17px] lg:text-[20px]"><span class="font-bold">126</span><br> posts</p>
                            <p class="mb-2 text-[17px] lg:text-[20px]"><span class="font-bold">427</span> <br> followers</p>
                            <p class="mb-2 text-[17px] lg:text-[20px]"><span class="font-bold">427</span><br> following</p>
                        </div>
                    </div>

                    <p class="text-center font-semibold text-lg lg:text-[23px]"><?= $user ?></p>
                    <p class="text-center text-gray-600">Designer</p>

                    <div class="flex flex-col mt-6 lg:w-[80vw]">
                        <div class="flex items-center w-full  h-[44px] bg-off-gray justify-center ">
                            <img src="../../assets/grid-icon.png" class="w-8 h-8 text-gray-600"></img>
                        </div>

                        <div class="w-[375px] p-4 lg:w-full">
                            <div class="w-full lg:flex lg:flex-row lg:flex-wrap lg:gap-4">
                                <?php foreach ($photo as $image): ?>

                                    <div div class="flex flex-col mb-4 bg-off-gray lg:w-[32%] shadow-xl">
                                        <img src="<?= "../" . $image['photo_url'] ?>" alt="Publication" class="w-full h-full object-cover rounded-t-lg">
                                        <p class="text-center text-sm mt-2 text-gray-800 bg-white bg-opacity-80"><?= htmlspecialchars($image['texteimage']) ?></p>

                                        <!-- Affichage du compteur de likes -->
                                        <div class="flex items-center justify-center space-x-4 bg-white bg-opacity-90 mt-2">
                                            <form action="../../backend/process_like.php" method="POST" id="like-form-<?= $image['id'] ?>">
                                                <input type="hidden" name="photo_id" value="<?= $image['id'] ?>">

                                            </form>

                                        </div>

                                        <!-- Bouton Supprimer -->
                                        <form action="../../backend/process_profil.php" method="POST" class="mt-3">
                                            <input type="hidden" name="photo_id" value="<?= $image['id'] ?>">
                                            <button type="submit" name="delete" class="text-off-red text-sm font-semibold transition duration-200">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="p-8 bg-gray-50 w-[50vw]">
                                <div id="addButton" class="bg-dark-green text-off-white w-[150px] lg:w-fit p-2 rounded-full cursor-pointer">Ajouter une Image</div>
                                <form enctype="multipart/form-data" action="../../backend/process_profil.php" method="post" class="space-y-6 w-[400px] hidden" id="addForm">
                                    <input type="hidden" name="user_id" value="<?= $_SESSION["user_id"] ?>">

                                    <div class="space-y-4">
                                        <label for="photo" class="block text-lg font-medium text-gray-700">Choisir une image</label>
                                        <input type="file" name="photo" id="photo" accept="image/*" required class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                                    </div>

                                    <div class="space-y-4">
                                        <label for="texteimage" class="block text-lg font-medium text-gray-700">Description</label>
                                        <input type="text" name="texteimage" id="texteimage" required class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                                    </div>

                                    <button type="submit" class="w-full bg-green-500 text-white py-3 rounded-lg text-lg font-semibold bg-dark-green transition duration-300 text-off-white">Ajouter une publication</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>


</body>

</html>
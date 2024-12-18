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
    <title>Instagram Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      
        .liked {
            color: black; 
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-gray-50">

<div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-lg overflow-hidden">

    <div class="p-6 flex items-center border-b">
        <div class="flex-shrink-0">
          
            <div class="w-16 h-16 rounded-full bg-gray-300"></div>
        </div>
        <div class="ml-6">
            <div class="flex items-center space-x-4">
                <h1 class="text-3xl font-bold text-gray-800"><?= htmlspecialchars($user) ?></h1>
                <button class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 transition">Follow</button>
            </div>
            <div class="mt-2 flex space-x-8 text-gray-700">
                <div>
                    <span class="font-semibold">150</span> posts
                </div>
                <div>
                    <span class="font-semibold">300</span> followers
                </div>
                <div>
                    <span class="font-semibold">180</span> following
                </div>
            </div>
            <p class="mt-4 text-gray-600">This is the user bio. Share something interesting about yourself here!</p>
        </div>
    </div>

    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 p-6">
        <?php foreach ($photo as $image): ?>
            <div class="flex flex-col aspect-square overflow-hidden rounded-lg shadow-md hover:scale-105 hover:shadow-xl transition duration-300">
                <img src="<?= "../" .($image['photo_url']) ?>" alt="Post" class="w-full h-full object-cover">
                <p class="text-center text-sm mt-2 text-gray-800 bg-white bg-opacity-80 p-2"><?= htmlspecialchars($image['texteimage']) ?></p>
                
                
                <form action="../../backend/process_like.php" method="POST">
                    <input type="hidden" name="photo_id" value=<?= $image["id"]  ?>>
                    <button type="submit" name="like" class="like-btn text-red-600 hover:text-red-800 text-sm">
                        Like
                    </button>
                </form>
                <?php 
    if (isset($_SESSION['like_status_' . $image['id']])) {
        $status = $_SESSION['like_status_' . $image['id']];
        
        if ($status == 'liked') {
            echo '<p class="text-green-500 font-semibold bg-green-100 p-2 rounded-md mt-2 text-center">Vous avez déjà aimé cette photo</p>';
           
            unset($_SESSION['like_status_' . $image['id']]);
        } else if ($status == 'disliked') {
            echo '<p class="text-red-500 font-semibold bg-red-100 p-2 rounded-md mt-2 text-center">Like retiré</p>';
          
            unset($_SESSION['like_status_' . $image['id']]);
        }
    }
?>

            </div>
        <?php endforeach; ?>
    </div>

   
    <div class="p-6 bg-gray-50 border-t">
        <form enctype="multipart/form-data" action="../../backend/process_profil.php" method="post" class="space-y-6">
            <input type="hidden" name="user_id" value="<?= $_SESSION["user_id"] ?>">

            <div class="space-y-2">
                <label for="photo" class="block text-lg font-medium text-gray-700">Choose an Image</label>
                <input type="file" name="photo" id="photo" accept="image/*" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>

            <div class="space-y-2">
                <label for="texteimage" class="block text-lg font-medium text-gray-700">Description</label>
                <input type="text" name="texteimage" id="texteimage" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>

            <button type="submit" class="w-full bg-green-500 text-white py-3 rounded-lg text-lg font-semibold hover:bg-green-600 transition duration-300">Add Post</button>
        </form>
       
    </div>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const likeButtons = document.querySelectorAll('button[name="like"]');
        
        likeButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault(); 
                button.classList.toggle('liked'); 
                

               
                this.closest('form').submit(); 
            });
        });
    });
</script>

</body>
</html>

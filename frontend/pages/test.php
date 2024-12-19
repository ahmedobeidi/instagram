<section class="px-4 py-6 lg:w-[80vw]">
            <div class="flex flex-col items-center">
                <div class="flex flex-row items-center justify-between w-full mb-4 md:justify-around">
                    <img src="../../assets/300.png" alt="Profile Picture" class="w-[80px] md:w-[20%] rounded-full">
                    <div class="flex flex-row gap-6 text-center md:text-left">
                        <p class="mb-2 text-[17px] md:text-3xl"><span class="font-bold">126</span><br> posts</p>
                        <p class="mb-2 text-[17px] md:text-3xl"><span class="font-bold">427</span> <br> followers</p>
                        <p class="mb-2 text-[17px] md:text-3xl"><span class="font-bold">427</span><br> following</p>
                    </div>
                </div>

                <p class="text-center font-semibold text-lg">Username</p>
                <p class="text-center text-gray-600">Designer</p>

                <div class="flex flex-col mt-6">
                    <div class="flex items-center h-[44px] bg-off-gray justify-center gap-9">
                        <img src="../../assets/grid-icon.png" class="w-8 h-8 text-gray-600"></img>
                    </div>

                    <div class="w-[375px] p-4">
                        <div class="w-full">
                            <?php foreach ($photo as $image): ?>
                                <?php
                                // Récupérer le nombre de likes pour chaque photo
                                $sql_like_count = "SELECT COUNT(*) AS likes_count FROM liker WHERE photo_id = :photo_id";
                                $stmt_like_count = $pdo->prepare($sql_like_count);
                                $stmt_like_count->bindParam(':photo_id', $image['id'], PDO::PARAM_INT);
                                $stmt_like_count->execute();
                                $like_count = $stmt_like_count->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <div div class="flex flex-col mb-4 bg-off-gray">
                                    <img src="<?= "../" . $image['photo_url'] ?>" alt="Publication" class="w-full h-full object-cover rounded-t-lg">
                                    <p class="text-center text-sm mt-2 text-gray-800 bg-white bg-opacity-80"><?= htmlspecialchars($image['texteimage']) ?></p>

                                    <!-- Affichage du compteur de likes -->
                                    <div class="flex items-center justify-center space-x-4 bg-white bg-opacity-90 mt-2">
                                        <form action="../../backend/process_like.php" method="POST" id="like-form-<?= $image['id'] ?>">
                                            <input type="hidden" name="photo_id" value="<?= $image['id'] ?>">
                                            <input type="submit" name="like" value="Aimer" class="text-dark-green text-sm font-semibold transition duration-200">
                                        </form>
                                        <p class="text-center text-sm"><?= $like_count['likes_count'] ?> J'aime</p>
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
                        <div class="p-8 bg-gray-50">
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
                </div>
            </div>
        </section>
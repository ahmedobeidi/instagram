<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/output.css">
</head>
<body>

    <main class="flex flex-col gap-10 h-[100vh] justify-center items-center">
        <?php
        session_start();
        if (isset($_SESSION["mdp"])) {
            echo "<p style='color: red; text-align: center;'>" . $_SESSION["mdp"] . "</p>";
            unset($_SESSION["mdp"]);
        }
        ?>
        <section class="flex flex-col gap-10 items-center w-[90%]">
            <img src="../../assets/logo.png" alt="Logo">
            <form action="../../backend/process_connexion.php" method="post" class="flex flex-col gap-3 font-SF">
                <input type="text" name="nom" id="nom" placeholder="Username" class="w-[343px] h-[44px] bg-off-gray text-[14px] px-3" required>
                <input type="password" name="password" id="password" placeholder="Password" class="w-[343px] h-[44px] bg-off-gray text-[14px] px-3" required>
                <input type="submit" value="Login" id="password" class="w-[343px] h-[44px] bg-off-blue text-off-white text-[14px] mt-3 px-3">
            </form>
        </section>
        <section class="flex flex-col items-center">
            <h2 class="text-dark-gray">OR</h2>
            <h3 class="text-dark-gray">Don't have an account? <a href="./inscription.php" class="text-dark-blue">Singup</a></h3>
        </section>
    </main>

</body>
</html>

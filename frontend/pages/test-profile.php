<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <link rel="stylesheet" href="../css/output.css">
    <style>

@media only screen and (max-width: 1024px) {
  #sidenav {
    display: none;
  }
}
</style>
</head>
<body>
<!-- sidenav -->

    <main class="lg:flex lg:flex-row">
        <section id="sidenav" class="fixed h-[100vh] w-[350px] z-10 overflow-x-hidden flex flex-col px-8 py-10 gap-5 border-r-[2px] border-r-off-gray">
        <a href=""><img src="../../assets/logo.png" alt="logo" class="w-[103px] h-[29px] mb-6"></a>
        <div class="flex flex-row gap-3 items-center hover:bg-off-gray">
            <img src="../../assets/home-icon.jpg" alt="" class="w-8 h-8">    
            <a href="" class="">Home</a>
        </div>
        
        <div class="flex flex-row gap-3 items-center hover:bg-off-gray">
            <img src="../../assets/profile-icon.png" alt="" class="w-8 h-8">    
            <a href="">Profile</a>
        </div>
        </section>


        <section class="px-4 py-6 lg:w-full">
            <div class="flex flex-col items-center">
                <div class="flex flex-row items-center justify-between w-full mb-4 md:justify-around lg:flex-col">
                    <img src="https://via.placeholder.com/150" alt="Profile Picture" class="w-[80px] md:w-[20%] rounded-full">
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

                    <div class="">
                        <div class="flex w-[375px] flex-wrap gap-[2%]">
                            <img src="https://via.placeholder.com/300" alt="Post 1" class="w-[32%] pb-2">
                            <img src="https://via.placeholder.com/300" alt="Post 1" class="w-[32%] pb-2">
                            <img src="https://via.placeholder.com/300" alt="Post 1" class="w-[32%] pb-2">
                            <img src="https://via.placeholder.com/300" alt="Post 1" class="w-[32%] pb-2">
                            <img src="https://via.placeholder.com/300" alt="Post 1" class="w-[32%] pb-2">
                            <img src="https://via.placeholder.com/300" alt="Post 1" class="w-[32%] pb-2">
                            <img src="https://via.placeholder.com/300" alt="Post 1" class="w-[32%] pb-2">
                            <img src="https://via.placeholder.com/300" alt="Post 1" class="w-[32%] pb-2">
                            <img src="https://via.placeholder.com/300" alt="Post 1" class="w-[32%] pb-2">
                        </div> 
                    </div>
                </div>
            </div>
        </section>
    </main>
    

</body>
</html>
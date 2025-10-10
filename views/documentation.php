<!-- Header -->
    <?php
    $pageTitle = "Documentation"; // Define el título de la página
    include '../includes/header.php';
    ?>



<section class="hero" 
    style="
        background-image: url('/images/general/Blog(5).png'); 
        background-size: cover; 
        background-position: center; 
        background-repeat: no-repeat; 
        min-height: 100vh; 
        padding-top: 150px; /* Separación superior */
    ">
    <div class="container h-100 d-flex flex-column justify-content-center   py-5">
        <!-- Hero Section -->
        <section class="text-center">
            <div class="container">
               <!-- 503 -->
                <?php  
                include '../errors/503.php';
                ?> 
            </div>
        </section>

    </div>


<!-- Footer -->
    <?php  
    include '../includes/footer.php';
    ?>


<?php include_once __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>
  <meta charset="UTF-8">
  <!-- META -->
  <meta name="description" content="Engraving and design studio services in Charlottetown, PEI. We specialize in personalized products such as custom signage, corporate gifts, wedding décor, trophies, tumblers, and home décor items.
   Our focus is on premium finishes, modern designs, and attention to detail.">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Pou Technologies, all rights reserved">
  <meta name="theme-color" content="">
  <title>
    <?php echo isset($pageTitle) ? $pageTitle : COMPANY_NAME . " | Engraving and design studio services in Charlottetown, PEI"; ?>
  </title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/images/favicon/favicon.ico" type="image/x-icon">

  <!-- Schema Markup para SEO local -->
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "<?php echo COMPANY_NAME; ?>",
      "image": "https://www.pixellaserprints.com/images/logo/logo.png",
      "description": "Engraving and design studio services in Charlottetown, PEI",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "<?php echo COMPANY_ADDRESS; ?>",
        "addressLocality": "<?php echo COMPANY_CITY; ?>",
        "addressRegion": "<?php echo COMPANY_PROVINCE; ?>",
        "postalCode": "<?php echo COMPANY_POSTAL_CODE; ?>",
        "addressCountry": "<?php echo COMPANY_COUNTRY; ?>"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": "46.25648928923273",
        "longitude": "-63.1255973750424"
      },
      "telephone": "<?php echo COMPANY_PHONE_TEL; ?>",
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": [
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
        ],
        "opens": "07:00",
        "closes": "18:00"
      },
      "url": "https://www.pixellaserprints.ca/"
    }
  </script>
  <!-- Fin del Schema Markup -->


  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-03VJ2X3RH9"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-03VJ2X3RH9');
  </script>


  <!-- ICONS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Google Fonts nav-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,600;0,700;1,900&family=Rubik+Vinyl&display=swap"
    rel="stylesheet">

  <!-- Google Fonts Body-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400..700&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- CSS Stylesheet -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/style/css/css.css?v=2">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>


  <nav class="navbar navbar-expand-lg navbar-dark bg-transparent position-absolute w-100 site-navbar">
    <div class="container">
      <a class="navbar-brand" href="<?php echo BASE_URL; ?>/index.php">
        <img src="<?php echo BASE_URL; ?>/images/logo/logo.png" alt="Pixel logo" class="img-fluid site-logo">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto site-nav">
          <li class="nav-item"><a class="nav-link text-white" href="<?php echo BASE_URL; ?>/index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link text-white"
              href="<?php echo BASE_URL; ?>/views/services.php">Services</a></li>
           <li class="nav-item"><a class="nav-link text-white"
              href="<?php echo BASE_URL; ?>/views/catalog.php">Catalog</a></li>   
          <li class="nav-item"><a class="nav-link text-white"
              href="<?php echo BASE_URL; ?>/views/contact.php">Contact</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="<?php echo BASE_URL; ?>/views/about.php">About
              Us</a></li>    
        </ul>
      </div>
    </div>
  </nav>



</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bike</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="style/header.css" rel="stylesheet" />
    <link href="style/Client/accueilC.css" rel="stylesheet" />
    <?php
    if ($page == "magasinE") {
        echo '<link href="style/magasin.css" rel="stylesheet" />';
    }
    if ($page == "gestionE") {
        echo '<link href="style/Employee/gestionE.css" rel="stylesheet" />';
    }
    if ($page == "insert") {
        echo '<link href="style/insert.css" rel="stylesheet" />';
    }
    if ($page == "update") {
        echo '<link href="style/update.css" rel="stylesheet" />';
    }
    if ($page == "account") {
        echo '<link href="style/account.css" rel="stylesheet" />';
    }
    ?>
    <link href="style/footer.css" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-black w-100">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="assets/bike.png" alt="Bicycle Icon" width="40" height="40" class="me-2">
                    <span class="fw-bold">BikeShop</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white fw-semibold" href="index.php?action=accueilE">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white fw-semibold" href="index.php?action=magasinE">Stores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white fw-semibold" href="index.php?action=GestionE">Management</a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center">
                        <a href="index.php?action=logout" class="text-white text-decoration-none d-flex align-items-center me-3 icon">
                            <span class="fw-semibold">Logout</span>
                        </a>
                        <a href="index.php?action=accountE" class="text-white text-decoration-none d-flex align-items-center icon">
                            <span class="fw-semibold">My Account</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>
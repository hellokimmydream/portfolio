<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Portfolio - Accueil</title>
    <link rel="stylesheet" href="styles.css">
    <script src="comportement.js" defer></script>
</head>
<body>
<div class="page">
    <!-- HEADER -->
    <header class="header">
        <!--<button id = "dark-btn">Night</button>-->
        <div class="logo-image">
            <img src="logo.jpg" alt="Logo">
        </div>
        <nav class="nav">
            <a href="accueil.php" class="active">HOME</a>
            <a href="projets.php">PROJETS</a>
            <a href="theorie.php">THEORIE</a>
            <a href="modules.php">MODULES</a>
        </nav>
        <div class="search-container">
            <div class="search"></div>

            <div class="search-box">
                <input type="text" id ="search-input" placeholder="Rechercher...">
                <ul id ="suggestionBox"></ul>
            </div>
        </div>
    </header>

    <!-- HERO -->
    <div class="hero">
        <div class="hero-title">PORTFOLIO</div>
        <button>Entrer <span>→</span></button>
    </div>

    <!-- ABOUT -->
    <section class="about">
        <div class="about-img"></div>
        <div class="about-text">
            <h2>About me</h2>
            <p>
                Camille Rais, étudiante informaticienne en développement d'applications.
            </p>
        </div>
    </section>

    <!-- modal pop up pour la section about me-->
     <!-- quand on clique sur la photo une fenetre apparait avec plus d'info-->
    <div class="modal" id="bio-modal">
        <div class="modal-content">
            <h2>Camille Rais</h2>
            <p>Etudiante informaticienne en développement d'applications</p>
            <button id="close-modal">Fermer</button>
        </div>
    </div>
</div>
</body>
</html>
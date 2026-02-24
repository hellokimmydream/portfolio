<?php
require 'includes/db.php';

// Récupération des modules
$modules = $pdo->query("
    SELECT module_id, nom_module, description_module, date_debut_module, date_fin_module
    FROM t_modules
    ORDER BY module_id
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Portfolio - Modules</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="page">
    <header class="header">
        <div class="logo-image">
            <img src="logo.jpg" alt="Logo">
        </div>
        <nav class="nav">
            <a href="accueil.php">HOME</a>
            <a href="projets.php">PROJETS</a>
            <a href="theorie.php">THEORIE</a>
            <a href="modules.php" class="active">MODULES</a>
        </nav>
    </header>

    <div class="page-title-block">
        <h1>Modules</h1>
        <p>Liste des modules suivis, notes par thème.</p>
    </div>

    <!-- LISTE DES MODULES EN HAUT -->
    <div class="modules-list">
        <h2>Mes modules</h2>
        <ul>
            <?php foreach($modules as $mod): ?>
                <li>
                    <a href="#module-<?php echo $mod['module_id']; ?>"><?php echo htmlspecialchars($mod['nom_module']); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- SECTION DETAILLEE DES MODULES -->
    <div class="modules-detail">
        <?php foreach($modules as $mod): ?>
        <div class="module-item" id="module-<?php echo $mod['module_id']; ?>">
            <div class="module-header">
                <div class="module-name"><?php echo htmlspecialchars($mod['nom_module']); ?></div>
                <div class="arrow">→</div>
            </div>
            <div class="module-content">
                <p><strong>Description :</strong> 
                <?php 
                    echo isset($mod['description_module']) && $mod['description_module'] 
                        ? htmlspecialchars($mod['description_module']) 
                        : "Pas de description disponible"; 
                ?>
                </p>

                <p><strong>Date début :</strong> <?php echo $mod['date_debut_module'] ?? "N/A"; ?></p>
                <p><strong>Date fin :</strong> <?php echo $mod['date_fin_module'] ?? "N/A"; ?></p>
                <p><strong>Note finale :</strong> 4.3</p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Script JS pour l'interactivité des modules -->
<script>
document.addEventListener("DOMContentLoaded", () => {

    // Accordéon : ouvrir / fermer module au clic sur la flèche
    document.querySelectorAll(".module-header").forEach(header => {
        header.addEventListener("click", () => {
            const moduleItem = header.parentElement;
            moduleItem.classList.toggle("open");
        });
    });

    // Scroll vers module détaillé lorsqu'on clique dans la liste en haut
    document.querySelectorAll(".modules-list a").forEach(link => {
        link.addEventListener("click", e => {
            e.preventDefault();
            const targetId = link.getAttribute("href").substring(1);
            const target = document.getElementById(targetId);
            if(target) {
                target.scrollIntoView({ behavior: "smooth", block: "start" });
                // Ouvrir automatiquement le module au scroll
                target.classList.add("open");
            }
        });
    });
});
</script>
</body>
</html>

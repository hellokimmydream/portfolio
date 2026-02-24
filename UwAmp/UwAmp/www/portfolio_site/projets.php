<?php
require 'includes/db.php';

// Récupération des projets avec professeur et module
$projets = $pdo->query("
    SELECT p.projet_id, p.nom_projet, p.description, 
           pr.nom AS professeur_nom, 
           m.nom_module AS module_nom
    FROM t_projets p
    LEFT JOIN t_professeur pr ON p.professeur_id = pr.professeur_id
    LEFT JOIN t_modules m ON p.module_id = m.module_id
")->fetchAll(PDO::FETCH_ASSOC);

// Récupération des résultats des projets
$resultats = $pdo->query("
    SELECT projet_id, resultat, pourcentage_resultat, date_evaluation
    FROM t_resultats_projets
")->fetchAll(PDO::FETCH_ASSOC);

// Organiser les résultats par projet pour un accès facile
$resultatsParProjet = [];
foreach($resultats as $r){
    $resultatsParProjet[$r['projet_id']] = $r;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Portfolio - Projets</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="page">
    <header class="header">
        <div class="logo-image">
            <img src="logo.jpg" alt="Logo">
        </div>
        <nav class="nav">
            <a href="index.php">HOME</a>
            <a href="projets.php" class="active">PROJETS</a>
            <a href="theorie.php">THEORIE</a>
            <a href="modules.php">MODULES</a>
        </nav>
    </header>

    <div class="page-title-block">
        <h1>Projets</h1>
        <p>Découvrez tous mes projets récents avec détails et compétences.</p>
        <div class="line"></div>
    </div>

    <div class="projets-wrapper">
        <div class="projets-grid" id="projets-grid">
            <!-- Les projets seront injectés via JS -->
        </div>

        <div class="projet-detail" id="projet-detail">
            <div class="projet-detail-header">
                <h2 id="detail-title">Nom du projet</h2>
            </div>
            <div class="matiere-line"></div>

            <div class="projet-detail-content" id="detail-content">
                <p id="detail-description">Sélectionnez un projet pour voir les détails.</p>
                <p id="detail-professeur"></p>
                <p id="detail-module"></p>
                <p id="detail-resultat"></p>

                <h3>Compétences</h3>
                <ul class="competences-list" id="detail-competences"></ul>
            </div>
        </div>
    </div>
</div>

<script>
// Injection des données PHP en JS
const projets = <?php echo json_encode($projets); ?>;
const skillsParProjet = <?php echo json_encode($skillsParProjet); ?>;
const resultatsParProjet = <?php echo json_encode($resultatsParProjet); ?>;

// Afficher le détail d'un projet
function showDetail(id) {
    const projet = projets.find(p => p.projet_id == id);
    if(!projet) return;

    const resultat = resultatsParProjet[id] || null;

    document.getElementById('detail-title').innerText = projet.nom_projet;
    document.getElementById('detail-description').innerText = projet.description;
    document.getElementById('detail-professeur').innerText = "Professeur : " + projet.professeur_nom;
    document.getElementById('detail-module').innerText = "Module : " + projet.module_nom;
    document.getElementById('detail-resultat').innerText = resultat
        ? `Résultat : ${resultat.resultat} (${resultat.pourcentage_resultat}%) le ${resultat.date_evaluation}`
        : "Pas encore évalué";

    const ul = document.getElementById('detail-competences');
    ul.innerHTML = "";
    const skills = skillsParProjet[id] || [];
    skills.forEach(s => {
        const li = document.createElement('li');
        li.textContent = s;
        ul.appendChild(li);
    });
}

// Exemple d'affichage des projets dans la grille (simplifié)
const grid = document.getElementById('projets-grid');
projets.forEach(p => {
    const div = document.createElement('div');
    div.className = "projet-card";
    div.innerText = p.nom_projet;
    div.onclick = () => showDetail(p.projet_id);
    grid.appendChild(div);
});
</script>
</body>
</html>


<script>
document.addEventListener("DOMContentLoaded", () => {

    // Données injectées depuis PHP
    const projets = <?php echo json_encode($projets); ?>;
    const skillsParProjet = <?php echo json_encode($skillsParProjet); ?>;
    const resultatsParProjet = <?php echo json_encode($resultatsParProjet); ?>;

    // Containers
    const grid = document.querySelector(".projets-grid");
    const detail = document.querySelector(".projet-detail");
    const title = document.getElementById("detail-title");
    const desc = document.getElementById("detail-description");
    const prof = document.getElementById("detail-professeur");
    const mod = document.getElementById("detail-module");
    const resultatEl = document.getElementById("detail-resultat");
    const competencesList = document.querySelector(".competences-list");

    if (!grid || !projets) return;

    // Créer les cartes projets
    projets.forEach(proj => {
        const card = document.createElement("div");
        card.classList.add("projet-card");
        card.dataset.id = proj.projet_id;
        card.innerHTML = `
            <div class="projet-title">${proj.nom_projet}</div>
            <div class="projet-module">${proj.module_nom || ""}</div>
        `;
        grid.appendChild(card);

        card.addEventListener("click", () => {
            // Remplir le détail du projet
            if (title) title.textContent = proj.nom_projet;
            if (desc) desc.textContent = proj.description || "Pas de description disponible";
            if (prof) prof.textContent = "Professeur : " + (proj.professeur_nom || "Non défini");
            if (mod) mod.textContent = "Module : " + (proj.module_nom || "Non défini");

            // Résultat
            const res = resultatsParProjet[proj.projet_id];
            if (resultatEl) {
                resultatEl.textContent = res
                    ? `Résultat : ${res.resultat} (${res.pourcentage_resultat}%) le ${res.date_evaluation}`
                    : "Pas encore évalué";
            }

            // Compétences
            if (competencesList) {
                competencesList.innerHTML = "";
                const skills = skillsParProjet[proj.projet_id] || [];
                skills.forEach(s => {
                    const li = document.createElement("li");
                    li.textContent = s;
                    competencesList.appendChild(li);
                });
            }

            // Ouvrir le détail et scroller
            detail?.classList.add("open");
            detail?.scrollIntoView({ behavior: "smooth", block: "start" });
        });
    });

});
</script>

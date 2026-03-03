<template>
  <div class="page">
    <!-- Bloc titre et barre toujours affiché -->
    <div class="page-title-block">
      <h1>Projets</h1>
      <p>Découvrez tous mes projets récents avec détails et compétences.</p>
      <div class="line"></div>
    </div>

    <!-- Liste des projets -->
    <div class="projets-list">
      <div v-for="p in projets" :key="p.projet_id" class="projet-row">
        <!-- Bloc gauche (skills) -->
        <div class="projet-left">
          <div class="skills-mock">
            <span v-for="s in skills[p.projet_id] || []" :key="s">
              {{ s }}
            </span>
          </div>
        </div>

        <!-- Lettre centrale -->
        <div class="projet-letter">
          {{ p.nom_projet.charAt(0) }}
        </div>

        <!-- Bloc droite -->
        <div class="projet-right">
          <h3>{{ p.nom_projet }}</h3>
          <p>{{ p.description }}</p>
        </div>
      </div>

      <!-- Message si aucun projet -->
      <div v-if="projets.length === 0" class="no-projets">
        Aucun projet à afficher pour le moment.
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProjetList",
  data() {
    return {
      projets: [],
      skills: {},
    };
  },
  mounted() {
    fetch("http://localhost/portfolio/api/getProjets.php")
      .then((res) => res.json())
      .then((data) => {
        console.log("Données reçues :", data);
        this.projets = data.projets || [];
        this.skills = data.skills || {};
      })
      .catch((err) => console.error("Erreur fetch :", err));
  },
};
</script>

<style scoped>
.projets-list {
  margin-top: 40px;
}

.projet-row {
  display: grid;
  grid-template-columns: 200px 120px 1fr;
  align-items: center;
  gap: 40px;
  padding: 60px 0;
  border-bottom: 1px solid #ccc;
}

/* Bloc gauche */
.projet-left {
  position: relative;
}

.skills-mock {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.skills-mock span {
  background: #ddd;
  padding: 6px 12px;
  font-size: 12px;
}

/* Lettre centrale */
.projet-letter {
  font-size: 100px;
  font-weight: 300;
  text-align: center;
}

/* Bloc droite */
.projet-right h3 {
  font-size: 18px;
  margin-bottom: 10px;
}

.projet-right p {
  font-size: 14px;
  color: #444;
  line-height: 1.6;
  max-width: 500px;
}

@media (max-width: 900px) {
  .projet-row {
    grid-template-columns: 1fr;
    text-align: center;
  }

  .projet-letter {
    font-size: 60px;
  }
}
</style>

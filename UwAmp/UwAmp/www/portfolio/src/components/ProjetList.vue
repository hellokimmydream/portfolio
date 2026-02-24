<template>
  <div class="page">
    <div class="page-title-block">
      <h1>Projets</h1>
      <p>Découvrez tous mes projets récents avec détails et compétences.</p>
      <div class="line"></div>
    </div>

    <div class="projets-wrapper">
      <!-- Grille de projets -->
      <div class="projets-grid">
        <div
          v-for="p in projets"
          :key="p.projet_id"
          class="projet-card"
          @click="selectProjet(p)"
        >
          <div class="projet-title">{{ p.nom_projet }}</div>
          <div class="projet-module">{{ p.module_nom || "" }}</div>
        </div>
      </div>

      <!-- Détail du projet -->
      <div class="projet-detail" v-if="projetSelectionne">
        <div class="projet-detail-header">
          <h2>{{ projetSelectionne.nom_projet }}</h2>
        </div>
        <div class="matiere-line"></div>
        <div class="projet-detail-content">
          <p>{{ projetSelectionne.description }}</p>
          <p>
            Professeur : {{ projetSelectionne.professeur_nom || "Non défini" }}
          </p>
          <p>Module : {{ projetSelectionne.module_nom || "Non défini" }}</p>
          <p>
            Résultat :
            <span v-if="resultats[projetSelectionne.projet_id]">
              {{ resultats[projetSelectionne.projet_id].resultat }}
              ({{
                resultats[projetSelectionne.projet_id].pourcentage_resultat
              }}%) le
              {{ resultats[projetSelectionne.projet_id].date_evaluation }}
            </span>
            <span v-else>Pas encore évalué</span>
          </p>

          <h3>Compétences</h3>
          <ul class="competences-list">
            <li v-for="s in skills[projetSelectionne.projet_id] || []" :key="s">
              {{ s }}
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProjetList",
  props: {
    projets: { type: Array, required: true },
    skills: { type: Object, default: () => ({}) },
    resultats: { type: Object, default: () => ({}) },
  },
  data() {
    return {
      projetSelectionne: null,
    };
  },
  methods: {
    selectProjet(projet) {
      this.projetSelectionne = projet;
      // Scroll vers le détail
      this.$nextTick(() => {
        const el = this.$el.querySelector(".projet-detail");
        el?.scrollIntoView({ behavior: "smooth", block: "start" });
      });
    },
  },
};
</script>

<style scoped>
/* Reprendre styles des cartes projets et détail */
.projets-wrapper {
  display: flex;
  gap: 20px;
}
.projets-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 15px;
}
.projet-card {
  cursor: pointer;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
.projet-detail {
  margin-top: 20px;
  border-top: 1px solid #ccc;
  padding-top: 15px;
}
</style>

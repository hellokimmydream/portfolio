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
.projets-wrapper {
  margin-right: 30px;
}
.projets-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 25px;
  margin-top: 20px;
}
.projet-card {
  background: #f5f5f5;
  padding: 20px;
  border-radius: 12px;
  cursor: pointer;
  transition: transform 0.3s ease;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.projet-card:hover {
  transform: translateY(-5px);
  background: #e0e0e0;
}
.projet-title {
  font-weight: 600;
  font-size: 16px;
}
.projet-detail {
  display: flex;
  flex-direction: column;
  gap: 15px;
}
.projet-detail-content {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.5s ease;
}
.projet-detail.open .projet-detail-content {
  max-height: auto;
}
.competences-list {
  margin-top: 10px;
  list-style: none;
}
.competences-list li {
  margin-bottom: 5px;
  background: #eee;
  padding: 5px 10px;
  border-radius: 5px;
  display: inline-block;
  margin-right: 5px;
  font-size: 14px;
}
</style>

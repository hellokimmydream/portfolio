<template>
  <div class="page">
    <div class="page-title-block">
      <h1>Projets</h1>
      <p>Liste des projets réalisés</p>
    </div>

    <ul class="projets-list">
      <li v-for="projet in projets" :key="projet.projet_id">
        <div class="projet-item" @click="toggleProjet(projet)">
          <div class="projet-name">
            {{ projet.nom_projet }}
          </div>

          <div
            class="result-badge"
            :class="{
              acquis: projet.resultat === 'acquis',
              nonacquis: projet.resultat === 'non acquis',
            }"
          >
            {{ projet.resultat }}
          </div>

          <div class="arrow">
            {{ projet.open ? "↓" : "→" }}
          </div>
        </div>

        <div class="projet-content" v-if="projet.open">
          <p>
            <strong>Module :</strong>
            {{ projet.nom_module || "Non défini" }}
          </p>

          <p>
            <strong>Description :</strong>
            {{ projet.description || "Pas de description" }}
          </p>

          <p>
            <strong>Date début :</strong>
            {{ projet.date_projet_debut }}
          </p>

          <p>
            <strong>Date fin :</strong>
            {{ projet.date_fin_projet }}
          </p>

          <p>
            <strong>Résultat :</strong>
            {{ projet.resultat }}
          </p>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "ProjetList",

  data() {
    return {
      projets: [],
    };
  },

  async mounted() {
    try {
      const res = await fetch("http://localhost/portfolio/api/getProjets.php");
      const data = await res.json();

      this.projets = data.map((p) => ({
        ...p,
        open: false,
      }));
    } catch (error) {
      console.error("Erreur API :", error);
    }
  },

  methods: {
    toggleProjet(projet) {
      projet.open = !projet.open;
    },
  },
};
</script>

<style scoped>
.page {
  max-width: 900px;
  margin: auto;
}

.projets-list {
  list-style: none;
  padding-left: 0;
}

.projet-item {
  display: grid;
  grid-template-columns: 1fr auto auto;
  align-items: center;
  cursor: pointer;
  font-size: 16px;
  padding: 12px;
  background: #f5f5f5;
  margin-bottom: 6px;
  border-radius: 6px;
  transition: background 0.2s;
}

.projet-item:hover {
  background: #ececec;
}

.projet-name {
  font-weight: 600;
}

.arrow {
  margin-left: 10px;
}

.projet-content {
  padding: 12px;
  border-left: 3px solid #ccc;
  margin-bottom: 15px;
  background: #fafafa;
}

.result-badge {
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 13px;
  margin-right: 10px;
}

.acquis {
  background: #c8f7c5;
  color: #1e7d32;
}

.nonacquis {
  background: #ffd6d6;
  color: #b71c1c;
}
</style>

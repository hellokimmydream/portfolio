<template>
  <div class="page">
    <div class="page-title-block">
      <h1>Projets</h1>
      <p>Liste des projets réalisés</p>
    </div>

    <ul class="projets-list">
      <li v-for="projet in projets" :key="projet.projet_id">
        <div class="projet-item" @click="toggleProjet(projet)">
          <div class="projet-name">{{ projet.nom_projet }}</div>
          <div class="arrow">→</div>
        </div>
        <div class="projet-content" v-if="projet.open">
          <p>
            <strong>Description :</strong>
            {{ projet.description || "Pas de description" }}
          </p>
          <p><strong>Date début :</strong> {{ projet.date_debut || "N/A" }}</p>
          <p><strong>Date fin :</strong> {{ projet.date_fin || "N/A" }}</p>
          <p>
            <strong>Technologies :</strong> {{ projet.technologies || "N/A" }}
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
  mounted() {
    fetch("http://localhost/www/portfolio/api/getProjets.php")
      .then((res) => res.json())
      .then((data) => (this.projets = data.map((p) => ({ ...p, open: false }))))
      .catch((err) => console.error(err));
  },
  methods: {
    toggleProjet(projet) {
      projet.open = !projet.open;
    },
  },
};
</script>

<style scoped>
.projets-list {
  padding-left: 0;
  list-style: none;
}

.projet-item {
  display: flex;
  justify-content: space-between;
  cursor: pointer;
  font-size: 16px;
  padding: 10px;
  background: #f5f5f5;
  margin-bottom: 5px;
  border-radius: 6px;
}

.arrow {
  transition: transform 0.3s ease;
}

.projet-content {
  padding: 10px;
  border-left: 2px solid #ccc;
  margin-bottom: 15px;
}
</style>

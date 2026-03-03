<template>
  <div class="page">
    <h1>Cours de théorie</h1>
    <ul class="matieres-list">
      <li v-for="matiere in matieres" :key="matiere.nom">
        <div class="matiere-header" @click="toggle(matiere)">
          <span>{{ matiere.nom }}</span>
          <span class="arrow">→</span>
        </div>
        <div class="matiere-content" v-if="matiere.open">
          <div class="notes">
            <span v-for="(note, i) in matiere.notes" :key="i">{{ note }}</span>
          </div>
          <ul>
            <li v-for="(sujet, i) in matiere.sujets" :key="i">{{ sujet }}</li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "TheorieList",
  data() {
    return {
      matieres: [],
    };
  },
  mounted() {
    fetch("http://localhost/www/portfolio/api/getTheorie.php")
      .then((res) => res.json())
      .then(
        (data) => (this.matieres = data.map((m) => ({ ...m, open: false }))),
      )
      .catch((err) => console.error(err));
  },
  methods: {
    toggle(matiere) {
      matiere.open = !matiere.open;
    },
  },
};
</script>

<style scoped>
.matieres-list {
  list-style: none;
  padding-left: 0;
}

.matiere-header {
  display: flex;
  justify-content: space-between;
  cursor: pointer;
  padding: 10px;
  background: #f0f0f0;
  margin-bottom: 5px;
  border-radius: 6px;
}

.arrow {
  transition: transform 0.3s ease;
}

.matiere-content {
  padding: 10px;
  border-left: 2px solid #ccc;
  margin-bottom: 15px;
}

.notes span {
  display: inline-block;
  margin-right: 5px;
  font-weight: bold;
}
</style>

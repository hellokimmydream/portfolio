<template>
  <div class="page">
    <div class="page-title-block">
      <h1>Cours de théorie suivis & résultats</h1>
      <div class="line"></div>
    </div>

    <div class="list-matieres">
      <div
        v-for="matiere in matieres"
        :key="matiere.nom"
        class="matiere"
        :class="{ open: matiere.open }"
      >
        <div class="matiere-header" @click="toggle(matiere.nom)">
          <div class="matiere-name">{{ matiere.nom }}</div>
          <div class="arrow">→</div>
        </div>

        <div class="matiere-content">
          <div class="notes-grid">
            <div
              class="note-bar"
              v-for="(note, index) in matiere.notes"
              :key="index"
            >
              <div class="value" :style="{ width: note * 20 + '%' }"></div>
              <div class="label">{{ note }}</div>
            </div>
          </div>

          <ul>
            <li v-for="(sujet, index) in matiere.sujets" :key="index">
              {{ sujet }}
            </li>
          </ul>
        </div>
      </div>
    </div>
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
    fetch("http://localhost/portfolio/api/getMatieres.php")
      .then((res) => res.json())
      .then((data) => {
        this.matieres = data.map((m) => ({ ...m, open: false }));
      })
      .catch((err) => console.error(err));
  },
  methods: {
    toggle(nom) {
      const mat = this.matieres.find((m) => m.nom === nom);
      if (mat) mat.open = !mat.open;
    },
  },
};
</script>

<style scoped>
.list-matieres {
  margin: 30px 30px;
}

.matiere {
  margin-bottom: 25px;
}

.matiere-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
  font-size: 18px;
}

.matiere-name {
  font-size: 14px;
  font-weight: 500;
}

.arrow {
  transition: transform 0.3s ease;
  font-size: 22px;
}

.matiere.open .arrow {
  transform: rotate(90deg);
}

.matiere-content {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.45s ease-in-out;
  margin-top: 10px;
}

.matiere.open .matiere-content {
  max-height: 800px;
}

.notes-grid {
  display: flex;
  gap: 10px;
  margin-bottom: 15px;
}

.note-bar {
  background: #f5f5f5;
  border-radius: 6px;
  width: 20px;
  position: relative;
  display: flex;
  align-items: flex-end;
  justify-content: center;
  flex-direction: column;
  padding: 2px;
}

.value {
  background: #b5b0ad;
  width: 100%;
  height: 100%;
  border-radius: 6px 6px 0 0;
}

.label {
  font-size: 12px;
  text-align: center;
  margin-top: 2px;
}

ul {
  padding-left: 20px;
  list-style-type: disc;
}

li {
  margin-bottom: 5px;
  font-size: 14px;
}
</style>

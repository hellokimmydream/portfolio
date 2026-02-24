<template>
  <div class="list-matieres">
    <div v-for="matiere in matieres" :key="matiere.nom" class="matiere">
      <div class="matiere-header" @click="toggle(matiere.nom)">
        <div class="matiere-name">{{ matiere.nom }}</div>
        <div class="arrow" :class="{ open: matiere.open }">→</div>
      </div>

      <div
        class="matiere-content"
        :style="{ maxHeight: matiere.open ? '800px' : '0' }"
      >
        <div class="notes-grid">
          <div class="note-col">
            <div
              class="note-bar"
              v-for="(note, index) in matiere.notes"
              :key="index"
            >
              <div class="value" :style="{ width: note * 20 + '%' }"></div>
              <div class="label">{{ note }}</div>
            </div>
          </div>
          <div class="note-text-list">
            <div
              class="note-text-item"
              v-for="(sujet, index) in matiere.sujets"
              :key="index"
            >
              <b>{{ sujet }}</b>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      matieres: [],
    };
  },
  mounted() {
    fetch("/api/getMatieres.php")
      .then((res) => res.json())
      .then((data) => {
        this.matieres = data.map((m) => ({ ...m, open: false }));
      })
      .catch((err) => console.error(err));
  },
  methods: {
    toggle(nom) {
      const mat = this.matieres.find((m) => m.nom === nom);
      mat.open = !mat.open;
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
.matiere-content {
  overflow: hidden;
  transition: max-height 0.45s ease-in-out;
}
.arrow {
  transition: transform 0.3s ease;
  font-size: 22px;
}
.arrow.open {
  transform: rotate(90deg);
}
.note-col {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
  margin-top: 10px;
}
.note-bar {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-right: 10px;
}
.value {
  height: 10px;
  background: #444;
  margin-bottom: 3px;
  border-radius: 4px;
}
.label {
  font-size: 12px;
}
.note-text-list {
  margin-top: 10px;
}
</style>

<template>
  <div class="page">
    <div class="page-title-block">
      <h1>Cours de théorie suivis & résultats obtenus</h1>
      <div class="line"></div>
    </div>

    <div class="list-matieres">
      <div
        class="matiere"
        v-for="matiere in matieres"
        :key="matiere.nom_module"
      >
        <div class="matiere-header" @click="toggleMatiere(matiere.nom_module)">
          <div class="matiere-name">{{ matiere.nom_module }}</div>
          <div class="arrow">→</div>
        </div>
        <div class="matiere-line"></div>
        <div class="matiere-content" v-show="matiere.open">
          <div class="notes-grid">
            <div class="note-col">
              <div
                class="note-bar"
                v-for="(note, idx) in matiere.notes || []"
                :key="idx"
              >
                <div class="value" :style="{ width: note * 20 + '%' }"></div>
                <div class="label">{{ note }}</div>
              </div>
            </div>
            <div class="note-text-list">
              <div
                class="note-text-item"
                v-for="(sujet, idx) in matiere.sujets || []"
                :key="idx"
              >
                <b>{{ sujet.nom || "Sujet" }}</b> {{ sujet.description || "" }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="moyenne">
      Moyenne obtenue <span>{{ moyenneGlobale }}</span>
    </div>
  </div>
</template>

<script>
export default {
  name: "TheorieList",
  props: {
    matieres: { type: Array, required: true },
  },
  data() {
    return {};
  },
  computed: {
    moyenneGlobale() {
      // Calcul simple : moyenne de toutes les notes
      const toutesNotes = this.matieres.flatMap((m) => m.notes || []);
      if (!toutesNotes.length) return 0;
      const sum = toutesNotes.reduce((a, b) => a + b, 0);
      return (sum / toutesNotes.length).toFixed(2);
    },
  },
  methods: {
    toggleMatiere(nom) {
      const m = this.matieres.find((m) => m.nom_module === nom);
      if (m) m.open = !m.open;
    },
  },
};
</script>

<style scoped>
.matiere-content {
  transition: all 0.3s;
}
.arrow {
  cursor: pointer;
}
</style>

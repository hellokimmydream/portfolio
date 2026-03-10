<template>
  <div class="page">
    <div class="page-title-block">
      <h1>Cours de théorie</h1>
      <p>Liste des matières et notes</p>
    </div>

    <ul class="matieres-list">
      <li v-for="matiere in matieres" :key="matiere.matiere_theorie_id">
        <!-- Header cliquable -->
        <div class="matiere-item" @click="toggleMatiere(matiere)">
          <div class="matiere-name">{{ matiere.nom }}</div>
          <div class="notes-count" v-if="matiere.notes.length">
            {{ matiere.notes.length }} note{{
              matiere.notes.length > 1 ? "s" : ""
            }}
          </div>
          <div class="arrow">{{ matiere.open ? "↓" : "→" }}</div>
        </div>

        <!-- Contenu -->
        <div class="matiere-content" v-if="matiere.open">
          <div class="notes">
            <span
              v-for="(note, i) in matiere.notes"
              :key="i"
              :class="{
                acquis: note >= 4.0,
                nonacquis: note < 4.0,
              }"
            >
              {{ Number(note).toFixed(2) }}
            </span>
          </div>

          <ul class="sujets-list" v-if="matiere.sujets?.length">
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
  async mounted() {
    try {
      const res = await fetch("http://localhost/portfolio/api/getTheorie.php");
      const data = await res.json();
      this.matieres = data.map((m, index) => ({
        ...m,
        open: index === 0, // première matière ouverte
      }));
    } catch (err) {
      console.error("Erreur API :", err);
    }
  },
  methods: {
    toggleMatiere(matiere) {
      matiere.open = !matiere.open;
    },
  },
};
</script>

<style scoped>
.page {
  max-width: 900px;
  margin: 20px auto;
}

.page-title-block {
  margin-bottom: 20px;
}

.matieres-list {
  list-style: none;
  padding-left: 0;
}

.matiere-item {
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

.matiere-item:hover {
  background: #ececec;
}

.matiere-name {
  font-weight: 600;
}

.arrow {
  margin-left: 10px;
  font-weight: bold;
}

.notes-count {
  margin-right: 10px;
  font-size: 13px;
  color: #555;
}

/* Contenu */
.matiere-content {
  padding: 12px;
  border-left: 3px solid #ccc;
  margin-bottom: 15px;
  background: #fafafa;

  display: block;
  min-height: 65px;
}

/* Notes */
.notes {
  display: flex;
  flex-wrap: wrap; /* permet aux notes de passer à la ligne */
  gap: 8px;
}

.notes span {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 50px;
  padding: 6px 10px;
  border-radius: 4px;
  font-size: 14px;
  font-weight: 600;
  text-align: center;
  white-space: nowrap;
}

.acquis {
  background: #c8f7c5;
  color: #1e7d32;
}

.nonacquis {
  background: #ffd6d6;
  color: #b71c1c;
}

.sujets-list {
  margin-top: 10px;
  padding-left: 20px;
}

.sujets-list li {
  margin-bottom: 4px;
}
</style>

<template>
  <div class="page">
    <div class="page-title-block">
      <h1>Cours de théorie</h1>
      <p>Liste des matières et notes</p>
    </div>

    <ul class="matieres-list">
      <li v-for="matiere in matieres" :key="matiere.matiere_theorie_id">
        <!-- header avec lien cliquable -->
        <div class="matiere-item" @click="toggleMatiere(matiere)">
          <div class="matiere-name">{{ matiere.nom }}</div>
          <div class="notes-count" v-if="matiere.notes.length">
            {{ matiere.notes.length }} note{{
              matiere.notes.length > 1 ? "s" : ""
            }}
          </div>
          <div class="arrow">{{ matiere.open ? "↓" : "→" }}</div>
        </div>

        <!-- content page -->
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

          <button class="btn-edit" @click.stop="editNotes(matiere)">
            Ajouter / Modifier les notes
          </button>

          <ul class="sujets-list" v-if="matiere.sujets?.length">
            <li v-for="(sujet, i) in matiere.sujets" :key="i">{{ sujet }}</li>
          </ul>
        </div>
      </li>
    </ul>

    <!-- modal pour note theorie -->
    <div class="modal" v-if="showForm">
      <div class="modal-content">
        <h2>Notes pour {{ currentMatiere.nom }}</h2>
        <form @submit.prevent="submitNotes">
          <div v-for="(note, i) in currentNotes" :key="i" class="note-input">
            <input
              type="number"
              step="0.01"
              min="0"
              max="20"
              v-model.number="currentNotes[i]"
            />
            <button type="button" @click="removeNote(i)">×</button>
          </div>
          <button type="button" @click="addNote">+ Ajouter une note</button>
          <div class="modal-buttons">
            <button type="submit">Enregistrer</button>
            <button type="button" @click="closeForm">Annuler</button>
          </div>
        </form>
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
      showForm: false,
      currentMatiere: {},
      currentNotes: [],
    };
  },
  async mounted() {
    await this.loadMatieres();
  },
  methods: {
    toggleMatiere(matiere) {
      matiere.open = !matiere.open;
    },
    editNotes(matiere) {
      this.currentMatiere = matiere;
      this.currentNotes = [...matiere.notes];
      this.showForm = true;
      window.scrollTo({ top: 0, behavior: "smooth" });
    },
    closeForm() {
      this.showForm = false;
      this.currentNotes = [];
      this.currentMatiere = {};
    },
    addNote() {
      this.currentNotes.push(0);
    },
    removeNote(index) {
      this.currentNotes.splice(index, 1);
    },
    async submitNotes() {
      if (!this.currentMatiere.matiere_theorie_id) return;

      try {
        const res = await fetch(
          "http://localhost/portfolio/api/saveNotes.php",
          {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
              matiere_id: this.currentMatiere.matiere_theorie_id,
              notes: this.currentNotes,
            }),
          },
        );
        const data = await res.json();

        if (data.success) {
          alert("Notes enregistrées !");
          this.closeForm();
          this.loadMatieres();
        } else {
          alert("Erreur lors de l'enregistrement : " + (data.error || ""));
        }
      } catch (err) {
        console.error(err);
        alert("Erreur lors de l'enregistrement.");
      }
    },
    async loadMatieres() {
      try {
        const res = await fetch(
          "http://localhost/portfolio/api/getTheorie.php",
        );
        const data = await res.json();
        this.matieres = data.map((m, index) => ({ ...m, open: index === 0 }));
      } catch (err) {
        console.error(err);
      }
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
.matiere-content {
  padding: 12px;
  border-left: 3px solid #ccc;
  margin-bottom: 15px;
  background: #fafafa;
  min-height: 135px;
}
.notes {
  display: flex;
  flex-wrap: wrap;
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
  background: #dff8dd;
  color: #3f6447;
}
.nonacquis {
  background: #f7e8e8;
  color: #b71c1c;
}
.sujets-list {
  margin-top: 10px;
  padding-left: 20px;
}
.sujets-list li {
  margin-bottom: 4px;
}
.btn-edit {
  background: #7994ac;
  color: white;
  border: none;
  padding: 6px 12px;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
  margin-top: 8px;
  transition: background 0.2s;
  margin-top: 50px;
}
.btn-edit:hover {
  background: #374450;
}

/* modal */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.4);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}
.modal-content {
  background: white;
  padding: 20px;
  border-radius: 10px;
  width: 400px;
  max-width: 90%;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.modal-content input {
  width: 100%;
  padding: 8px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 14px;
  margin-bottom: 4px;
}
.note-input {
  display: flex;
  gap: 4px;
}
.modal-buttons {
  display: flex;
  justify-content: flex-end;
  gap: 8px;
}
.modal-buttons button {
  padding: 6px 12px;
  border-radius: 6px;
  border: none;
  cursor: pointer;
}
.modal-buttons button[type="submit"] {
  background: #78997a;
  color: white;
}
.modal-buttons button[type="button"] {
  background: #f44336;
  color: white;
}
</style>

<template>
  <div class="page">
    <div class="page-title-block">
      <h1>Projets</h1>
      <p>Liste des projets réalisés</p>

      <!-- bouton pour ouvrir modal -->
      <button class="btn-add" @click="openForm()">+ Ajouter un projet</button>
    </div>

    <!-- form pour add projet -->
    <div class="modal" v-if="showForm">
      <div class="modal-content">
        <h2>
          {{
            nouveauProjet.projet_id ? "Modifier un projet" : "Ajouter un projet"
          }}
        </h2>
        <form @submit.prevent="submitProjet">
          <input
            v-model="nouveauProjet.nom_projet"
            placeholder="Nom du projet (obligatoire)"
            required
          />
          <input v-model="nouveauProjet.nom_module" placeholder="Module" />
          <textarea
            v-model="nouveauProjet.description"
            placeholder="Description"
          ></textarea>
          <input type="date" v-model="nouveauProjet.date_projet_debut" />
          <input type="date" v-model="nouveauProjet.date_fin_projet" />
          <select v-model="nouveauProjet.resultat">
            <option value="">-- Résultat --</option>
            <option value="acquis">Acquis</option>
            <option value="non acquis">Non acquis</option>
          </select>
          <div class="modal-buttons">
            <button type="submit">
              {{ nouveauProjet.projet_id ? "Mettre à jour" : "Ajouter" }}
            </button>
            <button type="button" @click="closeForm">Annuler</button>
          </div>
        </form>
      </div>
    </div>

    <!-- les projet list -->
    <ul class="projets-list">
      <li v-for="projet in projets" :key="projet.projet_id">
        <div class="projet-item" @click="toggleProjet(projet)">
          <div class="projet-name">{{ projet.nom_projet }}</div>
          <div
            class="result-badge"
            :class="{
              acquis: projet.resultat === 'acquis',
              nonacquis: projet.resultat === 'non acquis',
            }"
          >
            {{ projet.resultat }}
          </div>
          <div class="arrow">{{ projet.open ? "↓" : "→" }}</div>
        </div>

        <div class="projet-content" v-if="projet.open">
          <p>
            <strong>Module :</strong> {{ projet.nom_module || "Non défini" }}
          </p>
          <p>
            <strong>Description :</strong>
            {{ projet.description || "Pas de description" }}
          </p>
          <p>
            <strong>Date début :</strong>
            {{ projet.date_projet_debut || "Non défini" }}
          </p>
          <p>
            <strong>Date fin :</strong>
            {{ projet.date_fin_projet || "Non défini" }}
          </p>
          <p>
            <strong>Résultat :</strong> {{ projet.resultat || "Non défini" }}
          </p>

          <button class="btn-edit" @click.stop="editProjet(projet)">
            Modifier ce projet
          </button>
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
      showForm: false,
      nouveauProjet: {
        projet_id: null,
        nom_projet: "",
        nom_module: "",
        description: "",
        date_projet_debut: "",
        date_fin_projet: "",
        resultat: "",
      },
    };
  },
  async mounted() {
    await this.loadProjets();
  },
  methods: {
    toggleProjet(projet) {
      projet.open = !projet.open;
    },
    openForm() {
      this.resetForm();
      this.showForm = true;
    },
    editProjet(projet) {
      this.nouveauProjet = {
        projet_id: projet.projet_id || null,
        nom_projet: projet.nom_projet || "",
        nom_module: projet.nom_module || "",
        description: projet.description || "",
        date_projet_debut: projet.date_projet_debut || "",
        date_fin_projet: projet.date_fin_projet || "",
        resultat: projet.resultat || "",
      };
      this.showForm = true;
      window.scrollTo({ top: 0, behavior: "smooth" });
    },
    closeForm() {
      this.showForm = false;
      this.resetForm();
    },
    resetForm() {
      this.nouveauProjet = {
        projet_id: null,
        nom_projet: "",
        nom_module: "",
        description: "",
        date_projet_debut: "",
        date_fin_projet: "",
        resultat: "",
      };
    },
    async submitProjet() {
      if (!this.nouveauProjet.nom_projet.trim()) {
        alert("Nom du projet obligatoire !");
        return;
      }

      try {
        console.log("Envoi JSON :", this.nouveauProjet);

        const res = await fetch(
          "http://localhost/portfolio/api/saveProjet.php",
          {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(this.nouveauProjet),
          },
        );

        const data = await res.json();
        console.log("Réponse PHP :", data);

        if (data.success) {
          alert("Projet enregistré !");
          this.closeForm();
          this.loadProjets();
        } else {
          alert("Erreur lors de l'enregistrement : " + (data.error || ""));
        }
      } catch (err) {
        console.error(err);
        alert("Erreur lors de l'enregistrement.");
      }
    },
    async loadProjets() {
      try {
        const res = await fetch(
          "http://localhost/portfolio/api/getProjets.php",
        );
        const data = await res.json();
        this.projets = data.map((p) => ({ ...p, open: false }));
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
  background: #ddf5dc;
  color: #3f6447;
}
.nonacquis {
  background: #f7e8e8;
  color: #b71c1c;
}
.btn-add {
  background: #78997a;
  color: white;
  border: none;
  padding: 6px 12px;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
  margin-top: 8px;
  transition: background 0.2s;
}
.btn-add:hover {
  background: #455e45;
}
.btn-edit {
  background: #859db1;
  color: white;
  border: none;
  padding: 6px 12px;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
  margin-top: 8px;
  transition: background 0.2s;
}
.btn-edit:hover {
  background: #374450;
}
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
.modal-content input,
.modal-content textarea,
.modal-content select {
  width: 100%;
  padding: 8px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 14px;
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

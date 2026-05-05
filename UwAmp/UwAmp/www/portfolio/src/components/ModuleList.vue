<template>
  <div class="page">
    <div class="page-title-block">
      <h1>Modules</h1>
      <p>Liste des modules</p>

      <!-- bouton pour ajouter un module -->
      <button class="btn-add" @click="openForm()">+ Ajouter un module</button>
    </div>

    <!-- form modal -->
    <div class="modal" v-if="showForm">
      <div class="modal-content">
        <h2>
          {{
            nouveauModule.module_id ? "Modifier un module" : "Ajouter un module"
          }}
        </h2>
        <form @submit.prevent="submitModule">
          <input
            v-model="nouveauModule.nom_module"
            placeholder="Nom du module (obligatoire)"
            required
          />
          <textarea
            v-model="nouveauModule.description_module"
            placeholder="Description"
          ></textarea>
          <div class="modal-buttons">
            <button type="submit">
              {{ nouveauModule.module_id ? "Mettre à jour" : "Ajouter" }}
            </button>
            <button type="button" @click="closeForm">Annuler</button>
          </div>
        </form>
      </div>
    </div>

    <!-- list modules suivi -->
    <ul class="projets-list">
      <li v-for="mod in modules" :key="mod.module_id">
        <div class="projet-item" @click="toggleModule(mod)">
          <div class="projet-name">{{ mod.nom_module }}</div>
          <div
            class="result-badge"
            :class="{
              acquis: mod.note_finale >= 4.0,
              nonacquis: mod.note_finale < 4.0 || mod.note_finale === null,
            }"
          >
            {{
              mod.note_finale !== null
                ? Number(mod.note_finale).toFixed(2)
                : "N/A"
            }}
          </div>
          <div class="arrow">{{ mod.open ? "↓" : "→" }}</div>
        </div>

        <div class="projet-content" v-if="mod.open">
          <p>
            <strong>Description :</strong>
            {{ mod.description_module || "Pas de description" }}
          </p>
          <button class="btn-edit" @click.stop="editModule(mod)">
            Modifier ce module
          </button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "ModuleList",
  data() {
    return {
      modules: [],
      showForm: false,
      nouveauModule: {
        module_id: null,
        nom_module: "",
        description_module: "",
      },
    };
  },
  async mounted() {
    await this.loadModules();
  },
  methods: {
    toggleModule(mod) {
      mod.open = !mod.open;
    },
    openForm() {
      this.resetForm();
      this.showForm = true;
    },
    editModule(mod) {
      this.nouveauModule = {
        module_id: mod.module_id || null,
        nom_module: mod.nom_module || "",
        description_module: mod.description_module || "",
      };
      this.showForm = true;
      window.scrollTo({ top: 0, behavior: "smooth" });
    },
    closeForm() {
      this.showForm = false;
      this.resetForm();
    },
    resetForm() {
      this.nouveauModule = {
        module_id: null,
        nom_module: "",
        description_module: "",
      };
    },
    async submitModule() {
      if (!this.nouveauModule.nom_module.trim()) {
        alert("Nom du module obligatoire !");
        return;
      }

      try {
        const res = await fetch(
          "http://localhost/portfolio/api/saveModule.php",
          {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(this.nouveauModule),
          },
        );
        const data = await res.json();

        if (data.success) {
          alert("Module enregistré !");
          this.closeForm();
          this.loadModules();
        } else {
          alert("Erreur lors de l'enregistrement : " + (data.error || ""));
        }
      } catch (err) {
        console.error(err);
        alert("Erreur lors de l'enregistrement.");
      }
    },
    async loadModules() {
      try {
        const res = await fetch(
          "http://localhost/portfolio/api/getModules.php",
        );
        const data = await res.json();
        this.modules = data.map((m) => ({ ...m, open: false }));
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
  background: #e4f5e3;
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
  background: #445e45;
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
.modal-content textarea {
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

<template>
  <div class="page">
    <div class="page-title-block">
      <h1>Modules</h1>
      <p>Liste des modules</p>
    </div>

    <ul class="projets-list">
      <li v-for="mod in modules" :key="mod.module_id">
        <div class="projet-item" @click="toggleModule(mod)">
          <div class="projet-name">
            {{ mod.nom_module }}
          </div>

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

          <div class="arrow">
            {{ mod.open ? "↓" : "→" }}
          </div>
        </div>

        <div class="projet-content" v-if="mod.open">
          <p>
            <strong>Description :</strong>
            {{ mod.description_module || "Pas de description" }}
          </p>
          <p>
            <strong>Trimeste :</strong>
            {{ mod.date_debut_module || "Non défini" }}
          </p>
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
    };
  },

  async mounted() {
    try {
      const res = await fetch("http://localhost/portfolio/api/getModules.php");
      const data = await res.json();

      this.modules = data.map((m) => ({
        ...m,
        open: false,
      }));
    } catch (error) {
      console.error("Erreur API :", error);
    }
  },

  methods: {
    toggleModule(mod) {
      mod.open = !mod.open;
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

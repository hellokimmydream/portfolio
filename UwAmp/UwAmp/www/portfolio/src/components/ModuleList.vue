<template>
  <div class="page">
    <h1>Modules</h1>
    <ul class="modules-list">
      <li v-for="mod in modules" :key="mod.module_id">
        <div class="module-item" @click="toggleModule(mod)">
          <span>{{ mod.nom_module }}</span>
          <span class="arrow">→</span>
        </div>
        <div class="module-content" v-if="mod.open">
          <p>
            <strong>Description :</strong>
            {{ mod.description_module }}
          </p>
          <p><strong>Date début :</strong> {{ mod.date_debut_module }}</p>
          <p><strong>Date fin :</strong> {{ mod.date_fin_module }}</p>
          <p><strong>Note finale :</strong> {{ mod.note_finale }}</p>
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
  mounted() {
    fetch("http://localhost/www/portfolio/api/getModules.php")
      .then((res) => res.json())
      .then((data) => (this.modules = data.map((m) => ({ ...m, open: false }))))
      .catch((err) => console.error(err));
  },
  methods: {
    toggleModule(mod) {
      mod.open = !mod.open;
    },
  },
};
</script>

<style scoped>
.modules-list {
  list-style: none;
  padding-left: 0;
}

.module-item {
  display: flex;
  justify-content: space-between;
  cursor: pointer;
  font-size: 16px;
  padding: 10px;
  background: #eef;
  margin-bottom: 5px;
  border-radius: 6px;
}

.arrow {
  transition: transform 0.3s ease;
}

.module-content {
  padding: 10px;
  border-left: 2px solid #99f;
  margin-bottom: 15px;
}
</style>

<template>
  <div class="page">
    <div class="page-title-block">
      <h1>Modules</h1>
      <p>Liste des modules suivis, notes par thème.</p>
    </div>

    <div class="modules-list">
      <h2>Mes modules</h2>
      <ul>
        <li v-for="mod in modules" :key="mod.module_id">
          <a href="#" @click.prevent="scrollToModule(mod.module_id)">{{
            mod.nom_module
          }}</a>
        </li>
      </ul>
    </div>

    <div class="modules-detail">
      <div
        class="module-item"
        v-for="mod in modules"
        :key="mod.module_id"
        :id="'module-' + mod.module_id"
        :class="{ open: mod.open }"
      >
        <div class="module-header" @click="toggleModule(mod)">
          <div class="module-name">{{ mod.nom_module }}</div>
          <div class="arrow">→</div>
        </div>
        <div class="module-content">
          <p>
            <strong>Description :</strong>
            {{ mod.description_module || "Pas de description disponible" }}
          </p>
          <p>
            <strong>Date début :</strong> {{ mod.date_debut_module || "N/A" }}
          </p>
          <p><strong>Date fin :</strong> {{ mod.date_fin_module || "N/A" }}</p>
          <p><strong>Note finale :</strong> {{ mod.note_finale || "N/A" }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ModuleList",
  props: {
    modules: { type: Array, required: true },
  },
  methods: {
    toggleModule(mod) {
      mod.open = !mod.open;
    },
    scrollToModule(id) {
      const el = document.getElementById("module-" + id);
      if (el) {
        el.scrollIntoView({ behavior: "smooth", block: "start" });
        el.open = true;
      }
    },
  },
};
</script>

<style scoped>
.module-item {
  margin-bottom: 25px;
}
.module-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
  font-size: 18px;
}
.module-content {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.45s ease-in-out;
}
.module-item.open .module-content {
  max-height: 800px;
}
.arrow {
  transition: transform 0.3s ease;
  font-size: 22px;
}
.module-item.open .arrow {
  transform: rotate(90deg);
}

.modules-list.ul.li {
  list-style: none;
}
</style>

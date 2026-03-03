<template>
  <div id="app">
    <!-- Header -->
    <site-header @change-page="goTo"></site-header>

    <!-- Pages dynamiques -->
    <hero-section v-if="currentPage === 'accueil'"></hero-section>

    <projet-list v-if="currentPage === 'projets'"></projet-list>

    <theorie-list
      v-if="currentPage === 'theorie'"
      :matieres="modules"
    ></theorie-list>

    <module-list
      v-if="currentPage === 'modules'"
      :modules="modules"
    ></module-list>

    <!-- Footer -->
    <site-footer></site-footer>
  </div>
</template>

<script>
import SiteHeader from "./components/Header.vue";
import SiteFooter from "./components/Footer.vue";
import HeroSection from "./components/Accueil.vue";
import ModuleList from "./components/ModuleList.vue";
import ProjetList from "./components/ProjetList.vue";
import TheorieList from "./components/TheorieList.vue";

export default {
  name: "App",
  components: {
    SiteHeader,
    SiteFooter,
    HeroSection,
    ModuleList,
    ProjetList,
    TheorieList,
  },
  data() {
    return {
      currentPage: "accueil", // page affichée par défaut
      modules: [
        { nom: "Mathématique", notes: [], sujets: [] },
        { nom: "Anglais", notes: [], sujets: [] },
      ],
      // plus besoin de projets ici, ProjetList gère le fetch interne
    };
  },
  methods: {
    goTo(page) {
      this.currentPage = page;
    },
  },
};
</script>

<style>
/* Reset minimal et styles généraux */
body {
  margin: 0;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  background: #f9f9f9;
  color: #333;
}

#app {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}
</style>

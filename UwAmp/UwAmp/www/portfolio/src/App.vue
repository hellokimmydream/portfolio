<template>
  <site-header @change-page="goTo"></site-header>

  <hero-section v-if="currentPage === 'accueil'"></hero-section>
  <projet-list
    v-if="currentPage === 'projets'"
    :projets="projets"
  ></projet-list>
  <theorie-list
    v-if="currentPage === 'theorie'"
    :matieres="modules"
  ></theorie-list>
  <module-list
    v-if="currentPage === 'modules'"
    :modules="modules"
  ></module-list>

  <site-footer></site-footer>
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
      currentPage: "accueil",
      modules: [
        { nom: "Mathématique", notes: [], sujets: [] },
        { nom: "Anglais", notes: [], sujets: [] },
      ],
      projets: [
        {
          id: 1,
          nom: "Projet 1",
          description: "Description du projet",
          resultat: [],
        },
      ],
    };
  },
  methods: {
    goTo(page) {
      this.currentPage = page;
    },
  },
};
</script>

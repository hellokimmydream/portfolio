import { createApp } from "vue";
import "./style.css";

import Header from "./components/Header.js";
import Footer from "./components/Footer.js";
import Hero from "./components/Accueil.js";
import ModuleList from "./components/ModuleList.js";
import ProjetList from "./components/ProjetList.js";
import TheorieList from "./components/TheorieList.js";

const app = createApp({
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

  template: `
    <site-header @change-page="goTo"></site-header>

    <hero-section v-if="currentPage==='accueil'"></hero-section>

    <projet-list
      v-if="currentPage==='projets'"
      :projets="projets"
    ></projet-list>

    <theorie-list v-if="currentPage==='theorie'"></theorie-list>

    <module-list
      v-if="currentPage==='modules'"
      :modules="modules"
    ></module-list>

    <site-footer></site-footer>
  `,
});

app.component("site-header", Header);
app.component("site-footer", Footer);
app.component("hero-section", Hero);
app.component("module-list", ModuleList);
app.component("projet-list", ProjetList);
app.component("theorie-list", TheorieList);

app.mount("#app");

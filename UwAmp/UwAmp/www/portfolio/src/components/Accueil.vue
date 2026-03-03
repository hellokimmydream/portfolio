<template>
  <section>
    <div class="hero" :style="{ backgroundImage: `url(${accueilImage})` }">
      <div class="hero-overlay">
        <div class="hero-title">PORTFOLIO</div>
      </div>
    </div>

    <section class="about">
      <div class="about-img" @click="openModal"></div>
      <div class="about-text">
        <h2>About me</h2>
        <p>Camille Rais, étudiante informaticienne.</p>
      </div>
    </section>

    <div class="modal" v-if="showModal">
      <div class="modal-content">
        <h2>Camille Rais</h2>
        <button @click="showModal = false">Fermer</button>
      </div>
    </div>
  </section>
</template>

<script>
import accueilImage from "../assets/accueil_image.jpg";
export default {
  name: "HeroSection",
  data() {
    return {
      showModal: false,
      accueilImage,
    };
  },
};
</script>

<style scoped>
.hero {
  height: 45vh;
  margin: 0;
  border-radius: 0;
  position: relative;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  display: flex;
  align-items: center;
  justify-content: center;
}
/* Couche sombre transparente */
.hero-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.45);

  display: flex;
  align-items: center;
  justify-content: center;
}

/* Titre mieux intégré */
.hero-title {
  color: white;
  font-size: clamp(2rem, 6vw, 5rem);
  font-weight: 800;
  letter-spacing: 8px;
  text-transform: uppercase;
  text-align: center;
  backdrop-filter: blur(9px);
  padding: 20px 40px;
  border-radius: 10px;
}

.hero button:hover {
  background: #9c9793;
  transform: translateY(-3px);
}

.about {
  display: flex;
  flex-wrap: wrap;
  gap: 30px;
  align-items: flex-start;
  margin: 35px 30px 50px 30px;
}
.about-img {
  flex-shrink: 0;
  width: 150px;
  height: 150px;
  border-radius: 50%;
  border: 2px solid #ccc;
  background: #ddd;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
.about-text {
  flex: 1;
}
.about-text h2 {
  font-size: 18px;
  margin-bottom: 10px;
}
.about-text p {
  font-size: 14px;
  color: #444;
  max-width: 500px;
  line-height: 1.5;
}
</style>

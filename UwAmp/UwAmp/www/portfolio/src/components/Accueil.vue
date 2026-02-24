<template>
  <section>
    <div class="hero">
      <div class="hero-title">PORTFOLIO</div>
      <button @click="openModal">En savoir plus →</button>
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
export default {
  name: "HeroSection",
  data() {
    return { showModal: false };
  },
  methods: {
    openModal() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
  },
};
</script>

<style scoped>
.hero {
  margin: 25px 30px 0 30px;
  border: 1px solid #ccc;
  height: 280px;
  border-radius: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  background: linear-gradient(135deg, #f5f5f5, #e9e9e9);
  position: relative;
}
.hero-title {
  font-size: 34px;
  font-weight: 700;
}
.hero button {
  position: absolute;
  bottom: 25px;
  background: #b5b0ad;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  border-radius: 6px;
  color: #222;
  transition: 0.3s ease;
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

<template>
  <section class="hero">
    <div class="hero-title">PORTFOLIO</div>
    <button @click="$emit('open-modal')">En savoir plus →</button>
  </section>
</template>

<script>
export default {};
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
</style>

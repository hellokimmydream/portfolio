<template>
  <header class="header">
    <div class="logo-image">
      <img src="/src/assets/logo.jpg" alt="Logo" />
    </div>
    <nav class="nav">
      <button @click="$emit('change-page', 'accueil')">HOME</button>
      <button @click="$emit('change-page', 'projets')">PROJETS</button>
      <button @click="$emit('change-page', 'theorie')">THEORIE</button>
      <button @click="$emit('change-page', 'modules')">MODULES</button>
    </nav>
  </header>
</template>

<script>
export default {};
</script>

<style scoped>
.header {
  height: 85px;
  display: flex;
  align-items: center;
  border-bottom: 1px solid #e3e3e3;
  padding: 0 25px;
  justify-content: space-between;
  background: #fafafa;
  gap: 15px;
}
.logo-image img {
  width: 70px;
  height: auto;
  border-radius: 25px;
}
.nav {
  display: flex;
  gap: 35px;
  flex-grow: 1;
  justify-content: center;
}
.nav button {
  background: none;
  border: none;
  font-size: 14px;
  cursor: pointer;
  color: #444;
  position: relative;
}
.nav button::after {
  content: "";
  position: absolute;
  width: 0%;
  height: 2px;
  bottom: -4px;
  left: 0;
  background: #222;
  transition: 0.3s ease;
}
.nav button:hover::after,
.nav button.active::after {
  width: 100%;
}
.nav button.active {
  font-weight: 600;
  color: #111;
}
</style>

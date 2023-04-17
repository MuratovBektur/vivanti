<script setup lang="ts">
import { RouterView } from 'vue-router'
</script>

<template>
  <div class="py-10 px-3 font-main min-h-screen">
    <div class="px-6 py-6 max-w-screen-lg mx-auto">
      <router-view></router-view>
    </div>
  </div>
</template>

<style scoped lang="scss">
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

*,
*:before,
*:after {
  font-family: Roboto, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
</style>

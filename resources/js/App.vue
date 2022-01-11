<template>
  <v-app id="inspire">
    <v-navigation-drawer permanent app>
      <Navigation/>
    </v-navigation-drawer >

    <v-app-bar app>
      <!-- <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon> -->

      <v-toolbar-title>Application</v-toolbar-title>
    </v-app-bar>

    <v-main>
      <router-view :key="$route.fullPath"></router-view>
    </v-main>
  </v-app>
</template>

<script>
import Navigation from './components/layout/Navigation.vue'
export default {
  props: {
    'laravelData': {type: Array},
  },
  name: 'App',
  data: () => ({
    drawer: false,
  }),
  components: {
    Navigation,
  }
}
</script>

<style>
</style>
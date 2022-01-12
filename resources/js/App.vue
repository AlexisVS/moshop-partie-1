<template>
  <v-app id="inspire">
    <v-navigation-drawer temporary v-model="drawer" app>
      <Navigation />
    </v-navigation-drawer>

    <v-app-bar app dense>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title>Molengeek Shop Partie 1</v-toolbar-title>
      <v-row>
        <v-spacer></v-spacer>
        <v-col cols="12" class="d-flex justify-end align-center">
          <v-switch hide-details @click="$vuetify.theme.dark = !$vuetify.theme.dark"></v-switch>
          <div>
            <v-btn elevation="0" small color="primary" rounded class="mx-3">Connexion</v-btn>
            <v-btn
              elevation="5"
              class="black--text"
              color="white"
              small
              rounded
              @click="registerOverlay = !registerOverlay"
            >inscription</v-btn>
          </div>
        </v-col>
      </v-row>
    </v-app-bar>

    <v-main>
      <v-container>
        <v-row>
          <v-col cols="12">
            <Inscription :registerOverlay="registerOverlay" @registerSuccess="registerOverlay = false"/>
            <router-view :key="$route.fullPath"></router-view>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import Navigation from './components/layout/Navigation.vue'
import Inscription from './components/overlay/Inscription.vue';
import axios from 'axios'
export default {
  name: 'App',
  data: () => ({
    drawer: false,
    data: null,
    loginOverlay: false,
    registerOverlay: false,
  }),
  components: {
    Navigation,
    Inscription,
  },
  mounted () {
    this.data = window.data;
    localStorage.clear()
  }
}
</script>

<style>
</style>
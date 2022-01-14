<template>
  <v-app id="inspire">
    <v-navigation-drawer temporary v-model="drawer" app>
      <Navigation />
    </v-navigation-drawer>

    <v-app-bar app>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title>Molengeek Shop Partie 1</v-toolbar-title>
      <v-row>
        <v-spacer></v-spacer>
        <v-col cols="12" class="d-flex justify-end align-center">
          <v-switch class="mr-6" hide-details @click="$vuetify.theme.dark = !$vuetify.theme.dark"></v-switch>
          <div v-if="!isConnected">
            <v-btn
              elevation="0"
              small
              color="primary"
              rounded
              class="mx-3"
              @click="loginOverlay = !loginOverlay"
            >Connexion</v-btn>
            <v-btn
              elevation="5"
              class="black--text"
              color="white"
              small
              rounded
              @click="registerOverlay = !registerOverlay"
            >inscription</v-btn>
          </div>
          <div v-else>
            <Profile @isConnected="isConnected = true" :profile="profile" />
          </div>
        </v-col>
      </v-row>
    </v-app-bar>

    <v-main>
      <v-container>
        <v-row>
          <v-col cols="12">
            <Inscription
              :registerOverlay="registerOverlay"
              @registerSuccess="registerOverlay = false"
            />
            <Connexion :loginOverlay="loginOverlay" @loginSuccess="loginOverlay = false"/>
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
import Connexion from './components/overlay/Connexion.vue';
import Profile from './components/Profile.vue';
export default {
  name: 'App',
  data: () => ({
    drawer: false,
    data: null,
    loginOverlay: false,
    registerOverlay: false,
    isConnected: false,
    profile: null,
  }),
  components: {
    Navigation,
    Inscription,
    Connexion,
    Profile
  },
  mounted () {
    // this.data = window.data;
    axios.get('/app/profile').then(res => {
      if (res.status == 200) {
        this.profile = res.data.data
        this.isConnected = true
      }
    });
  }
}
</script>

<style>
</style>
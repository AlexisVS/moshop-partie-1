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
          <div v-if="!isConnected && !profile">
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
            <Profile
              @isConnected="isConnected = true"
              :profile="profile"
              @openEditProfileOverlay="editProfileOverlay = true"
              @logoutSuccess="profile = null; isConnected = false"
            />
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
              @registerSuccess="registerOverlay = false; loadProfile(); $router.push('/')"
              @closeOverlayInscription="registerOverlay = false"
            />
            <Connexion
              :loginOverlay="loginOverlay"
              @loginSuccess="loginOverlay = false; loadProfile()"
              @closeOverlayConnexion="loginOverlay = false"
            />
            <EditProfile
              v-if="profile"
              :editProfileOverlay="editProfileOverlay"
              :profile="profile"
              @editProfileSuccess="editProfileOverlay = false; loadProfile()"
              @closeOverlayEditProfile="editProfileOverlay = false"
            />
            <router-view
              :key="$route.fullPath"
              v-if="isConnected == true || $route.fullPath == '/'"
            ></router-view>
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
import EditProfile from './components/overlay/EditProfile.vue'
export default {
  name: 'App',
  data: () => ({
    drawer: false,
    data: null,
    loginOverlay: false,
    registerOverlay: false,
    editProfileOverlay: false,
    isConnected: false,
    profile: null,
  }),
  components: {
    Navigation,
    Inscription,
    Connexion,
    Profile,
    EditProfile
  },
  methods: {
    loadProfile () {
      axios.get('/app/profile').then(res => {
        if (res.status == 200) {
          this.profile = res.data.data
          this.isConnected = true
        }
      });
    },
  },
  mounted () {
    // this.data = window.data;
    if (this.isConnected == false || this.profile == null) {
      this.loadProfile()
    }
  }
}
</script>

<style>
</style>
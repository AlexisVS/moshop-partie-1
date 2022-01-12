<template>
  <v-list-item two-line style="width: min-content">
    <v-list-item-avatar  class="mr-2">
      <v-avatar>
        <img :src="'http://localhost:8000/images/' + profile.profile.picture_path" />
      </v-avatar>
    </v-list-item-avatar>
    <v-menu offset-y>
      <template v-slot:activator="{ on, attrs }">
        <v-btn plain :color="$vuetify.theme.dark ? 'white' : 'black'" class="px-2" dark v-bind="attrs" v-on="on">
          {{ profile.profile.first_name + ' ' + profile.profile.last_name }}
        </v-btn>
      </template>
      <v-list>
        <v-list-item to="/logout">
          <v-list-item-content>
            <v-list-item-title></v-list-item-title>
            <v-list-item-subtitle>Logout</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-menu>
  </v-list-item>
</template>

<script>
export default {
  name: 'Profile',
  props: {
    profile: { type: Object, required: true },
  },
  data: () => ({
  }),

}
</script>

<style>
</style>
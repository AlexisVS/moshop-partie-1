<template>
<v-list>
  <v-list-item v-for="item in navigation" :key="'navigation-link-' + item.text.toLowerCase()" :to="item.link">
    <v-list-item-title>{{ item.text }}</v-list-item-title>
  </v-list-item>
  </v-list>  
</template>

<script>
export default {
  data: () => ({
    navigation: [
      {
        text: 'Home',
        link: '/',
      },
      {
        text: 'User',
        link: '/users',
      },
      {
        text: 'Profile',
        link: '/profile',
      },
      {
        text: 'Commandes',
        link: '/commandes',
      },
      {
        text: 'Panier',
        link: '/panier',
      },
      {
        text: 'My shop',
        link: '/my-shop',
      },
      {
        text: 'Liste des shops',
        link: '/shops',
      },
      // {
      //   text: 'Articles',
      //   link: '/articles',
      // },
    ]
  }),
}
</script>

<style>

</style>
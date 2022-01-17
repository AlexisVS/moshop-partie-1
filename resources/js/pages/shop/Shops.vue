<template>
  <v-container v-if="shops">
    <v-row>
      <v-col>
        <h1>All shops</h1>
      </v-col>
    </v-row>
    <v-row v-if="shopsLoaded == false">
      <v-col cols="12" sm="6" md="4" lg="3" xl="2" v-for="n in 20" :key="'skeleton-loader-' + n">
        <v-skeleton-loader type="image, heading, paragraph, actions" loading></v-skeleton-loader>
      </v-col>
    </v-row>
    <v-row v-else>
      <v-col
        v-for="item in shops"
        :key="'product-id-' + item.id"
        cols="12"
        sm="6"
        md="4"
        lg="3"
        xl="2"
      >
        <v-card :to="'/shops/' + item.id">
          <v-card-title>{{ item.name }}</v-card-title>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>


<script>
import axios from "axios"
export default {
  name: 'Shops',
  data: () => ({
    shops: null,
    shopsLoaded: null,
  }),
  mounted () {
    axios.get('/app/shops')
      .then(res => { this.shops = res.data.data; this.shopsLoaded = true })
      .catch(err => { console.log(err); })
  }
}
</script>

<style>
</style>
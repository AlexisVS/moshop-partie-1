<template>
  <div>
    <v-container v-if="shop">
      <v-row v-if="shop.shop.name">
        <v-col>
          <h1>{{ shop.shop.name }}</h1>
        </v-col>
      </v-row>
      <v-row v-if="shopLoaded == false">
        <v-col cols="12" sm="6" md="4" lg="3" xl="2" v-for="n in 20" :key="'skeleton-loader-' + n">
          <v-skeleton-loader type="image, heading, paragraph, actions" loading></v-skeleton-loader>
        </v-col>
      </v-row>
      <v-row v-else>
        <v-col
          v-for="item in shop.products"
          :key="'product-id-' + item.id"
          cols="12"
          sm="6"
          md="4"
          lg="3"
          xl="2"
        >
          <v-card :to="'/article/' + item.id">
            <v-img aspect-ratio="1" :src="'http://127.0.0.1:8000/images/' + item.cover_path"></v-img>
            <v-card-title>{{ item.name }}</v-card-title>
            <v-card-text class="text-truncate">{{ item.description }}</v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import axios from "axios"
export default {
  data: () => ({
    shop: null,
    shopLoaded: false,
  }),
  mounted () {
    axios.get('/app/home')
      .then(res => { this.shop = res.data; this.shopLoaded = true })
  }
}
</script>

<style>
</style>
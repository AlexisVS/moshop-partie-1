<template>
  <v-card>
    <div>qsdqsdsq</div>
  </v-card>
</template>

<script>
import axios from "axios"
export default {
  data: () => ({
    shop: null,
  }),
  mounted () {
    axios.get('/app/home')
      .then(res => this.shop = res.data)
  }
}
</script>

<style>
</style>
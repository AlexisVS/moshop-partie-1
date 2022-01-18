<template>
  <v-card class="rounded-xl mt-9">
    <v-container>
      <v-row v-if="article && shopArticle">
        <v-col cols="12" sm="6">
          <v-img
            :src="'http://localhost:8000/images/' + article.cover_path"
            aspect-ratio="1"
            width="70%"
            class="mx-auto mt-6"
          />
        </v-col>
        <v-col cols="12" sm="6">
          <v-container fluid class="mt-2" :class="$vuetify.breakpoint.xsOnly == true && 'mx-7'">
            <v-row class="mt-0 mb-7">
              <v-col cols="12">
                <v-row class="my-2">
                  <span class="font-weight-bold tw-uppercase">Name:</span>
                  <span class="ml-2">{{ article.name }}</span>
                </v-row>
                <v-row class="my-2">
                  <span class="font-weight-bold tw-uppercase">Price:</span>
                  <span class="ml-2">{{ article.price }}€</span>
                </v-row>
                <v-row class="my-2">
                  <span class="font-weight-bold tw-uppercase">Quantity:</span>
                  <span class="ml-2">{{ article.quantity }}</span>
                </v-row>
                <v-row class="my-2">
                  <span class="font-weight-bold tw-uppercase">Provenance shop:</span>
                  <span class="ml-2">{{ shopArticle.name }}</span>
                </v-row>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" class="pl-0">
                <p class="text-justify pr-4" :class="$vuetify.breakpoint.xsOnly == true && 'mr-7'">
                  <span class="font-weight-bold tw-uppercase">Article description:</span>
                  <br />
                  {{ article.description }}
                </p>
              </v-col>
            </v-row>
            <v-row>
              <v-card-actions class="mx-0 px-0">
                <input
                  type="number"
                  min="0"
                  :max="article.quantity"
                  class="input-number"
                  v-model="quantity"
                />
                <v-btn :disabled="quantity == 0" @click="addToCard" class="ml-2">add to cart</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-row>
          </v-container>
        </v-col>
      </v-row>
    </v-container>
  </v-card>
</template>

<script>
import axios from "axios"
export default {
  name: 'Article',
  data: () => ({
    article: null,
    shopArticle: null,
    quantity: 0,
    addToCardResponse: null,
  }),
  methods: {
    addToCard () {
      let formData = new FormData();
      formData.append('shop_id', this.shopArticle.id);
      formData.append('article_id', this.article.id);
      formData.append('quantity', this.quantity);
      axios.post('/app/paniers', formData).then(res => { this.addToCardResponse = res; console.log(res); })
    }
  },
  mounted () {
    axios
      .get("/app/articles/" + this.$route.params.id)
      .then(res => { this.article = res.data.article; this.shopArticle = res.data.shop })
  },
}
</script>

<style scoped>
.input-number {
  border-color: #1976d2;
  border: 1px solid #1976d2;
  color: #1976d2;
  outline: none;
  padding: 4px 9px;
  border-radius: 3px;
  box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.3);
  font-weight: 600;
  width: 100px;
}
</style>
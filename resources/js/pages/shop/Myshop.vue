<template>
  <v-container v-if="shop">
    <v-row v-if="shop.shop.name">
      <v-col cols="6">
        <h1>{{ shop.shop.name }}</h1>
      </v-col>
      <v-col cols="6" class="text-end">
        <v-btn @click="addArticleOverlay = true" class="mt-2">Add article</v-btn>
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
        <v-card>
          <v-img aspect-ratio="1" :src="'http://127.0.0.1:8000/images/' + item.cover_path"></v-img>
          <v-card-title>{{ item.name }}</v-card-title>
          <v-card-text class="text-truncate">{{ item.description }}</v-card-text>
          <v-card-actions>
            <v-btn :to="'/articles/' + item.id">Show</v-btn>
            <v-spacer></v-spacer>
            <v-btn @click="currentArticle = item; editArticleOverlay = true" color="primary">Edit</v-btn>
            <v-spacer></v-spacer>
            <v-btn @click="deleteItem(item.id)" color="error">
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    <AddArticle
      v-if="addArticleOverlay"
      :addArticleOverlay="addArticleOverlay"
      @addArticleSuccess="addArticleOverlay = false"
      :refreshShop="loadMyShop"
    />
    <EditArticle
      v-if="editArticleOverlay"
      :article="currentArticle"
      :editArticleOverlay="editArticleOverlay"
      @editArticleSuccess="editArticleOverlay = false"
      :refreshShop="loadMyShop"
    />
  </v-container>
</template>

<script>
import axios from "axios"
import AddArticle from "../../components/overlay/AddArticle.vue";
import EditArticle from '../../components/overlay/EditArticle.vue';
export default {
  name: "Myshop",
  data: () => ({
    currentArticle: null,
    addArticleOverlay: false,
    editArticleOverlay: false,
    shop: null,
    shopLoaded: false,
  }),
  methods: {
    deleteItem (articleId) {
      axios.delete(`app/articles/${articleId}`)
        .then(res => {console.log(res); this.loadMyShop()})
    },
    loadMyShop () {
      axios.get("/app/my-shop")
        .then(res => {
          this.shop = res.data;
          this.shopLoaded = true;
          if (res.data == null) {
            this.shop = [];
          }
        });
    }
  },
  mounted () {
    this.loadMyShop()
  },
  components: { AddArticle, EditArticle }
}
</script>

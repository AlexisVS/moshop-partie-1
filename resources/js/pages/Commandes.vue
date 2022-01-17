<template>
  <v-expansion-panels>
    <v-expansion-panel v-for="item in commandes" :key="'commande-numero-' + item.id">
      <v-expansion-panel-header>Commandes du {{ item.created_at }}</v-expansion-panel-header>
      <v-expansion-panel-content>
        <v-container>
          <v-row>
            <v-col cols="12">
              <p class="font-weight-bold">
                Price:
                <span class="font-weight-regular">{{ item.price }}</span>
              </p>
            </v-col>
            <v-col cols="12" v-if="shopName">
              <p class="font-weight-bold" >
                Articles
              </p>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12">
              <v-expansion-panels>
                <v-expansion-panel
                  v-for="article in item.json_arr_articles_id"
                  :key="`commande-${item.id}-article-${article.id}`"
                >
                  <v-expansion-panel-header>{{ article.name }}</v-expansion-panel-header>
                  <v-expansion-panel-content>
                    <v-container>
                      <v-row v-if="article">
                        <v-col cols="12" sm="6">
                          <v-img
                            :src="'http://localhost:8000/images/' + article.cover_path"
                            aspect-ratio="1"
                            width="70%"
                            class="mx-auto mt-6"
                          />
                        </v-col>
                        <v-col cols="12" sm="6">
                          <v-container
                            fluid
                            class="mt-2"
                            :class="$vuetify.breakpoint.xsOnly == true && 'mx-7'"
                          >
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
                              </v-col>
                            </v-row>
                            <v-row>
                              <v-col cols="12" class="pl-0">
                                <p
                                  class="text-justify pr-4"
                                  :class="$vuetify.breakpoint.xsOnly == true && 'mr-7'"
                                >
                                  <span class="font-weight-bold tw-uppercase">Article description:</span>
                                  <br />
                                  {{ article.description }}
                                </p>
                              </v-col>
                            </v-row>
                            <v-row>
                              <v-card-actions class="mx-0 px-0">
                                <v-btn
                                  :to="'/app/articles/' + article.id"
                                  class="ml-2"
                                >View</v-btn>
                                <v-spacer></v-spacer>
                              </v-card-actions>
                            </v-row>
                          </v-container>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-expansion-panel-content>
                </v-expansion-panel>
              </v-expansion-panels>
            </v-col>
          </v-row>
        </v-container>
      </v-expansion-panel-content>
    </v-expansion-panel>
  </v-expansion-panels>
</template>

<script>
import axios from 'axios'
export default {
  data: () => ({
    commandes: null,
  }),
  mounted () {
    axios.get('/app/commandes')
      .then(res => {
        this.commandes = res.data
        });
  }
}
</script>

<style>
</style>
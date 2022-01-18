<template>
  <v-dialog
    :transition="false"
    @click:outside="$emit('closeOverlayEditArticle', false)"
    @keydown.esc="$emit('closeOverlayEditArticle', false)"
    v-if="articleId"
    v-model="editArticleOverlay"
    color="transparent"
    :elevation="0"
    width="max-content"
  >
    <v-card width="max-content" class="mx-auto" :elevation="0">
      <v-card-text>
        <v-container>
          <v-row>
            <v-spacer></v-spacer>
            <v-col cols="12" class="pa-0">
              <v-form
                ref="editArticleForm"
                class="px-9 py-9 py-2 rounded-lg"
                :style="$vuetify.breakpoint.xsOnly ? 'width: 100%' : 'width:600px'"
                enctype="multipart/form-data"
                v-model="valid"
                lazy-validation
                @submit.prevent="validate"
              >
                <v-text-field
                  v-model="name"
                  :counter="30"
                  :rules="nameRules"
                  name="name"
                  label="Article name"
                  required
                ></v-text-field>
                <v-text-field
                  v-model="description"
                  :counter="200"
                  :rules="descriptionRules"
                  name="description"
                  label="Description"
                  required
                ></v-text-field>
                <input
                  v-model="price"
                  min="1"
                  :rules="priceRules"
                  name="price"
                  label="Price"
                  hide-details
                  single-line
                  type="number"
                  class="input-number"
                />
                <input
                  v-model="quantity"
                  min="1"
                  :rules="quantityRules"
                  name="quantity"
                  label="Quantity"
                  hide-details
                  single-line
                  type="number"
                  class="mt-5 input-number"
                />
                <v-file-input
                  @change="handleInputAvatar($event)"
                  :value="avatar"
                  ref="inputAvatar"
                  :rules="avatarRules"
                  name="avatar"
                  accept="image/png, image/jpeg, image/bmp"
                  placeholder="Selectionner une image de produit"
                  prepend-icon="mdi-camera"
                  label="Avatar"
                  class="mt-5"
                ></v-file-input>
                <v-btn :disabled="!valid" color="success" type="submit" class="mr-4 mt-4">Validate</v-btn>
              </v-form>
            </v-col>
            <v-spacer></v-spacer>
          </v-row>
        </v-container>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script>
import axios from 'axios'
export default {
  name: 'editArticleOverlay',
  props: {
    'editArticleOverlay': { type: Boolean },
    'article': { type: Object, required: true },
    'refreshShop': { type: Function },
  },
  data () {
    return {

      valid: true,
      articleId: this.article.id,
      name: this.article.name,
      description: this.article.description,
      price: this.article.price,
      quantity: this.article.quantity,
      avatar: null,
      nameRules: [
        v => !!v || 'Article name is required', // true aussi non ...
        v => (v && v.length <= 30) || 'Article name must be less than 10 characters',
      ],
      descriptionRules: [
        v => !!v || 'Description is required', // true aussi non ...
        v => (v && v.length <= 200) || 'Description must be less than 200 characters',
      ],
      priceRules: [
        v => v && Number.isInteger(parseInt(v)) || 'This field must be a number',
        v => v && parseInt(v) > 0 || 'This field must be a number greater than 0',
      ],
      quantityRules: [
        v => (v && Number.isInteger(parseInt(v))) || 'This field must be a number',
        v => (v && parseInt(v) > 0) || 'This field must be a number greater than 0',
      ],
      avatarRules: [
        v => !!v || 'This field must be not empty',
        v => (v && v.size < 2000000) || 'L\'image doit peser moins de 2 MB!',
      ],
    }
  },
  methods: {
    validate () {
      if (this.avatar) {
        let formImage = new FormData()
        formImage.append('cover_path', this.avatar)
        formImage.append('_method', 'PUT')
        axios.post(`/app/articles/${this.articleId}/update-image`, formImage)
      }

      if (
        this.name == this.article.name
        || this.description == this.article.description
        || this.price == this.article.price
        || this.quantity == this.article.quantity
      ) {
        let form = new FormData(this.$refs.editArticleForm.$el)
        form.append('name', this.name)
        form.append('description', this.description)
        form.append('price', parseInt(this.price))
        form.append('quantity', parseInt(this.quantity))
        form.append('_method', 'PUT')
        axios
          .post(`/app/articles/${this.articleId}`, form)
      }
      this.$refs.editArticleForm.validate();
      this.$refs.editArticleForm.reset();
      this.refreshShop()
      this.$emit('editArticleSuccess', false)
    },
    handleInputAvatar (file) {
      this.avatar = file;
    }
  },
}
</script>

<style scoped>
.input-number {
  border-color: #bbb;
  border-bottom: 1.5px solid #bbb;
  color: #bbb;
  outline: none;
  padding: 4px 9px;
  font-weight: 600;
  width: 100%;
  transition: all ease-out 450ms;
}
.input-number:hover {
  border-color: #eee;
  border-bottom: 1.5px solid #eee;
  color: #eee;
  transition: all ease-out 450ms;
}
.input-number:focus {
  border-color: #1976d2;
  border-bottom: 1.5px solid #1976d2;
  color: #1976d2;

  transition: all ease-out 450ms;
}
</style>
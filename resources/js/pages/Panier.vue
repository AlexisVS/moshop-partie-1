<template>
  <v-container v-if="paniers && paniers.length > 0">
    <v-row>
      <v-col cols>
        <v-simple-table fixed-header>
          <template v-slot:default>
            <thead>
              <tr>
                <th class="text-left">Name</th>
                <th class="text-left">Price</th>
                <th class="text-left">Quantity</th>
                <th class="text-left">Total</th>
                <th class="text-left">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in paniers" :key="'cart-' + item.id">
                <td>{{ item.article_id.name }}</td>
                <td>{{ item.article_id.price }}</td>
                <td>
                  <input
                    v-model="item.quantity"
                    min="1"
                    name="quantity"
                    label="Quantity"
                    hide-details
                    single-line
                    type="number"
                    class="input-number"
                    @change="updateQuantity(item.id, item.quantity)"
                  />
                </td>
                <td>{{ item.article_id.price * item.quantity }}€</td>
                <td>
                  <v-btn small @click="deletePanier(item.id)">
                    <v-icon color="error">mdi-close</v-icon>
                  </v-btn>
                </td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" class="text-right">
        <div class="d-flex justify-end align-center">
          <p class="font-weight-bold mb-0 mr-9">
            Total cost:
            <span>{{ getTotalCost }}€</span>
          </p>
          <v-btn @click="buy" color="success">Buy</v-btn>
        </div>
      </v-col>
    </v-row>
  </v-container>
  <v-container v-else>
    <v-row>
      <v-col cols="12">
        <h1 class="text-center text-head">Votre panier est vide</h1>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import axios from 'axios';
export default {
  data: () => ({
    paniers: null,
    tableHeaders: [
      {
        text: 'Name',
        align: 'start',
        value: 'article_id.name'
      },
      {
        text: 'Price',
        align: 'start',
        value: 'article_id.price '
      },
      {
        text: 'Quantity',
        align: 'start',
        value: 'quantity'
      },
      {
        text: 'Total',
        align: 'start',
        value: ''
      },
    ]
  }),
  computed: {
    getTotalCost: function () {
      if (this.paniers != null && this.paniers.length == 1) {
        return this.paniers[0].article_id.price * this.paniers[0].quantity;
      }
      if (this.paniers != null && this.paniers.length > 1) {
        return [...this.paniers].reduce((a, b) =>
          typeof a === 'object'
            ? (a.article_id.price * a.quantity) + (b.article_id.price * b.quantity)
            : a + (b.article_id.price * b.quantity)
        )
      }
    }
  },
  methods: {
    buy () {
      axios.post('/app/buy')
        .then(res => { this.loadPaniers() })
    },
    loadPaniers () {
      axios.get('/app/paniers')
        .then(res => { this.paniers = res.data; })
    },
    updateQuantity (panierId, itemQuantity) {
      let formData = new FormData();
      formData.append('quantity', parseInt(itemQuantity))
      formData.append('_method', 'PUT')
      axios.post('/app/paniers/' + panierId, formData)
    },
    deletePanier (panierId) {
      axios.delete('/app/paniers/' + panierId).then(res => {
        if (res.status == 200) {
          this.paniers = [...this.paniers].filter(e => e.id != panierId)
        }
      })
    }
  },
  mounted () {
    this.loadPaniers();
  },
}
</script>

<style scoped>
.input-number {
  width: 100px;
  outline: none;
  color: #fff;
}
</style>
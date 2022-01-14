<template>
  <v-container>
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
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in paniers" :key="'cart-' + item.id">
                <td>{{ item.article_id.name }}</td>
                <td>{{ item.article_id.price }}</td>
                <td>{{ item.quantity }}</td>
                <td>{{ item.article_id.price * item.quantity }}€</td>
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
      if (this.paniers != null) {
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
      .then(res => console.log(res))
    },
  },
  mounted () {
    axios.get('/app/cart')
      .then(res => { console.log(res); this.paniers = res.data; })
  },
  // computed: {
  //   multiplication: (a, b) => a * b
  // },
}
</script>

<style>
</style>
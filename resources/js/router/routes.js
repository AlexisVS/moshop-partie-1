import Home from '../pages/Home.vue'
import Shop from '../pages/shop/Shop.vue'
import Article from '../pages/shop/Article.vue'
import Panier from '../pages/Panier.vue'

const routes = [
  {
    path: '/',
    component: Home,
  },
  {
    path: '/shop',
    component: Shop,
  },
  {
    path: '/article/:id',
    component: Article,
  },
  {
    path: '/panier',
    component:Panier,
  }
];
export default routes
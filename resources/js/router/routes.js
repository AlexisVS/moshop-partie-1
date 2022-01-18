import Home from '../pages/Home.vue'
import Shops from '../pages/shop/Shops.vue'
import Article from '../pages/shop/Article.vue'
import Panier from '../pages/Panier.vue'
import Myshop from '../pages/shop/Myshop.vue'
import Shop from '../pages/shop/Shop.vue'
import Commandes from '../pages/Commandes.vue'

const routes = [
  {
    path: '/',
    component: Home,
    props: true,
    
  },
  {
    path: '/shops',
    component: Shops,
  },
  {
    path: '/shops/:id',
    component: Shop,
  },
  {
    path: '/articles/:id',
    component: Article,
  },
  {
    path: '/panier',
    component:Panier,
  },
  {
    path: "/my-shop",
    component: Myshop,
  },
  { 
    path: '/commandes',
    component: Commandes,
  },
];
export default routes
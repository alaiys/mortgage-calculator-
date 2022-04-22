import { createRouter, createWebHistory} from "vue-router";
import bankIndex from "../compoents/banks/index.vue";
import bankAdd from "../compoents/banks/add.vue";
import bankEdit from "../compoents/banks/edit.vue";
import calculator from "../compoents/calculator/index.vue";
import notFound from "../compoents/404.vue";


const routes = [
    {
        path: '/',
        component: bankIndex
    },
    {
        path: '/calculator',
        component: calculator
    },
    {
        path: '/bank/add',
        component: bankAdd
    },
    {
        path: '/bank/edit/:id',
        component: bankEdit,
        props: true
    },
    {
        path: '/:pathMatch(.*)*',
        component: notFound
    },
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
})

export default router

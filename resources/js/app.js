import ('./bootstrap');
import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import Home from './components/Home.vue'
import App from './App.vue'
import VueAxios from 'vue-axios';
import axios from 'axios';

const routes =  [
    {
        path: "/",
        name: "Home",
        component: Home
    }
]

let router = createRouter({
    history: createWebHistory(),
    routes,
})

let app = createApp(App)
app.use(router)
    .use(VueAxios, axios)
    .mount('#app')

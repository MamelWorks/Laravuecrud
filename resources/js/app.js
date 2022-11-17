import ManageUsers from "./components/ManageUsers.vue";
import CreateUser from "./components/CreateUser.vue";
import ManageGroups from "./components/ManageGroups.vue";
import CreateGroup from "./components/CreateGroup.vue";
import Toaster from "@meforma/vue-toaster";

import ('./bootstrap');

import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import Home from './components/Home.vue'
import App from './App.vue'
import VueAxios from 'vue-axios';
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css'


const routes =  [
    {
        path: "/",
        name: "Home",
        component: Home
    },
    {
        name: 'users',
        path: '/users',
        component: ManageUsers
    },
    {
        name: 'createUser',
        path: '/users/create',
        component: CreateUser
    },
    {
        name: 'groups',
        path: '/groups',
        component: ManageGroups
    },
    {
        name: 'createGroup',
        path: '/groups/create',
        component: CreateGroup
    }
]

let router = createRouter({
    history: createWebHistory(),
    routes,
})

let app = createApp(App)
app.use(router)
    .use(VueAxios, axios)
    .use(Toaster)
    .mount('#app')

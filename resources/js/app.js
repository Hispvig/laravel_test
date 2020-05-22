/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.axios = require('axios');
window.Vue = require('vue');
import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

import NewsIndex from './components/news/Index.vue';
import NewsCreate from './components/news/Create.vue';
import NewsShow from './components/news/Show.vue';
import NewsEdit from './components/news/Edit.vue';
import PhotosIndex from './components/photos/Index.vue';
import PhotosCreate from './components/photos/Create.vue';
import PhotosShow from './components/photos/Show.vue';

const routes = [
    {
        path: '/',
        components: {
            newsIndex: NewsIndex
        },
        name: 'indexNews',
    },
    {path: '/news/create', component: NewsCreate, name: 'createNews'},
    {path: '/news/:id', component: NewsShow, name: 'showNews'},
    {path: '/news/edit/:id', component: NewsEdit, name: 'editNews'},
    {path: '/photos', component: PhotosIndex, name: 'indexPhotos'},
    {path: '/photos/create', component: PhotosCreate, name: 'createPhotos'},
    {path: '/photos/:id', component: PhotosShow, name: 'showPhotos'},
    // {path: '/photos/edit/:id', component: PhotosEdit, name: 'editPhotos'},
]

const router = new VueRouter({ routes })

Vue.prototype.signedIn = window.App.signedIn;
Vue.prototype.user = window.App.user;

const app = new Vue({ router }).$mount('#app')

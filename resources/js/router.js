import Vue from 'vue';
import PostsList from './components/PostsList';
import VueRouter from 'vue-router';
import PostsIndex from './views/PostsIndex';
import PostsCreate from './views/PostsCreate';


Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/', component: PostsIndex },
        { path: '/posts/create', component: PostsCreate }
    ],
    mode: 'history'
});
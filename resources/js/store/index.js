import Vuex from 'vuex';
import Vue from 'vue';
import posts from './modules/posts';
import currentUser from './modules/currentUser';

// Load Vuex
Vue.use(Vuex);

//Create store
export default new Vuex.Store({
    modules: {
        posts,
        currentUser
    }
});
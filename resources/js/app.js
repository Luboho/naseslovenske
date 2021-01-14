import Vue from 'vue';
import router from './router';
import App from './components/App';  
import store from './store';
import Login from './auth/Login';


require('./bootstrap');


const app = new Vue({
    el: '#app',
    components: {
        App,
        Login
    },
    router,
    store
});

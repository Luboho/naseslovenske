import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from './auth/Login';

import ProfilesIndex from './views/ProfilesIndex';
import ProfilesCreate from './views/ProfilesCreate';
import ProfilesShow from './views/ProfilesShow';
import ProfilesEdit from './views/ProfilesEdit';
import { uniqueSort } from 'jquery';

Vue.use(VueRouter);

const router = new VueRouter({

    routes: [
        // { path: '/', component: ExampleComponent,},
        { 
            name: Login,
            path: '/login', 
            component: Login,
        },
        { 
            path: '/profiles', 
            component: ProfilesIndex,
        },
        { 
            path: '/profiles/create', 
            component: ProfilesCreate,
            meta: { requiresAuth: true }
        },
        { 
            path: '/profiles/:id', 
            component: ProfilesShow
        },
        { 
            path: '/profiles/:id/edit', 
            component: ProfilesEdit, 
            meta: { requiresAuth: true }
        }
    ],
    mode: 'history'
});

router.beforeEach((to, from, next) => {
    
    if (to.meta.requiresAuth && isUserInLs() === false) {
    // User is not in LS.
        router.push({name: Login});
        location.reload();
    }
    // User is stored in LS.  
    else {
        next();
    }
});

function isUserInLs() {
    
    const storedUser = localStorage.getItem('user');

    if (storedUser !== null) {
         return true;
    } else {
        return false;
    }
}

export default router  ;

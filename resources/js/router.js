import Vue from 'vue';
import VueRouter from 'vue-router';
// auth
import Login from './auth/Login';
import Logout from './auth/Logout';
// accounts
import AccountsShow from './views/accounts/AccountsShow';
// posts
import PostsIndex from './views/posts/PostsIndex';
import PostsCreate from './views/posts/PostsCreate';
import PostsShow from './views/posts/PostsShow';
import PostsEdit from './views/posts/PostsEdit';

// profiles
import ProfilesIndex from './views/profiles/ProfilesIndex';
import ProfilesCreate from './views/profiles/ProfilesCreate';
import ProfilesShow from './views/profiles/ProfilesShow';
import ProfilesEdit from './views/profiles/ProfilesEdit';
import { uniqueSort } from 'jquery';

Vue.use(VueRouter);

const router = new VueRouter({

    routes: [
        {   name: 'login',
            path: '/login', 
            component: Login,
        },
        { 
            path: '/logout', 
            component: Logout,
        },
        { 
            path: '/accounts', 
            component: AccountsShow,
        },
        { 
            path: '/', 
            component: PostsIndex,
        },
        { 
            path: '/posts/create', 
            component: PostsCreate,
            meta: { requiresAuth: true }
        },
        { 
            path: '/posts/:id', 
            component: PostsShow,
        },
        { 
            path: '/posts/:id/edit', 
            component: PostsEdit,
            meta: { requiresAuth: true }
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
        router.push({name: 'login'});
        location.reload();
    }
    // User is stored in LS.  
    else {
        next();
    }
});

function isUserInLs() {
    const storedUser = localStorage.getItem('authenticated');

    if (storedUser !== null) {
         return true;
    } else {
        return false;
    }
}

export default router  ;

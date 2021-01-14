import axios from 'axios';

const state = {
    posts: [],
    singlePost: [],
    error: null,
    loading: true
};


const getters = {
    // Returns state
    posts: (state) => state.posts,
    singlePost: (state) => state.singlePost,
    error: (state) => state.error,
    loading: (state) => state.loading,
};

const actions = {
    async fetchAll({ commit }) {
        const response = await axios.get('/api/')
        .then(response => {
            commit('setPosts', response)
            commit('setLoading', false)
        })
        .catch(error => {
            commit('setErrors', error.response)
            commit('setLoading', false)
        });   
    },

    async fetchItem({ commit }, id) {
        const response = await axios.get(`/api/posts/${id}`)
        .then(response => {
            commit('setSinglePost', response)
            commit('setLoading', false)
        })
        .catch(error => {
            commit('setErrors', error.response)
            commit('setLoading', false)
        });
    },

    async deleteItem({ commit }, id) {
        await axios.delete(`/api/posts/${id}?api_token=this.user.api_token`)
        .then(commit('removePost', id))
        .catch(error => {
            commit('setErrors', error.response)
        });
    }
};

const mutations = {
    setPosts: (state, posts) => (state.posts = posts.data.data),
    setSinglePost: (state, singlePost) => (state.singlePost = singlePost.data.data),
    removePost: (state, id) => (state.posts = state.posts.filter(post => post.id !== id)),
    setErrors: (state, error) => (state.error = error),
    setLoading: (state, loading) => (state.loading = loading)
};

export default {
    state,
    getters,
    actions,
    mutations
};
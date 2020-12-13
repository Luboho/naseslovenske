<template>
  <div>
      <div v-if="loading">Loading...</div>
        <div v-else>
            <div v-if="posts.length === 0">
                <p>Nemáte žiadne príspevky. <router-link to="/posts/create">Vytvoriť príspevok</router-link></p>
            </div>
      <h1 class="text-blue-500 pb-4 uppercase italic font-bold"> Main Page</h1> 

            <div v-for="post in posts" :key="post.data.id" class="p-2">
                <div class="animate sm:flex-col grid md:grid-cols-2 lg:grid-cols-2 shadow-xl bg-indigo-300 px-2 rounded-3xl">
                    <div class="place-self-center p-4">
                            
                        <img :src="'/storage/uploads/' + post.data.image" class="rounded-full" >
                    </div>
                    <div class="p-4">
                        <p class="text-2xl font-bold">{{ post.data.title }}</p>
                        <p class="sm:text-xs text-md">{{ post.data.description }} 
                            <router-link :to="'/posts/' + post.data.post_id" >
                                <span class="bg-indigo-200 px-2 py-1 rounded-lg font-semibold inline-block"> . . . čítaj viac </span>
                            </router-link>
                        </p>
                    </div>
                </div>
            </div>
        </div>
  </div>

</template>

<script>

    export default {
        name: "PostsIndex",

        props: [
            'endpoint', 'user'
        ],

        mounted() {
            axios.get('/api/')
                .then(response => {
                    this.posts = response.data.data;
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;

                    alert('Unable to fetch profiles.');
                });
        },

        data: function() {
            return {
                loading: true,
                posts: null,
            }
        },

    }
</script>

<style>
/* Animations */
.animate {
  animation-name: stretch;
  animation-duration: 1.0s;
  animation-timing-function: ease-out;
}

@keyframes stretch {
  0% {
    transform: scale(.1);
  }
  100% {
    transform: scale(1.0);
  }
}
</style>
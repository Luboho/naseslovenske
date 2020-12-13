<template>
  <div>
      <div v-if="loading">Loading...</div>
        <div v-else>

            <div class="flex justify-between">
                <a href="#" @click="$router.back()" class="text-indigo-400 text-md py-2">
                    ← Back
                </a>

<!-- Edit/Delete Buttons -->
                
                 <div v-show="showButtons" class="relative animate-buttons">
                    <router-link :to="'/posts/' + post.post_id + '/edit?file_name=' + post.image" class="px-4 py-2 mr-2 rounded border border-green-500 text-sm font-bold">Edit</router-link>    <!-- post.id saved in data: properties below. -->
                    <a href="#" @click="modal = ! modal" class="px-4 py-2 border border-red-500 text-sm font-bold rounded text-red-500">Delete</a>
                                        <!-- set modal to opposite -->

                    <div v-if="modal" class="absolute bg-indigo-900 text-white rounded-lg z-20 p-8 w-64 right-0 mt-2 mr-6">  <!-- If modal is true SHOW -->
                        <p>Ste si istý, že chcete zmazať tento príspevok?</p>

                        <div class="flex items-center mt-6 justify-end">               <!-- Set modal to opposite to HIDE modal-->
                            <button @click="modal = ! modal" class="text-white pr-4">Zrušiť</button>
                            <button @click="destroy" class="px-4 py-2 bg-red-500 rounded text-sm font-bold text-white">Vymazať</button>
                        </div>
                    </div>
                    
                </div> 
<!-- End of Delte/Edit Buttons  -->
                    <div v-if="modal" @click="modal = ! modal" class="bg-black opacity-50 absolute right-0 left-0 top-0 bottom-0 z-10"></div>
            
            </div>


            <div class="p-2">
                <div class="grid sm:text-xs lg:text-base lg:grid-cols-2 shadow-xl bg-indigo-300 px-2 rounded-3xl">
                    <div class="place-self-center p-4">
                        <img :src="'/storage/uploads/' + post.image" class="rounded-full" >
                    </div>
                    <div class="p-4">
                            <h1 class="text-xl font-bold">{{ post.title }}</h1>
                            <p class="">{{ post.description }} </p>
                    </div>
                </div>
            </div>
        </div>
  </div>
</template>

<script>

    export default {
        name: "PostsShow",
        
        props: ['user'],

            data: function () {
                return {
                    post: null,
                    loading: true,
                    modal: false,
                    showButtons: false,
                }
            },
        
        mounted() {
            axios.get('/api/posts/' + this.$route.params.id)
                .then(response => {
                    this.post = response.data.data;
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                    if(error.response.status === 404) { // Redirect to / if response status is 404.
                        this.$router.push('/');
                    }
                });
        },

        watch: {
            post: function() {
                if(this.user !== undefined){
                    if(this.post.user_id === this.user.id) {
                        this.showButtons = true
                    }
                }
            }
        },

        methods: {
            destroy: function() {
                axios.delete('/api/posts/' + this.$route.params.id + '?api_token=' + this.user.api_token)
                    .then(response => {
                        this.$router.push('/');
                    })
                    .catch(error => {
                        alert('Nastala chyba. Nie je možné vymazať príspevok.');

                        if(error.response.status === 404) { // Redirect if response status is 404.
                        this.$router.push('/');
                    }
                    });
            },

           
        },

    }
</script>

<style>
/* Animations */
.animate-buttons {
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
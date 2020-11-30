<template>
  <div>
      <div v-if="loading">Loading...</div>
        <div v-else>
            <div class="flex justify-between">
                <a href="#" @click="$router.back()" class="text-indigo-400 text-md py-2">
                    ← Back
                </a>

                 <div class="relative">
                    <router-link :to="'/profiles/' + profile.profile_id + '/edit?file_name=' + profile.image" class="px-4 py-2 mr-2 rounded border border-green-500 text-sm font-bold">Edit</router-link>    <!-- profile.id saved in data: properties below. -->
                    <a href="#" @click="modal = ! modal" class="px-4 py-2 border border-red-500 text-sm font-bold rounded text-red-500">Delete</a>
                                        <!-- set modal to opposite -->

                    <div v-if="modal" class="absolute bg-indigo-900 text-white rounded-lg z-20 p-8 w-64 right-0 mt-2 mr-6">  <!-- If modal is true SHOW -->
                        <p>Ste si istý, že chcete zmazať tento profil?</p>

                        <div class="flex items-center mt-6 justify-end">               <!-- Set modal to opposite to HIDE modal-->
                            <button @click="modal = ! modal" class="text-white pr-4">Zrušiť</button>
                            <button @click="destroy" class="px-4 py-2 bg-red-500 rounded text-sm font-bold text-white">Vymazať</button>
                        </div>
                    </div>
                    
                </div>                  
                    <div v-if="modal" @click="modal = ! modal" class="bg-black opacity-50 absolute right-0 left-0 top-0 bottom-0 z-10"></div>
            
            </div>


            <div class="p-2">
                <div class="grid sm:text-xs lg:text-base lg:grid-cols-2 shadow-xl bg-indigo-300 px-2 rounded-3xl">
                    <div class="place-self-center p-4">
                        <img :src="'/storage/uploads/' + profile.image" class="rounded-full" >
                    </div>
                    <div class="p-4">
                            <h1 class="text-xl font-bold">{{ profile.title }}</h1>
                            <p class="">{{ profile.description }} </p>
                    </div>
                </div>
            </div>
        </div>
  </div>
</template>

<script>
    export default {
        name: "ProfilesShow",
        props: ['user'],

        
        mounted() {
            axios.get('/api/profiles/' + this.$route.params.id)
                .then(response => {
                    this.profile = response.data.data;

                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                    if(error.response.status === 404) { // Redirect to /contacts if response status is 404.
                        this.$router.push('/profiles');
                    }
                });
        },

        data: function () {
            return {
                profile: null,
                loading: true,
                modal: false,
            }
        },

        methods: {
            destroy: function() {
                axios.delete('/api/profiles/' + this.$route.params.id + '?api_token=' + this.user.api_token)
                    .then(response => {
                        this.$router.push('/profiles');
                    })
                    .catch(error => {
                        alert('Nastala chyba. Nie je možné vymazať profil.');

                        if(error.response.status === 404) { // Redirect if response status is 404.
                        this.$router.push('/profiles');
                    }
                    });
            }
        }

    }
</script>

<style>

</style>
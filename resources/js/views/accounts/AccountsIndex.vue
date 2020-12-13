<template>
  <div class="h-screen bg-indigo-200">
      <div v-if="loading">Loading...</div>
        <div v-else>
            <div v-if="posts.length === 0">
                <p>Nemáte žiadne príspevky. <router-link to="/posts/create">Vytvoriť príspevok</router-link></p>
            </div>
        <!-- User Nav -->
          <UserNav :user="user" :showParagraph="showParagraph" />
        <!-- End User Nav -->

        <!-- Body -->
        <div class="mx-auto p-5">
            <h1 class="text-blue-500 pb-4 uppercase italic font-bold">Moje príspevky</h1>
            <table class="animate text-sm text-indigo-900 rounded-full border-separate table-auto mx-auto">
                <thead>
                    <tr class="font-bold bg-indigo-500 rounded-full">
                        <td class="py-2 px-3 rounded-l-full">#</td>
                        <td class="py-1 px-3">Obrázok</td>
                        <td class="py-1 px-3">Titul</td>
                        <td class="py-1 px-3">Popis</td>
                        <td class="py-1 px-3 rounded-r-full">Pridané</td>
                    </tr>
                </thead>
                <tbody class="p-1">
                    <tr v-for="(post, loopIndex) in posts" :key="post.data.id" :class="{highlighted: loopIndex % 2 == 0}" class="p-1 bg-indigo-400 rounded-full hover:bg-indigo-500 hover:shadow-xl">
                        <td class="py-1 px-3 rounded-l-full">
                            <router-link :to="'/posts/' + post.data.post_id" >
                                {{ loopIndex+1 }}.
                            </router-link>         
                        </td>
                        <td class="py-1 px-3">
                            <router-link :to="'/posts/' + post.data.post_id" >
                                <img :src="'/storage/uploads/' + post.data.image" class="rounded-full w-20" >
                            </router-link>
                        </td>
                        <td class="py-1 px-3">
                            <router-link :to="'/posts/' + post.data.post_id" >
                                {{ post.data.title | limitOutput }}
                            </router-link>
                        </td>
                        <td class="py-1 px-3">
                            <router-link :to="'/posts/' + post.data.post_id" >
                                {{ post.data.description | limitOutput }}
                            </router-link>
                        </td>
                        <td class="py-1 px-3 rounded-r-full">
                            <router-link :to="'/posts/' + post.data.post_id" >                        
                                {{ post.data.last_updated }}
                            </router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- End Body -->

  </div>

</template>
<script>
import UserNav from '../../components/UserNav';

    export default {
        name: "AccountsIndex",
        props: ["user"],
        components: {
            UserNav
        },

        data: function() {
            return {
                counter: 1,
                loading: true,
                posts: null,
                showParagraph: false,   
            }
        },

        filters: {
            limitOutput: function(val) {
                if (val.length > 50) {
                    return val = val.substr(0, 50) + '...';
                }
                else {
                    return val;
                }
            }
        },

        mounted() {
            axios.get('/api/accounts?api_token=' + this.user.api_token)
                .then(response => {
                    this.posts = response.data.data;
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;

                    alert('Vyskytol sa problém. Obnovte stránku prosím.')
                });
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

.highlighted {
  background-color: #94b3f5;
}
</style>
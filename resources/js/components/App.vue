<template>
    <div class="h-screen bg-gray-200">
        <div class="lg:flex md:inline-block sm:inline-block">
            <!-- Navigation -->
            <MainNav :user="user" />
               
            <!-- Right Section -->
            <!-- Right Top Section -->
            <!-- Right Bottom Section -->
            <div class="flex flex-col flex-1 w-screen h-screen overflow-y-hidden"> 
                <router-view :user="user" class="p-6 overflow-x-hidden"></router-view>
            </div>
        </div>
    </div>
</template>

<script>
import MainNav from './MainNav';

export default {

    name: "App",
    components: {
        MainNav
    },
    props: [
        'user',
    ],

    methods: {
        setUserToLocal: function() {
            let hours = 1;
            let saved = localStorage.getItem('authenticated');
            if(saved && (new Date().getTime() - saved > hours * 60 * 60 * 1000)) {
                localStorage.removeItem('authenticated');
                localStorage.removeItem('user_api');
            }
            localStorage.setItem('authenticated', new Date().getTime());
            localStorage.setItem('user_api',  this.user.api_token);
        },

        ifAuthSetTrue: function() {
            if(this.user !== undefined) {
               return this.showParagraph = true;
            } else {
               return this.showParagraph = false;
            }
        }
    },

    created() {     // Similar to mounted() property, but created() is executed asap after App is created. So, earlier than mounted() which is executed afer than component is created.
            // window.axios.interceptors.request.use(// Whenever axios make request use api_token from config file.
            //     (config) => {
            //         if (config.method === 'get') { // If GET request append api_token to URL
            //             config.url = config.url + '?api_token=' + this.user.api_token;
            //         } else {
            //             config.data = {     // Set Users' API Token config
            //                 ...config.data, // ...spread Operator to copy what in the config already is and append api_token from data
            //                 api_token: this.user.api_token 
            //             };
            //         }
            //         return config;
            //     }
            // )

            if(this.user !== undefined) {
                this.setUserToLocal();
                // this.setUserGlobally();
            }

            this.ifAuthSetTrue();
    }

}
</script>

<style scoped>

</style>
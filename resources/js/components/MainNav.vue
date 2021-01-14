<template>
   <div class="p-1 bg-indigo-800">
        <nav class="sm:flex md:flex lg:h-screen sm:w-full md:w-full lg:flex-col rounded-tl-full rounded-br-full sm:p-3 md:p-3 lg:p-2 lg:my-2 justify-between sm:px-5 md:px-5 bg-indigo-200 border-gray-400">
        <!-- <router-link to="/">
            <svg class="fill-current text-blue-600 w-12 h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M3.9 4.2c-.5 0-.8.3-.8.8s.4.8.8.8c.5 0 .8-.4.8-.8.1-.5-.3-.8-.8-.8zM3.3 18.6c0 1.4-.2 2.1-1.5 2.1-.3 0-.7 0-.9-.1l-.3 1.1c.3.1.7.2 1.1.2 1.9 0 2.7-1.2 2.7-3.2V8.1H3.3v10.5zM9.4 17.5c1.4 0 2.3-.4 3-1.2.8-1 1.1-2.1 1.1-3.8 0-1.4-.2-2.7-1-3.5-.6-.7-1.5-1.1-2.9-1.1s-2.3.4-3 1.2c-.8 1-1.1 2.2-1.1 3.8 0 1.5.2 2.6 1 3.5.6.7 1.5 1.1 2.9 1.1zM7.5 9.7c.3-.4.9-.8 2-.8 1 0 1.6.3 1.9.7.5.6.7 1.7.7 2.9s-.2 2.4-.7 3.1c-.3.4-.9.8-2 .8-1 0-1.6-.3-1.9-.7-.5-.6-.7-1.6-.7-2.9 0-1.2.2-2.4.7-3.1zM15 14.4c0 2.1.4 3.1 2.5 3.1.6 0 1.3-.1 1.8-.2l-.1-1c-.5.1-1 .2-1.5.2-1.4 0-1.5-.6-1.5-2.1v-5h3V8.3h-3v-3l-1.2.2v2.7h-1.8v1.1H15v5.1zM6 18h17v1H6z"/>
            </svg>
        </router-link> -->

            <router-link to="/" :class="{ activePage: $route.path == '/'}" class="active:shadow-lg items-center p-2 pb-0 lg:pt-5 hover:text-blue-600 text-sm">
                <svg viewBox="0 0 36 36" class="fill-current mx-auto text-blue-600 w-5 h-5">
                    <path d="M0,0v35h35V0H0z M33,33H2V2h31V33z"/><rect x="10" y="5" width="20" height="2.824"/><rect x="10" y="9.438" width="20" height="2.819"/><rect x="10" y="13.869" width="20" height="2.824"/><rect x="10" y="18.307" width="20" height="2.818"/><rect x="10" y="22.739" width="20" height="2.829"/><rect x="10" y="27.18" width="20" height="2.82"/><rect x="5" y="5" width="2.824" height="2.824"/><rect x="5" y="9.436" width="2.824" height="2.823"/><rect x="5" y="13.87" width="2.824" height="2.823"/><rect x="5" y="18.305" width="2.824" height="2.824"/><rect x="5" y="22.74" width="2.824" height="2.824"/><rect x="5" y="27.176" width="2.824" height="2.824"/>
                </svg>
                <div class="text-center tracking-wide">Posts</div>
            </router-link>

            <router-link to="/profiles" :class="{ activePage: $route.path == '/profiles'}" class="items-center p-2 pb-0 hover:text-blue-600 text-sm">
                <svg viewBox="0 0 24 24" class="fill-current mx-auto text-blue-600 w-5 h-5">
                    <path class="st0" d="M20 2h-1V1c0-.6-.4-1-1-1s-1 .4-1 1v1h-4V1c0-.6-.4-1-1-1s-1 .4-1 1v1H7V1c0-.6-.4-1-1-1S5 .4 5 1v1H4C1.8 2 0 3.8 0 6v14c0 2.2 1.8 4 4 4h16c2.2 0 4-1.8 4-4V6c0-2.2-1.8-4-4-4zM4 4h1v1c0 .6.4 1 1 1s1-.4 1-1V4h4v1c0 .6.4 1 1 1s1-.4 1-1V4h4v1c0 .6.4 1 1 1s1-.4 1-1V4h1c1.1 0 2 .9 2 2v2H2V6c0-1.1.9-2 2-2zm16 18H4c-1.1 0-2-.9-2-2V10h20v10c0 1.1-.9 2-2 2zM8 14c0 .6-.4 1-1 1H5c-.6 0-1-.4-1-1s.4-1 1-1h2c.6 0 1 .4 1 1zm6 0c0 .6-.4 1-1 1h-2c-.6 0-1-.4-1-1s.4-1 1-1h2c.6 0 1 .4 1 1zm6 0c0 .6-.4 1-1 1h-2c-.6 0-1-.4-1-1s.4-1 1-1h2c.6 0 1 .4 1 1zM8 18c0 .6-.4 1-1 1H5c-.6 0-1-.4-1-1s.4-1 1-1h2c.6 0 1 .4 1 1zm6 0c0 .6-.4 1-1 1h-2c-.6 0-1-.4-1-1s.4-1 1-1h2c.6 0 1 .4 1 1zm6 0c0 .6-.4 1-1 1h-2c-.6 0-1-.4-1-1s.4-1 1-1h2c.6 0 1 .4 1 1z"/>
                </svg>
            <div class="text-center tracking-wide">Profiles</div>
            </router-link>

            <!-- Login, Logout, Account -->
            <div class="sm:flex md:flex lg:flex-col justify-end px-2 lg:my-5">
                <router-link v-if="user" to="/accounts"  :class="{ activePage: $route.path == '/accounts'}" class="items-center p-2 pb-0 hover:text-blue-600 text-sm">
                    <svg viewBox="0 0 475 475" class="fill-current mx-auto text-blue-600 font-bold w-5 h-5">
                        <path d="M379.5,0h-284C42.8,0,0,42.8,0,95.5v284C0,432.2,42.8,475,95.5,475h284c52.7,0,95.5-42.8,95.5-95.5v-284
                                C475,42.8,432.2,0,379.5,0z M388.7,400.8H237.5H86.3v-42.6c0-9,4-17.6,11-23.3c38.5-31.6,80-52.6,88.5-56.8c1-0.5,1.6-1.4,1.6-2.5
                                v-59.9c-7.5-5-12.5-13.6-12.5-23.3v-62.2c0-30.9,25.1-56,56-56h6.7h6.7c30.9,0,56,25.1,56,56v62.2c0,9.7-5,18.3-12.5,23.3v59.9
                                c0,1.1,0.6,2,1.6,2.5c8.5,4.1,50,25.1,88.5,56.8c7,5.7,11,14.3,11,23.3v42.6H388.7z"/>                            
                    </svg>
                <div class="tracking-wide">Account</div>
                </router-link>
                <router-link v-else to="/login"  :class="{ activePage: $route.path == '/login'}" class="items-center p-2 pb-0 hover:text-blue-600 text-sm">
                    <svg viewBox="0 0 475 475" class="fill-current mx-auto text-blue-600 font-bold w-5 h-5">
                        <path d="M379.5,0h-284C42.8,0,0,42.8,0,95.5v284C0,432.2,42.8,475,95.5,475h284c52.7,0,95.5-42.8,95.5-95.5v-284
                                C475,42.8,432.2,0,379.5,0z M388.7,400.8H237.5H86.3v-42.6c0-9,4-17.6,11-23.3c38.5-31.6,80-52.6,88.5-56.8c1-0.5,1.6-1.4,1.6-2.5
                                v-59.9c-7.5-5-12.5-13.6-12.5-23.3v-62.2c0-30.9,25.1-56,56-56h6.7h6.7c30.9,0,56,25.1,56,56v62.2c0,9.7-5,18.3-12.5,23.3v59.9
                                c0,1.1,0.6,2,1.6,2.5c8.5,4.1,50,25.1,88.5,56.8c7,5.7,11,14.3,11,23.3v42.6H388.7z"/>                            
                    </svg>
                <div class="tracking-wide">Login</div>
                </router-link>

                <router-link to="/logout" class="items-center p-2 pb-0 hover:text-blue-600 text-sm">
                    <svg viewBox="0 0 24 24" class="fill-current mx-auto text-blue-600 w-5 h-5">
                        <path d="M21 3h-3.8c-.7 0-1.3-.6-1.3-1.3S16.5.4 17.2.4h5.1c.7 0 1.3.6 1.3 1.3v20.5c0 .7-.6 1.3-1.3 1.3h-5.1c-.7 0-1.3-.6-1.3-1.3 0-.7.6-1.3 1.3-1.3H21V3zm-6.9 7.7L8.6 5.2c-.5-.5-.6-1.3-.1-1.8s1.3-.5 1.8 0l7.7 7.7c.8.8.2 2.2-.9 2.2H1.8c-.7 0-1.3-.6-1.3-1.3 0-.7.6-1.3 1.3-1.3h12.3zm-1.6 4.8c.5-.5 1.3-.4 1.8.1s.4 1.3-.1 1.8l-3.8 3.2c-.5.5-1.3.4-1.8-.1-.6-.5-.5-1.3 0-1.7l3.9-3.3z"/>
                    </svg>
                    <div class="tracking-wide">Logout</div>
                </router-link>
            </div>
            <!--End Login, Logout, Account -->


        </nav>
    </div>
</template>

<script>
export default {
    props: ['user', 'showParagraph'],

    name: "MainNav"
}
</script>

<style scoped>
    .activePage {
        border-bottom: 4px dotted rgb(57, 7, 92);
        pointer-events: none;
        cursor: not-allowed;
    }
</style>
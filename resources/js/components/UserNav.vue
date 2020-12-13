<template>

    <nav class="flex border-b border-indigo-300 text-indigo-500 font-bold justify-end p-3">

        <router-link to="/posts/create" class="p-2 items-center hover:text-blue-900 text-sm">
            <svg viewBox="0 0 24 24" class="fill-current mx-auto w-5 h-5">
                <path d="M23.3 11.9c0 .9-.6 1.4-1.4 1.4h-8.5v8.5c0 .9-.6 1.4-1.4 1.4s-1.4-.6-1.4-1.4v-8.5H2c-.9 0-1.4-.6-1.4-1.4 0-.9.6-1.4 1.4-1.4h8.5V1.9c0-.9.6-1.4 1.4-1.4s1.4.6 1.4 1.4v8.5h8.5c.9 0 1.5.6 1.5 1.5z"/>
            </svg>
        <div class="text-center tracking-wide">Pridať príspevok</div>
        </router-link>

        <h1 class="flex border border-indigo-500 text-indigo-800 rounded-full items-center p-2">{{ user.name }}</h1>

            <!-- User Dropdown Button -->
            <div class="dropdown inline-block relative">
                <button class="py-2 px-4 focus:outline-none inline-flex">
                <div>
                    <svg viewBox="0 0 475 475" class="fill-current mx-auto hover:text-blue-800 font-bold w-6 h-6">
                        <path d="M379.5,0h-284C42.8,0,0,42.8,0,95.5v284C0,432.2,42.8,475,95.5,475h284c52.7,0,95.5-42.8,95.5-95.5v-284
                                C475,42.8,432.2,0,379.5,0z M388.7,400.8H237.5H86.3v-42.6c0-9,4-17.6,11-23.3c38.5-31.6,80-52.6,88.5-56.8c1-0.5,1.6-1.4,1.6-2.5
                                v-59.9c-7.5-5-12.5-13.6-12.5-23.3v-62.2c0-30.9,25.1-56,56-56h6.7h6.7c30.9,0,56,25.1,56,56v62.2c0,9.7-5,18.3-12.5,23.3v59.9
                                c0,1.1,0.6,2,1.6,2.5c8.5,4.1,50,25.1,88.5,56.8c7,5.7,11,14.3,11,23.3v42.6H388.7z"/>                            
                    </svg>
                    <svg class="" id="Layer_1" style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M98.9,184.7l1.8,2.1l136,156.5c4.6,5.3,11.5,8.6,19.2,8.6c7.7,0,14.6-3.4,19.2-8.6L411,187.1l2.3-2.6  c1.7-2.5,2.7-5.5,2.7-8.7c0-8.7-7.4-15.8-16.6-15.8v0H112.6v0c-9.2,0-16.6,7.1-16.6,15.8C96,179.1,97.1,182.2,98.9,184.7z"/></svg>
                </div>
                </button>

                    <ul class="dropdown-menu shadow-lg text-sm rounded absolute hidden bg-indigo-700 text-indigo-200 py-1 px-3 right-0">
                        <li class="rounded-full bg-indigo-700 hover:bg-indigo-600 py-2 px-4 block whitespace-no-wrap"><h1 class="flex items-center p-2">{{ user.name }}</h1></li>
                        <li class="rounded-full bg-indigo-700 hover:bg-indigo-600 py-2 px-4 block whitespace-no-wrap">Licencia</li>
                        <li class="rounded-full bg-indigo-700 hover:bg-indigo-600 py-2 px-4 block whitespace-no-wrap">Settings</li>
                        <li>
                            <router-link to="/logout" class="rounded-full font-semibold bg-indigo-600 hover:bg-indigo-800 py-2 px-4 block whitespace-no-wrap">
                                Odhlásiť
                            </router-link>
                        </li>
                    </ul>
            </div>
            <!-- End User Dropdown Button -->

    </nav>
</template>

<script>
export default {
    props: ['user'],

    name: "UserNav",

}
</script>

<style>
.dropdown:hover .dropdown-menu {
  display: block;
}
</style>
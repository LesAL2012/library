<script setup>

import { Link } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import SetPaginateOnPage from '@/Includs/SetPaginateOnPage.vue';

const activeClass = 'text-red-700';



</script>

<script>
export default {
    methods: {
        isActive(route) {
            //return this.route().current() === route || this.route().current().includes(route);
            return this.route().current().split('.')[0] === route;
        }
    }
};
</script>

<template>
    <Layout>

        <aside id="side-menu" class="w-1/5 3xl:w-1/6 p-2 bg-orange-200 border-r-3 border-orange-600">

            <ul class="text-2xl ml-4 text-green-800">
                <li class="my-3 py-1 border-b-3 border-green-800 hover:text-blue-600 cursor-pointer">
                    <Link :href="route('settings')" :class="{ [activeClass]: isActive('settings') }">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-8 h-8 inline">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Settings
                    </Link>
                </li>


                <SetPaginateOnPage />


                <li
                    class="my-3 hover:text-blue-600  cursor-pointer border-b-3 border-blue-600 border-opacity-0 hover:border-opacity-100">
                    <Link :href="route('writers.index')" :class="{ [activeClass]: isActive('writers') }">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-8 h-8 inline">
                        <path
                            d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                        <path
                            d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                    </svg>
                    Writers
                    </Link>
                </li>
                <li
                    class="my-3 hover:text-blue-600 cursor-pointer border-b-3 border-blue-600 border-opacity-0 hover:border-opacity-100">
                    <Link :href="route('categories.index')" :class="{ [activeClass]: isActive('categories') }">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-8 h-8 inline">
                        <path
                            d="M7 3.5A1.5 1.5 0 018.5 2h3.879a1.5 1.5 0 011.06.44l3.122 3.12A1.5 1.5 0 0117 6.622V12.5a1.5 1.5 0 01-1.5 1.5h-1v-3.379a3 3 0 00-.879-2.121L10.5 5.379A3 3 0 008.379 4.5H7v-1z" />
                        <path
                            d="M4.5 6A1.5 1.5 0 003 7.5v9A1.5 1.5 0 004.5 18h7a1.5 1.5 0 001.5-1.5v-5.879a1.5 1.5 0 00-.44-1.06L9.44 6.439A1.5 1.5 0 008.378 6H4.5z" />
                    </svg>
                    Categories
                    </Link>
                </li>
                <li
                    class="my-3 hover:text-blue-600 cursor-pointer border-b-3 border-blue-600 border-opacity-0 hover:border-opacity-100">
                    <Link :href="route('genres.index')" :class="{ [activeClass]: isActive('genres') }">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-8 h-8 inline">
                        <path
                            d="M11.983 1.907a.75.75 0 00-1.292-.657l-8.5 9.5A.75.75 0 002.75 12h6.572l-1.305 6.093a.75.75 0 001.292.657l8.5-9.5A.75.75 0 0017.25 8h-6.572l1.305-6.093z" />
                    </svg>
                    Genres
                    </Link>
                </li>
                <li
                    class="my-3 hover:text-blue-600 cursor-pointer border-b-3 border-blue-600 border-opacity-0 hover:border-opacity-100">
                    <Link :href="route('type_genres.index')" :class="{ [activeClass]: isActive('type_genres') }">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-8 h-8 inline">
                        <path fill-rule="evenodd"
                            d="M2.5 3A1.5 1.5 0 001 4.5v4A1.5 1.5 0 002.5 10h6A1.5 1.5 0 0010 8.5v-4A1.5 1.5 0 008.5 3h-6zm11 2A1.5 1.5 0 0012 6.5v7a1.5 1.5 0 001.5 1.5h4a1.5 1.5 0 001.5-1.5v-7A1.5 1.5 0 0017.5 5h-4zm-10 7A1.5 1.5 0 002 13.5v2A1.5 1.5 0 003.5 17h6a1.5 1.5 0 001.5-1.5v-2A1.5 1.5 0 009.5 12h-6z"
                            clip-rule="evenodd" />
                    </svg>
                    Type of genres
                    </Link>
                </li>
                <li
                    class="my-3 hover:text-blue-600 cursor-pointer border-b-3 border-blue-600 border-opacity-0 hover:border-opacity-100">
                    <Link :href="route('tags.index')" :class="{ [activeClass]: isActive('tags') }">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-8 h-8 inline">
                        <path fill-rule="evenodd"
                            d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z"
                            clip-rule="evenodd" />
                    </svg>
                    Tags
                    </Link>
                </li>
            </ul>

        </aside>

        <section class="w-full  px-5 bg-gradient-to-t from-green-300 to-orange-300">
            <slot />

        </section>
    </Layout>
</template>

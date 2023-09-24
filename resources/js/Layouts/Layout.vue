<script setup>
import { Link, router } from '@inertiajs/vue3';

import Footer from '@/Includs/Footer.vue';

import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const activeClass = 'text-red-700';

const logout = () => {
    router.post(route('logout'));
};
</script>

<script>
export default {
    methods: {
        isActive(route) {
            return this.route().current() === route || this.route().current().includes(route) || window.location.href.split('/').includes(route);
        }
    }
};
</script>


<template>
    <div class="hidden" id="spinner">
        <div class="fixed top-0 right-0 h-screen w-screen z-50 flex justify-center items-center ">
            <div class="animate-spin rounded-full h-32 w-32 border-t-6 border-b-6 border-fuchsia-600"></div>
        </div>
    </div>

    <div class="wrapper flex flex-col h-screen">
        <header class="main-header-1 flex justify-between bg-orange-400 border-b-3 border-orange-600">

            <div class="flex items-center text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 mx-3">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                <h1 id="progect-name" class="text-center uppercase text-dark font-bold inline-block ">
                    {{ $page.props.appName }}
                </h1>
            </div>

            <nav class="nav font-semibold text-lg ">
                <ul class="flex items-center">
                    <li
                        class="p-1 mx-3 border-y-2 border-blue-700 border-opacity-0 hover:border-opacity-100 hover:text-blue-700 hover:bg-orange-300 duration-200 cursor-pointer">
                        <Link :href="route('home')" :class="{ [activeClass]: isActive('home') }">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 inline">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Home
                        </Link>
                    </li>
                    <li
                        class="p-1 mx-3 border-y-2 border-blue-700 border-opacity-0 hover:border-opacity-100 hover:text-blue-700 hover:bg-orange-300 duration-200 cursor-pointer">
                        <Link :href="route('books.index')" :class="{ [activeClass]: isActive('books.index') }">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 inline">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                        Books
                        </Link>
                    </li>

                    <li class=" p-1 mx-3 border-y-2 border-blue-700 border-opacity-0 hover:border-opacity-100 hover:text-blue-700 hover:bg-orange-300 duration-200 cursor-pointer"
                        :class="{ 'pointer-events-none text-gray-500': !$page.props.auth.user }">

                        <Link :href="route('settings')" :class="{ [activeClass]: isActive('settings') }">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 inline">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>

                        Settings
                        </Link>
                    </li>
                    <li class="p-1 mx-3 border-y-2 border-blue-700 border-opacity-0 hover:border-opacity-100 hover:text-blue-700 hover:bg-orange-300 duration-200 cursor-pointer"
                        :class="{ 'pointer-events-none text-gray-500': !$page.props.auth.user || !$page.props.user_rp.roles.name.includes('admin') }">
                        <a href="/laratrust/roles-assignment">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-4 h-4 inline">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>

                            Roles&Permissions
                        </a>
                    </li>
                    <li
                        class=" p-1 mx-3 border-y-2 border-blue-700 border-opacity-0 hover:border-opacity-100 hover:text-blue-700 hover:bg-orange-300 duration-200 cursor-pointer">

                        <Link :href="route('packages')" :class="{ [activeClass]: isActive('packages') }">
                        <img class="w-4 h-4 inline" src="/storage/images/img/resource-64.png" alt="resource">

                        Packages
                        </Link>
                    </li>

                    <li
                        class=" p-1 mx-3 border-y-2 border-blue-700 border-opacity-0 hover:border-opacity-100 hover:text-blue-700 hover:bg-orange-300 duration-200 cursor-pointer">

                        <a href="/api/documentation" :class="{ [activeClass]: isActive('documentation') }">
                        <img class="w-4 h-4 inline" src="/storage/images/img/swagger_icon_130134.png" alt="swagger">

                        Swagger
                        </a>
                    </li>
                </ul>
            </nav>




            <div v-if="$page.props.canLogin" class="w-auto   py-2 px-5 text-center ">

                <div v-if="$page.props.auth.user">

                    <span v-for="name in $page.props.user_rp.roles.display_name" class="px-1 text-white">
                        {{ name }}
                    </span>

                    <Dropdown width="48" class="inline-block">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center
                                    px-3 py-1
                                    text-sm leading-4
                                    font-medium rounded-md
                                    text-gray-500 bg-white hover:text-gray-700
                                    focus:outline-none focus:bg-gray-50 active:bg-gray-50
                                    transition ease-in-out duration-150">


                                    <img v-if="$page.props.auth.user.provider && $page.props.auth.user.provider != 'favicon.ico'"
                                        :src="'/storage/images/socialite/' + $page.props.auth.user.provider + '.png'"
                                        :alt="$page.props.auth.user.provider" class="m-0 mr-2" style="width: 14px;">
                                    <img v-else-if="$page.props.auth.user.provider && $page.props.auth.user.provider == 'favicon.ico'"
                                        :src="'/' + $page.props.auth.user.provider" :alt="$page.props.auth.user.provider"
                                        class="m-0 mr-2" style="width: 14px;">
                                    <img v-else src="/favicon.ico" alt="book" class="m-0 mr-2" style="width: 14px;">

                                    {{ $page.props.auth.user.name }}

                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </span>
                        </template>

                        <template #content>

                            <DropdownLink :href="route('profile.show')">
                                Profile
                            </DropdownLink>

                            <div class="border-t border-gray-200" />

                            <!-- Authentication -->
                            <form @submit.prevent="logout">
                                <DropdownLink as="button">
                                    Log Out
                                </DropdownLink>
                            </form>
                        </template>
                    </Dropdown>
                </div>

                <div v-else>
                    <Link :href="route('login')"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                    Log in
                    </Link>

                    <Link v-if="$page.props.canRegister" :href="route('register')"
                        class="ml-6 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                    Register
                    </Link>
                </div>
            </div>


        </header>

        <p v-if="$page.props.message"
            class="bg-indigo-600 h-10 flex items-center justify-center text-sm font-medium text-white px-4 sm:px-6 lg:px-8">
            {{ $page.props.message }}
        </p>

        <main class="flex flex-grow">
            <slot />
        </main>

        <Footer />
    </div>
</template>

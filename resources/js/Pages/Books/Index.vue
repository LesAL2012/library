<script setup>
import { ref, onBeforeMount, onMounted } from 'vue';
import { getCookie, reloadPage } from '@/functions';
import { Head, Link, useForm } from '@inertiajs/vue3';

import Layout from '@/Layouts/Layout.vue'
import Pagination from '@/Includs/Pagination.vue';
//import SetPaginateOnPage from '@/Includs/SetPaginateOnPage.vue';
import SetFiltefSortGlobal from './SetFiltefSortGlobal.vue';

let props = defineProps({
    title: String,
    books: Object,
    years: Array,
    writers: Object,
    category: Object,
    tag: Object,
    genre: Object,
    type: Object,
});

let messageT = getCookie('messageSearchT') && getCookie('messageSearchT') != '' ? true : false;
let messageW = getCookie('messageSearchW') && getCookie('messageSearchW') != '' ? true : false;
let messageC = getCookie('messageSearchC') && getCookie('messageSearchC') != '' ? true : false;

let messageType = getCookie('messageSearchType') && getCookie('messageSearchType') != '' ? true : false;
let messageG = getCookie('messageSearchG') && getCookie('messageSearchG') != '' ? true : false;
let messageTag = getCookie('messageSearchTag') && getCookie('messageSearchTag') != '' ? true : false;

let messageDelBook = getCookie('messageDeleteBook') && getCookie('messageDeleteBook') != '' ? true : false;

let sortDirLocal = localStorage.getItem('localSortDir') && localStorage.getItem('localSortDir') != '' ? localStorage.getItem('localSortDir') : 'ASC';
let sortActionLocal = localStorage.getItem('localSortAction') && localStorage.getItem('localSortAction') != '' ? localStorage.getItem('localSortAction') : 'id';


const books = ref(props.books.data);
const localDirSort = ref(sortDirLocal);
const localActionSort = ref(sortActionLocal);

onBeforeMount(() => {
    if (!localStorage.getItem('localSortDir') || localStorage.getItem('localSortDir') == undefined) {
        localStorage.setItem('localSortDir', 'ASC');
    };
    if (!localStorage.getItem('localSortAction') || localStorage.getItem('localSortAction') == undefined) {
        localStorage.setItem('localSortAction', 'id');
    }

});
onMounted(() => {
    sortParam(localDirSort.value, localActionSort.value);
});


let dirrPageLocalSortArr = [
    { action: 'id', title: 'ID' },
    { action: 'name', title: 'Title' },
    { action: 'year', title: 'Year' },
    { action: 'liked_users_count', title: 'Likes' },

    { action: 'category.name', title: 'Category' },
    { action: 'genre.name', title: 'Genre' },
    { action: 'type_genre.name', title: 'Type' },
    { action: 'writer.name', title: 'Аuthor' },
];

function setLocalSortDir() {
    if (localDirSort.value == 'ASC') {
        localStorage.setItem('localSortDir', 'DESC');
        localDirSort.value = 'DESC';
    } else {
        localStorage.setItem('localSortDir', 'ASC');
        localDirSort.value = 'ASC';
    }
}

function sortLocal(parameter) {

    if (localStorage.getItem('localSortAction') == parameter) {
        setLocalSortDir();
    };

    localStorage.setItem('localSortAction', parameter);

    localActionSort.value = parameter;

    sortParam(localDirSort.value, parameter);
}

function sortParam(direction, parameter) {

    let param = parameter.split('.');
    let param_a = parameter.split('.')[0];
    let param_b = parameter.split('.')[1];

    if (param.length == 1) {
        if (direction == 'ASC') {
            books.value.sort(function (a, b) {
                if (a[parameter] < b[parameter]) {
                    return 1;
                }
                if (a[parameter] > b[parameter]) {
                    return -1;
                }
                return 0;
            });
        } else {
            books.value.sort(function (a, b) {
                if (a[parameter] > b[parameter]) {
                    return 1;
                }
                if (a[parameter] < b[parameter]) {
                    return -1;
                }
                return 0;
            });
        }
    } else {

        books.value.forEach(element => {
            element['_name_sort'] = element[param_a][param_b];
        });

        if (direction == 'ASC') {
            books.value.sort(function (a, b) {
                if (a._name_sort < b._name_sort) {
                    return 1;
                }
                if (a._name_sort > b._name_sort) {
                    return -1;
                }
                return 0;
            });
        } else {
            books.value.sort(function (a, b) {
                if (a._name_sort > b._name_sort) {
                    return 1;
                }
                if (a._name_sort < b._name_sort) {
                    return -1;
                }
                return 0;
            });
        }
    }
}

const form = useForm({
    id: null,
});

function toggleLike(id) {
    form.post(route('like.store', id));
    reloadPage();
}

function checkUserId(user_id, book_id) {
    let count = 0;
    books.value.forEach(book => {
        if (book.id == book_id) {

            book.liked_users.forEach(likes => {
                if (likes.user_id == user_id) {
                    count++;
                }
            });
        }
    });
    return count > 0 ? true : false;
}

</script>

<template>
    <Head :title="title" />

    <Layout>

        <aside id="side-menu" class="w-1/4 3xl:w-1/5 p-2 bg-orange-200 border-r-3 border-orange-600">
            <!-- <SetPaginateOnPage /> -->

            <SetFiltefSortGlobal :years="props.years" :writers="props.writers" :category="props.category" :tag="props.tag"
                :genre="props.genre" :type="props.type" />
        </aside>

        <section v-if="props.books.data.length > 0"
            class="w-3/4 3xl:w-4/5 px-5 bg-yellow-100 bg-gradient-to-t from-green-300 to-orange-300">

            <div>
                <div v-if="messageT"
                    class="text-center text-4xl text-white m-2 bg-red-900 rounded-xl border-3 border-white">
                    {{ getCookie('messageSearchT') }}
                </div>
                <div v-if="messageW"
                    class="text-center text-4xl text-white m-2 bg-red-900 rounded-xl border-3 border-white">
                    {{ getCookie('messageSearchW') }}
                </div>
                <div v-if="messageC"
                    class="text-center text-4xl text-white m-2 bg-red-900 rounded-xl border-3 border-white">
                    {{ getCookie('messageSearchC') }}
                </div>

                <div v-if="messageType"
                    class="text-center text-4xl text-white m-2 bg-red-900 rounded-xl border-3 border-white">
                    {{ getCookie('messageSearchType') }}
                </div>
                <div v-if="messageG"
                    class="text-center text-4xl text-white m-2 bg-red-900 rounded-xl border-3 border-white">
                    {{ getCookie('messageSearchG') }}
                </div>
                <div v-if="messageTag"
                    class="text-center text-4xl text-white m-2 bg-red-900 rounded-xl border-3 border-white">
                    {{ getCookie('messageSearchTag') }}
                </div>
                <div v-if="messageDelBook"
                    class="text-center text-4xl text-white m-2 bg-red-900 rounded-xl border-3 border-white">
                    {{ getCookie('messageDeleteBook') }}
                </div>
            </div>

            <div class="flex justify-between">


                <Link :href="route('books.create')"
                    class="inline-block w-32 my-1 p-3 border-3 border-green-900 bg-blue-300 text-black rounded-xl"
                    v-if="$page.props.user_rp.roles.name.includes('admin') || $page.props.user_rp.roles.name.includes('moderator')"
                    >
                Add boook
                </Link>

                <Pagination class="w-full" :links="props.books.links" />
            </div>

            <div class="flex justify-between p-1 border-3 border-green-800 rounded-lg bg-orange-100 mt-1">
                <h3 class=" text-lg font-medium text-gray-900 dark:text-white text-center">
                    <span class="text-red-700 pl-1"><b>Local</b></span> sorting options: by page
                </h3>

                <button v-for="btn in dirrPageLocalSortArr" @click="sortLocal(btn.action)"
                    class="w-1/12 border-2 border-green-800 rounded-lg"
                    :class="{ 'bg-green-500': btn.action == localActionSort, 'bg-green-200': btn.action != localActionSort, }">
                    {{ btn.title }}

                    <div v-if="btn.action == localActionSort" class="inline-block">

                        <svg v-if="localDirSort == 'ASC'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" class="w-5 h-5 inline">
                            <path fill-rule="evenodd"
                                d="M10 18a.75.75 0 01-.75-.75V4.66L7.3 6.76a.75.75 0 11-1.1-1.02l3.25-3.5a.75.75 0 011.1 0l3.25 3.5a.75.75 0 01-1.1 1.02l-1.95-2.1v12.59A.75.75 0 0110 18z"
                                clip-rule="evenodd" />
                        </svg>

                        <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-5 h-5 inline">
                            <path fill-rule="evenodd"
                                d="M10 2a.75.75 0 01.75.75v12.59l1.95-2.1a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 111.1-1.02l1.95 2.1V2.75A.75.75 0 0110 2z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>



                </button>
            </div>


            <div
                class="grid mt-2 gap-1 sm:gap-2 md:gap-3 xl:gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 ">
                <div v-for="book in books" :key="book.id"
                    class="border-3 border-green-900 rounded-xl overflow-hidden bg-orange-200">
                    <div class="text-center  flex justify-between p-1 text-xl">
                        <div class=" font-bold w-1/5 pt-1">

                            <span class="bg-blue-300 rounded-md p-1 border-1 border-black text-sm">
                                {{ book.year }}
                            </span>
                            <br>
                            <span class="text-xs italic mt-3 inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5 inline">
                                    <path
                                        d="M11.983 1.907a.75.75 0 00-1.292-.657l-8.5 9.5A.75.75 0 002.75 12h6.572l-1.305 6.093a.75.75 0 001.292.657l8.5-9.5A.75.75 0 0017.25 8h-6.572l1.305-6.093z" />
                                </svg>

                                Genre: {{ book.genre.name }}
                            </span>

                            <!-- {{ $page.props.auth.user.id }}
 -->
                            <span v-if="$page.props.auth.user">
                                <form @submit.prevent="toggleLike(book.id)">

                                    <button type="submit" :disabled="form.processing">
                                        <svg v-if="checkUserId($page.props.auth.user.id, book.id)"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red"
                                            class="w-12 h-12 inline">
                                            <path
                                                d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                        </svg>


                                        <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-red-500 inline">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                        </svg>
                                    </button>

                                </form>
                            </span>

                            <span v-else>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-12 h-12 text-gray-500 inline">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                            </span>

                        </div>

                        <div class="w-auto">
                            <Link :href="route('books.show', book.id)">
                            <img :src="`/storage/images/books_title_img_min/${book.image}`" :alt="book.image"
                                class="rounded-md border-1 border-black hover:scale-105"
                                style="max-width: 125px; max-height: 160px;">
                            </Link>
                        </div>


                        <div class=" w-1/5 text-center">

                            <span v-if="book.liked_users_count > 0" class="text-red-600 font-semibold text-sm">
                                {{ book.liked_users_count }}
                            </span>
                            <span v-else class="text-black opacity-50 font-semibold text-sm">
                                {{ book.liked_users_count }}
                            </span>


                            <svg v-if="book.liked_users_count > 0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="red" class="w-6 h-6 inline">
                                <path
                                    d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />

                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black"
                                class="w-6 h-6 inline opacity-50">
                                <path
                                    d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />

                            </svg>


                            <span class=" font-semibold text-xs inline-block mt-3 pt-5 border-t-2 border-black">
                                ID: {{ book.id }}
                            </span>

                            <br>

                            <span class=" font-semibold text-xs inline-block mt-3 pt-5 border-t-2 border-black">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5 inline">
                                    <path fill-rule="evenodd"
                                        d="M10 1c-1.716 0-3.408.106-5.07.31C3.806 1.45 3 2.414 3 3.517V16.75A2.25 2.25 0 005.25 19h9.5A2.25 2.25 0 0017 16.75V3.517c0-1.103-.806-2.068-1.93-2.207A41.403 41.403 0 0010 1zM5.99 8.75A.75.75 0 016.74 8h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75h-.01a.75.75 0 01-.75-.75v-.01zm.75 1.417a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75v-.01a.75.75 0 00-.75-.75h-.01zm-.75 2.916a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75h-.01a.75.75 0 01-.75-.75v-.01zm.75 1.417a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75v-.01a.75.75 0 00-.75-.75h-.01zm1.417-5.75a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75h-.01a.75.75 0 01-.75-.75v-.01zm.75 1.417a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75v-.01a.75.75 0 00-.75-.75h-.01zm-.75 2.916a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75h-.01a.75.75 0 01-.75-.75v-.01zm.75 1.417a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75v-.01a.75.75 0 00-.75-.75h-.01zm1.42-5.75a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75h-.01a.75.75 0 01-.75-.75v-.01zm.75 1.417a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75v-.01a.75.75 0 00-.75-.75h-.01zm-.75 2.916a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75h-.01a.75.75 0 01-.75-.75v-.01zm.75 1.417a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75v-.01a.75.75 0 00-.75-.75h-.01zM12.5 8.75a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75h-.01a.75.75 0 01-.75-.75v-.01zm.75 1.417a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75v-.01a.75.75 0 00-.75-.75h-.01zm0 2.166a.75.75 0 01.75.75v2.167a.75.75 0 11-1.5 0v-2.167a.75.75 0 01.75-.75zM6.75 4a.75.75 0 00-.75.75v.5c0 .414.336.75.75.75h6.5a.75.75 0 00.75-.75v-.5a.75.75 0 00-.75-.75h-6.5z"
                                        clip-rule="evenodd" />
                                </svg>

                                Total<br> {{ book.amount }}


                            </span>


                        </div>
                    </div>


                    <div class=" font-semibold text-xs italic ml-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-5 h-5 inline">
                            <path fill-rule="evenodd"
                                d="M2.5 3A1.5 1.5 0 001 4.5v4A1.5 1.5 0 002.5 10h6A1.5 1.5 0 0010 8.5v-4A1.5 1.5 0 008.5 3h-6zm11 2A1.5 1.5 0 0012 6.5v7a1.5 1.5 0 001.5 1.5h4a1.5 1.5 0 001.5-1.5v-7A1.5 1.5 0 0017.5 5h-4zm-10 7A1.5 1.5 0 002 13.5v2A1.5 1.5 0 003.5 17h6a1.5 1.5 0 001.5-1.5v-2A1.5 1.5 0 009.5 12h-6z"
                                clip-rule="evenodd" />
                        </svg>

                        Type: {{ book.type_genre.name }}
                    </div>

                    <div class="font-bold text-md text-center text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-5 h-5 inline">
                            <path fill-rule="evenodd"
                                d="M5.5 3A2.5 2.5 0 003 5.5v2.879a2.5 2.5 0 00.732 1.767l6.5 6.5a2.5 2.5 0 003.536 0l2.878-2.878a2.5 2.5 0 000-3.536l-6.5-6.5A2.5 2.5 0 008.38 3H5.5zM6 7a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd" />
                        </svg>

                        Tags:
                        <span v-for="tag in book.tags.sort((a, b) => a.name > b.name ? 1 : -1)"
                            class="m-1 px-1 border-1 border-black rounded-md text-xs text-white bg-red-600">
                            {{ tag.name }}
                        </span>
                    </div>
                    <div class="font-bold text-md text-center text-green-900">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-5 h-5 inline">
                            <path
                                d="M7 3.5A1.5 1.5 0 018.5 2h3.879a1.5 1.5 0 011.06.44l3.122 3.12A1.5 1.5 0 0117 6.622V12.5a1.5 1.5 0 01-1.5 1.5h-1v-3.379a3 3 0 00-.879-2.121L10.5 5.379A3 3 0 008.379 4.5H7v-1z" />
                            <path
                                d="M4.5 6A1.5 1.5 0 003 7.5v9A1.5 1.5 0 004.5 18h7a1.5 1.5 0 001.5-1.5v-5.879a1.5 1.5 0 00-.44-1.06L9.44 6.439A1.5 1.5 0 008.378 6H4.5z" />
                        </svg>

                        Category:
                        <span class=" m-1 px-1 border-1 border-black rounded-md text-xs text-white bg-green-600">
                            {{ book.category.name }}
                        </span>
                    </div>

                    <div
                        class="flex items-center justify-center bg-white h-16 rounded-2xl m-1 p-2 border-1 border-green-900">
                        <h1 class="text-center font-semibold  text-md">
                            {{ book.name }}
                        </h1>
                    </div>

                    <p class="text-center font-semibold text-xs italic p-2 h-20">
                        <span class=" font-semibold text-xs not-italic underline">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-5 h-5 inline">
                                <path fill-rule="evenodd"
                                    d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"
                                    clip-rule="evenodd" />
                            </svg>

                            Description
                        </span> {{ book.description }}
                    </p>

                    <div class="flex items-center justify-center bg-red-100 h-16 border-green-800 border-t-3 p-2">
                        <h2 class="text-center text-xl font-bold ">
                            <span class=" font-semibold text-xs underline">
                                Writer
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5 inline">
                                    <path
                                        d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                    <path
                                        d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                </svg>
                            </span> {{ book.writer.name }}
                        </h2>
                    </div>


                </div>

            </div>

            <Pagination :links="props.books.links" />


        </section>

        <section v-else
            class="w-full flex items-center justify-center  xl:w-3/4 px-5 bg-yellow-100 bg-gradient-to-t from-green-300 to-orange-300 text-2xl">
            There are no such books....
        </section>
    </Layout>
</template>

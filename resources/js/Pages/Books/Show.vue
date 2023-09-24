<script setup>

import { Head, Link, router } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import { back } from '@/functions';

let props = defineProps({
    bookFull: Object,
});
let book = props.bookFull[0];

function destroy() {
    if (confirm(`Are you sure you want to Delete this book? \n
    The title of the book - ${book.name} \n
    Year - ${book.year} |  ID - ${book.id}\n`)) {
        router.post(route('books.destroy', book.id), {
            _method: 'delete',
        });
    }
};

</script>

<template>
    <Head :title="book.name" />

    <Layout>

        <aside id="side-menu" class="p-2 bg-orange-200 border-r-3 border-orange-600">

            <div class="text-4xl pl-5 font-semibold">
                <div class="flex justify-between text-blue-600 text-xl py-2 border-b-2 border-green-800 text-end">
                    <div @click="back" class="w-1/2 text-indigo-600 hover:text-indigo-900 hover:cursor-pointer">
                        &#8678; Back...
                    </div>
                    <div class="px-3 w-1/2">
                        <Link :href="route('books.edit', book.id)"
                            class="px-2 text-orange-600 hover:text-orange-900 hover:border-orange-900 text-center border-3 border-orange-600 rounded-md"
                            :class="{ 'pointer-events-none text-slate-100 bg-slate-300 border-slate-400': !$page.props.user_rp.roles.name.includes('admin') && !$page.props.user_rp.roles.name.includes('moderator') }">
                        Edit book
                        </Link>
                    </div>
                </div>
                <div class="border-3 border-green-600 rounded-2xl mt-5 pl-5">
                    <div class="text-blue-700 my-4 ">
                        Year: {{ book.year }}
                    </div>
                    <div class="my-4">
                        Amount: {{ book.amount }}
                    </div>
                    <div class=" my-4 text-green-700">
                        Genre: {{ book.genre.name }}
                    </div>
                    <div class=" my-4 text-yellow-700">
                        Type: {{ book.type_genre.name }}
                    </div>
                    <div
                        :class="{ 'text-red-600 my-4': book.liked_users_count > 0, 'text-gray-600 my-4': book.liked_users_count == 0 }">
                        &#10084; {{ book.liked_users_count }}
                    </div>
                    <div class=" my-4">
                        ID: {{ book.id }}
                    </div>

                    <div>
                        <button @click="destroy"
                            class="p-3 m-3 text-red-700 bg-red-200 hover:bg-orange-300 hover:text-indigo-900 text-center border-3 border-red-800 rounded-md"
                            v-if="$page.props.user_rp.permissions_all.name.includes('books-delete')">
                            Delete this book
                        </button>

                        <button
                            class="p-3 m-3 text-slate-100 bg-slate-300 border-slate-400 text-center border-3 rounded-md cursor-default"
                            v-else>
                            Delete this book
                        </button>
                    </div>
                </div>


            </div>

        </aside>

        <section class="w-full px-5 bg-yellow-100 bg-gradient-to-t from-green-300 to-orange-300">
            <div class="text-2xl flex justify-between">
                <div class="p-2 pt-4">
                    <img :src="`/storage/images/books_title_img/${book.image}`"
                        class="w-auto rounded-2xl border-2 border-black " style="max-width: 450px; max-height: 600px;">
                </div>
                <div class="my-2 p-2">
                    <h1 class="bg-white rounded-2xl py-2 mb-5 text-4xl uppercase text-center border-2 border-black"
                        style="font-weight: 900;">
                        {{ book.name }}
                    </h1>
                    <p class="m-2 py-5 border-y-2 border-green-800 text-orange-800" style="font-weight: 600;">
                        Writer:
                        {{ book.writer.name }}
                    </p>
                    <h2 class="p-2 " style="font-weight: 600;">Description</h2>
                    <p class="my-2 p-2">
                        {{ book.description }}
                    </p>

                    <p class="my-2 p-2" v-html="book.description_more">
                    </p>

                    <p class="m-2 py-5 border-t-2 border-green-800">
                        Tags:
                        <span v-for="tag in book.tags" class="bg-red-800 text-white py-2 px-5 m-3 rounded-2xl">
                            {{ tag.name }}
                        </span>
                    </p>
                    <p class="m-2 py-5 border-t-2 border-green-800">
                        Category:
                        <span class="bg-green-800 text-white py-2 px-5 m-3 rounded-2xl">
                            {{ book.category.name }}
                        </span>

                    </p>
                </div>

            </div>
        </section>
    </Layout>
</template>

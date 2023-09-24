<script setup>

import { Head, useForm, router } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import Layout from '@/Layouts/Layout.vue';
import { back } from '@/functions';

import Multiselect from '@vueform/multiselect';
import "@vueform/multiselect/themes/default.css";

import Dropzone from 'dropzone';

import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';


let props = defineProps({
    bookFull: Object,
    paramArr: Object,
});
let book = props.bookFull[0];
let params = props.paramArr;

/* console.log(book);
console.log(params);
console.log(params.tag);
console.log(book.tags); */

let optionsTag = params.tag;
let optionsTagArr = [];
Object.keys(optionsTag).map(tag => {
    optionsTagArr.push(optionsTag[tag].name);
});

let valueTag = [];
Object.keys(book.tags).map(tag => {
    valueTag.push(book.tags[tag].name);
});

const form = useForm({

    year: book.year,
    amount: book.amount,
    genre_id: book.genre.id,
    type_genre_id: book.type_genre_id,

    image: [],

    name: book.name,
    writer_id: book.writer_id,
    description: book.description,
    description_more: book.description_more,

    tags: [],

    category_id: book.category_id,
});

let dropzone = null;


function update(id) {
    //delete form.genre_id;


    const files = dropzone.getAcceptedFiles();
    const formData = new FormData();
    files.forEach(file => {
        formData.append('images[]', file);
    });
    //console.log(formData);
    //console.log(dropzone.getAcceptedFiles());
    //return false;
    form.image = dropzone.getAcceptedFiles();

    /*  console.log(form.image);
     return false; */

    //console.log(form.image);

    //form.put(route('books.update', id));

    router.post(route('books.update', id), {
        _method: 'put',
        form: form,
    });
};

function setTypeGenreOption() {
    let opt = '';

    form.type_genre_id = null;

    params.type.map(elem => {
        if (form.genre_id == elem.genre_id) {

            if (elem.id == book.type_genre_id) {
                form.type_genre_id = elem.id;
            }

            opt += '<option key="type_genre_' + elem.id + '" value="' + elem.id + '">';
            opt += elem.genre_id + ':' + elem.name;
            opt += '</option>';
        }
    });
    //form.type_genre_id;
    document.getElementById('id_type_genre').innerHTML = opt;
};

onMounted(() => {
    setTypeGenreOption();

    dropzone = new Dropzone("div#dropzoneId", {
        url: "uyuy54654654654",
        autoProcessQueue: false,

        addRemoveLinks: true,
        dictResponseError: 'Server not Configured',
        acceptedFiles: ".png,.jpg,.gif,.bmp",

        //upload only one file
        maxFiles: 1,
        init: function () {
            this.on("maxfilesexceeded", function (file) {
                this.removeAllFiles();
                this.addFile(file);
            });
        }
    });




});



function setTagInForm(value) {

    let tags = [];
    value.map(tagName => {
        Object.keys(optionsTag).map(tag => {
            if (optionsTag[tag].name == tagName) {
                tags.push(optionsTag[tag].id);
            }

        });
    })

    form.tags = tags;
}



</script>

<template>
    <Head :title="book.name" />

    <form @submit.prevent="update(book.id)" enctype="multipart/form-data">
        <Layout>
            <aside id="side-menu" class="p-2 bg-orange-200 border-r-3 border-orange-600">

                <div class="text-xl pl-5" style="font-weight: 600;">

                    <div class="flex justify-betweentext-blue-600 text-xl py-2 border-b-2 border-green-800 text-center">
                        <div @click="back" class="w-1/2 text-indigo-600 hover:text-indigo-900 hover:cursor-pointer pr-2">
                            &#8678; Back...
                        </div>
                        <div class="px-3 w-1/2">
                            <button :disabled="form.processing" type="submit"
                                class="px-2 text-green-700 bg-green-200 hover:bg-orange-300 hover:text-indigo-900  text-center border-3 border-green-600 rounded-md">
                                Update book
                            </button>
                        </div>
                    </div>
                    <div class="border-3 border-red-700 rounded-2xl mt-5 pl-5 bg-gray-100">
                        <div class=" my-4">
                            UPDATE id: {{ book.id }}
                        </div>
                        <div class="text-blue-700 my-4 ">
                            Year:
                            <input id="id_year" :class="{ 'border-red-500': form.errors.name }" v-model="form.year"
                                type="number"
                                class="w-1/3 bg-gray-300 rounded-2xl py-2 mb-5 text-xl text-center border-2 border-black">

                            <div class="text-red-900 mt-2" v-if="form.errors.name">{{ form.errors.name }}</div>
                        </div>

                        <div class="text-black my-4 ">
                            Amount:
                            <input id="id_amount" :class="{ 'border-red-500': form.errors.name }" v-model="form.amount"
                                type="number"
                                class="w-1/2 bg-gray-300 rounded-2xl py-2 mb-5 text-xl text-center border-2 border-black">

                            <div class="text-red-900 mt-2" v-if="form.errors.name">{{ form.errors.name }}</div>
                        </div>

                        <div class="my-4 text-green-700" style="font-weight: 600;">
                            <label for="id_genre">Genre: </label>

                            <select @change="setTypeGenreOption" id="id_genre" v-model="form.genre_id"
                                class="rounded-xl ml-3 bg-gray-300 text-xl  border-2 border-black">
                                <option v-for="genre in params.genre" :key="'genre_' + genre.id" :value="genre.id">
                                    {{ genre.id }}:{{ genre.name }}</option>
                            </select>
                            <div class="text-red-900 mt-2" v-if="form.errors.name">{{ form.errors.name }}</div>
                        </div>

                        <div class="my-4 text-yellow-700" style="font-weight: 600;">
                            <label for="id_type_genre">Type: </label>



                            <select id="id_type_genre" v-model="form.type_genre_id"
                                class="rounded-xl w-9/12 mt-1 bg-gray-300 text-xl  border-2 border-black">

                            </select>
                            <div class="text-red-900 mt-2" v-if="form.errors.name">{{ form.errors.name }}</div>
                        </div>





                        <div
                            :class="{ 'text-red-600 my-4': book.liked_users_count > 0, 'text-gray-600 my-4': book.liked_users_count == 0 }">
                            &#10084; {{ book.liked_users_count }}
                        </div>
                        <div v-if="form.isDirty" class="bg-red-800 text-white p-5 mr-3 mb-3 text-sm rounded-md  ">
                            Something has changed, don't forget to save the form
                        </div>
                    </div>

                </div>

            </aside>

            <section class="w-full  xl:w-3/4 px-5 bg-yellow-100 bg-gradient-to-t from-green-300 to-orange-300">
                <div class="text-xl flex justify-between">
                    <div class="w-2/5 ">
                        <div class="p-2 pt-4 flex">

                            <div class="w-3/4">
                                <img :src="`/storage/images/books_title_img/${book.image}`"
                                    class="rounded-2xl border-2 border-black " style="max-width:300px; max-height: 400px;">
                            </div>

                            <div id="dropzoneId"
                                class="w-1/4 overflow-hidden px-5 py-1 rounded-2xl bg-slate-700 text-white text-center text-xs cursor-pointer"
                                style="height: 400px;">
                                Select image
                            </div>


                        </div>
                        <!-- <input type="file" @input="form.image = $event.target.files[0]" /> -->


                        <div>
                            <div class="m-2 py-5 border-t-2 border-green-800">
                                Tags:
                                <Multiselect @change="setTagInForm" v-model="valueTag" :options="optionsTagArr" mode="tags"
                                    placeholder="Select tags" class="text-2xl p-1"
                                    style="border:2px solid black; border-radius: 20px; width: 400px; display: inline-block; margin: 0 0 0 10px;" />
                            </div>

                            <div class="m-2 py-5 border-t-2 border-green-800">
                                <label for="id_category">Category:</label>

                                <select id="id_category" v-model="form.category_id"
                                    class="rounded-2xl ml-3 text-white bg-green-600 text-xl border-3 border-black">
                                    <option v-for="category in params.category" :key="'category_' + category.id"
                                        :value="category.id">{{
                                            category.name }}</option>
                                </select>
                                <div class="text-red-900 mt-2" v-if="form.errors.name">{{ form.errors.name }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="w-3/5 my-2 p-2">
                        <div>
                            <label for="id_name" class="block text-sm font-semibold text-gray-700">The title of the
                                book</label>

                            <input id="id_name" :class="{ 'border-red-500': form.errors.name }" v-model="form.name"
                                type="text"
                                class="w-full font-bold bg-gray-300 rounded-2xl py-2 mb-5 text-xl border-2 border-black">

                            <div class="text-red-900 mt-2" v-if="form.errors.name">{{ form.errors.name }}</div>
                        </div>


                        <div class="m-2 py-5 border-y-2 border-green-800 text-orange-800" style="font-weight: 600;">
                            <label for="id_writer">Writer:</label>

                            <select id="id_writer" v-model="form.writer_id"
                                class="rounded-xl ml-3 bg-gray-300 text-xl border-2 border-black">
                                <option v-for="writer in params.writers" :key="'writer_' + writer.id" :value="writer.id">{{
                                    writer.name }}</option>
                            </select>
                            <div class="text-red-900 mt-2" v-if="form.errors.name">{{ form.errors.name }}</div>
                        </div>

                        <div>
                            <label for="id_description" class="p-2 " style="font-weight: 600;">
                                Description
                            </label>

                            <textarea id="id_description" rows="3" v-model="form.description"
                                class="block w-full bg-gray-300 text-xl border-2 border-black rounded-xl">
                            </textarea>

                            <p class="mb-3 text-sm leading-6 text-gray-600">Write a few sentences - short description.</p>
                            <div class="text-red-900 mt-2" v-if="form.errors.name">{{ form.errors.name }}</div>
                        </div>

                        <div class="block w-full border-2 border-black rounded-xl">

                            <QuillEditor contentType="html" v-model:content="form.description_more" theme="snow" :toolbar="[
                                ['bold', 'italic', 'underline'],
                                ['blockquote', 'code-block'],
                                [{ 'header': 1 }, { 'header': 2 }, { 'header': 3 }],
                                [{ 'list': 'ordered' }, { 'list': 'bullet' }],

                                [{ 'indent': '-1' }, { 'indent': '+1' }],
                                [{ 'direction': 'rtl' }],
                                [{ 'size': ['small', false, 'large', 'huge'] }],
                                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

                                [{ 'color': [] }, { 'background': [] }],
                                [{ 'align': [] }],
                                ['clean'],
                                ['link', /* 'image', */],

                            ]
                                " />


                            <p class="mb-3 px-1 text-sm leading-6 text-gray-600">Add few sentences for description.</p>
                            <div class="text-red-900 mt-2" v-if="form.errors.name">{{ form.errors.name }}</div>
                        </div>
                    </div>

                </div>
            </section>
        </Layout>
    </form>
</template>


<style >
.multiselect-tag {
    font-weight: 300;
    font-size: 20px;
    border-radius: 15px;
    background: rgb(153, 27, 27);
    padding: 10px
}

.dz-success-mark,
.dz-error-mark {
    display: none;
}

.dz-remove {
    color: lightcoral;
    font-size: 20px;
    font-weight: 900;
}

.ql-container {
    background-color: lightgray;
    font-size: 16px;
}

.ql-toolbar {
    background-color: lightyellow;
    font-size: 16px;
    border-radius: 10px 10px 0 0;
}
</style>

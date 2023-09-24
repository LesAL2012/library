<script setup>

import { Head, useForm, router } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import Layout from '@/Layouts/Layout.vue';
import { back } from '@/functions';

import Multiselect from '@vueform/multiselect';
import "@vueform/multiselect/themes/default.css";

import Dropzone from 'dropzone';

import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';


let props = defineProps({
    title: String,
    paramArr: Object,
});

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

const form = useForm({

    year: null,
    amount: null,
    genre_id: null,
    type_genre_id: null,

    image: [],

    name: null,
    writer_id: null,
    description: null,
    description_more: null,

    tags: [],

    category_id: null,
});

let dropzone = null;


function store() {
    delete form.genre_id;


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

    //form.post('books.store');

    router.post(route('books.store'), { form });
};

function setTypeGenreOption() {
    let opt = '';

    params.type.map(elem => {
        if (form.genre_id == elem.genre_id) {
            opt += '<option key="type_genre_' + elem.id + '" value="' + elem.id + '">';
            opt += elem.genre_id + ':' + elem.name;
            opt += '</option>';
        }
    });
    form.type_genre_id
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
    <Head :title="props.title" />

    <form @submit.prevent="store" enctype="multipart/form-data">
        <Layout>
            <aside id="side-menu" class="p-2 bg-orange-200 border-r-3 border-orange-600">

                <div class="text-xl pl-5" style="font-weight: 600;">

                    <div class="flex justify-betweentext-blue-600 text-xl py-2 border-b-2 border-green-800 text-center">
                        <div @click="back" class="w-1/2 text-indigo-600 hover:text-indigo-900 hover:cursor-pointer pr-2">
                            &#8678; Back...
                        </div>
                        <div class="px-3 w-1/2">
                            <button :disabled="form.processing" type="submit"
                                class="px-2 text-white bg-blue-600 hover:bg-blue-600   text-center border-3 border-black rounded-md">
                                Create book
                            </button>
                        </div>
                    </div>
                    <div class="border-3 border-red-700 rounded-2xl mt-5 pl-5 bg-gray-100">
                        <div class="text-blue-700 my-4 ">
                            Year:
                            <input id="id_year" :class="{ 'border-red-500': form.errors.year }" v-model="form.year"
                                type="number"
                                class="w-1/3 bg-gray-300 rounded-2xl py-2 mb-5 text-xl text-center border-2 border-black">

                            <div class="text-red-900 mt-2" v-if="form.errors.year">{{ form.errors.year }}</div>
                        </div>

                        <div class="text-black my-4 ">
                            Amount:
                            <input id="id_amount" :class="{ 'border-red-500': form.errors.amount }" v-model="form.amount"
                                type="number"
                                class="w-1/2 bg-gray-300 rounded-2xl py-2 mb-5 text-xl text-center border-2 border-black">

                            <div class="text-red-900 mt-2" v-if="form.errors.amount">{{ form.errors.amount }}</div>
                        </div>

                        <div class="my-4 text-green-700" style="font-weight: 600;">
                            <label for="id_genre">Genre: </label>

                            <select @change="setTypeGenreOption" id="id_genre" v-model="form.genre_id"
                                class="rounded-xl ml-3 bg-gray-300 text-xl  border-2 border-black">
                                <option v-for="genre in params.genre" :key="'genre_' + genre.id" :value="genre.id">
                                    {{ genre.id }}:{{ genre.name }}</option>
                            </select>
                        </div>

                        <div class="my-4 text-yellow-700" style="font-weight: 600;">
                            <label for="id_type_genre">Type: </label>

                            <select id="id_type_genre" v-model="form.type_genre_id"
                                class="rounded-xl w-9/12 mt-1 bg-gray-300 text-xl  border-2 border-black">

                            </select>
                            <div class="text-red-900 mt-2" v-if="form.errors.type_genre_id">{{ form.errors.type_genre_id }}
                            </div>
                        </div>



                        <div v-if="form.isDirty" class="bg-red-800 text-white p-5 mr-3 mb-3 text-sm rounded-md  ">
                            Something has changed, don't forget to save the form
                        </div>
                    </div>

                </div>

            </aside>

            <section class="w-full  xl:w-3/4 px-5 bg-yellow-100 bg-gradient-to-t from-green-300 to-orange-300">
                <div class="text-xl flex justify-between">
                    <div class="w-1/5 ">

                        <div id="dropzoneId"
                            class="w-36 overflow-hidden px-5 p-2 pt-4 mt-2 mx-auto rounded-2xl bg-slate-700 text-white text-center text-xs cursor-pointer"
                            style="height: 400px;">
                            Select image
                        </div>


                        <div class="text-red-900 mt-2" v-if="form.errors.image">{{ form.errors.image }}</div>
                    </div>

                    <div class="w-4/5 my-2 p-2">
                        <div>
                            <label for="id_name" class="block text-sm font-semibold text-gray-700">The title of the
                                book</label>

                            <input id="id_name" :class="{ 'border-red-500': form.errors.name }" v-model="form.name"
                                type="text"
                                class="w-full font-bold bg-gray-300 rounded-2xl py-2 mb-5 text-xl border-2 border-black">

                            <div class="text-red-900 mt-2" v-if="form.errors.name">{{ form.errors.name }}</div>
                        </div>


                        <div class="flex justify-between m-2 py-5 border-y-2 border-green-800 text-orange-800"
                            style="font-weight: 600;">

                            <div>
                                <label for="id_writer">Writer:</label>

                                <select id="id_writer" v-model="form.writer_id"
                                    class="rounded-xl ml-3 bg-gray-300 text-xl border-2 border-black">
                                    <option v-for="writer in params.writers" :key="'writer_' + writer.id"
                                        :value="writer.id">{{
                                            writer.name }}</option>
                                </select>
                                <div class="text-red-900 mt-2" v-if="form.errors.writer_id">{{ form.errors.writer_id }}
                                </div>
                            </div>

                            <div>
                                <label for="id_category">Category:</label>

                                <select id="id_category" v-model="form.category_id"
                                    class="rounded-2xl ml-3 text-white bg-green-600 text-xl border-3 border-black">
                                    <option v-for="category in params.category" :key="'category_' + category.id"
                                        :value="category.id">{{
                                            category.name }}</option>
                                </select>
                                <div class="text-red-900 mt-2" v-if="form.errors.category_id">{{ form.errors.category_id }}
                                </div>
                            </div>




                        </div>

                        <div>
                            <label for="id_description" class="p-2 " style="font-weight: 600;">
                                Description
                            </label>

                            <textarea id="id_description" rows="3" v-model="form.description"
                                class="block w-full bg-gray-300 text-xl border-2 border-black rounded-xl">
                            </textarea>

                            <p class="mb-3 text-sm leading-6 text-gray-600">Write a few sentences - short description.</p>
                            <div class="text-red-900 mt-2" v-if="form.errors.description">{{ form.errors.description }}
                            </div>
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
                            <div class="text-red-900 mt-2" v-if="form.errors.description_more">{{
                                form.errors.description_more }}</div>
                        </div>

                        <div class="m-2 py-5 border-t-2 border-green-800">
                            Tags:
                            <Multiselect @change="setTagInForm" v-model="valueTag" :options="optionsTagArr" mode="tags"
                                placeholder="Select tags" class="text-2xl p-1"
                                style="border:2px solid black; border-radius: 20px; width: 600px; display: inline-block; margin: 0 0 0 10px;" />
                            <div class="text-red-900 mt-2" v-if="form.errors.description_more">{{
                                form.errors.description_more }}</div>
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
}</style>

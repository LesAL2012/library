<script setup>
import { ref, onMounted } from 'vue';
import { getCookie, setCookie, timeCookieLife, reloadPage } from '@/functions';
import ButtonSortGlobal from './ButtonSortGlobal.vue';

import SetBooksOnPageSmall from './SetBooksOnPageSmall.vue';



import MultiRangeSlider from "multi-range-slider-vue";
import "multi-range-slider-vue/MultiRangeSliderBlack.css";

import { Vue3MultiselectCheckboxed } from "vue3-multiselect-checkboxed";
import "vue3-multiselect-checkboxed/style.css";


import Multiselect from '@vueform/multiselect';
import "@vueform/multiselect/themes/default.css";



let props = defineProps({
    years: Array,
    writers: Object,
    category: Object,
    tag: Object,
    genre: Object,
    type: Object,
});


let likesNotNull = getCookie('likesAreNotNull') && getCookie('likesAreNotNull') == 1 ? true : false;
let sortLikes = getCookie('sortBy') && getCookie('sortBy') == 'liked_users_count' ? true : false;
let sortYears = getCookie('sortBy') && getCookie('sortBy') == 'year' ? true : false;
let sortTitle = getCookie('sortBy') && getCookie('sortBy') == 'name' ? true : false;
let sortWriter = getCookie('sortBy') && getCookie('sortBy') == 'writer' ? true : false;
let sortCategory = getCookie('sortBy') && getCookie('sortBy') == 'category' ? true : false;
let sortType = getCookie('sortBy') && getCookie('sortBy') == 'type' ? true : false;
let sortGenre = getCookie('sortBy') && getCookie('sortBy') == 'genre' ? true : false;

let yearMinimum = getCookie('yearMini') && getCookie('yearMini') != 'NaN' ? +getCookie('yearMini') : props.years[0];
let yearMaximum = getCookie('yearMaxi') && getCookie('yearMaxi') != 'NaN' ? +getCookie('yearMaxi') : props.years[1];

let titleSearching = getCookie('titleSearch') && getCookie('titleSearch') != '' ? getCookie('titleSearch') : '';

let writerSearching = getCookie('writerSearch') && getCookie('writerSearch') != '' ? getCookie('writerSearch').split(',') : [];
let categorySearching = getCookie('categorySearch') && getCookie('categorySearch') != '' ? getCookie('categorySearch').split(',') : [];
let tagSearching = getCookie('tagSearch') && getCookie('tagSearch') != '' ? getCookie('tagSearch').split(',') : [];
let genreSearching = getCookie('genreSearch') && getCookie('genreSearch') != '' ? getCookie('genreSearch') : 'id-genre-all';
let typeSearching = getCookie('typeSearch') && getCookie('typeSearch') != '' ? getCookie('typeSearch').split(',') : [];

let sDir = getCookie('sortDir') && getCookie('sortDir') == 1 ? true : false;

const checked = ref(likesNotNull);
const sortL = ref(sortLikes);
const sortY = ref(sortYears);
const sortT = ref(sortTitle);
const sortW = ref(sortWriter);
const sortC = ref(sortCategory);
const sortTy = ref(sortType);
const sortG = ref(sortGenre);

const yearMinMax = ref([yearMinimum, yearMaximum]);

const titleSearch = ref(titleSearching);

const resultWriter = ref(writerSearching);

let optionsCategory = props.category;
let optionsCategoryArr = [];
Object.keys(optionsCategory).map(cat => {
    optionsCategoryArr.push(optionsCategory[cat].name);
});
let categorySearching_name = []
if (categorySearching.length > 0) {
    categorySearching.map(id => {
        Object.keys(optionsCategory).map(cat => {
            if (optionsCategory[cat].id == id) {
                categorySearching_name.push(optionsCategory[cat].name);
            };
        });
    });
} else {
    categorySearching_name = categorySearching;
}
let valueCategory = ref(categorySearching_name);

let optionsTag = props.tag;
let optionsTagArr = [];
Object.keys(optionsTag).map(tag => {
    optionsTagArr.push(optionsTag[tag].name);
});
let tagSearching_name = []
if (tagSearching.length > 0) {
    tagSearching.map(id => {
        Object.keys(optionsTag).map(tag => {
            if (optionsTag[tag].id == id) {
                tagSearching_name.push(optionsTag[tag].name);
            };
        });
    });
} else {
    tagSearching_name = tagSearching;
}
let valueTag = ref(tagSearching_name);
let valueGenre = ref(genreSearching);
let valueType = ref(typeSearching);


const sortD = ref(sDir);

let options = {
    path: '/',
    'Max-Age': timeCookieLife
};

function likesAreNotNullCheck() {
    if (checked.value) {
        setCookie('likesAreNotNull', 1, options);
    } else {
        setCookie('likesAreNotNull', 0, { path: '/', 'Max-Age': -1 });
    }
    reloadPage();
};

function sortByLikes() {
    if (!sortD.value) {
        setCookie('sortDir', 1, options);
    } else {
        setCookie('sortDir', 0, { path: '/', 'Max-Age': -1 });
    }

    if (!sortL.value) {
        setCookie('sortBy', 'liked_users_count', options);
    }
    reloadPage();
};
function sortByYears() {
    if (!sortD.value) {
        setCookie('sortDir', 1, options);
    } else {
        setCookie('sortDir', 0, { path: '/', 'Max-Age': -1 });
    }

    if (!sortY.value) {
        setCookie('sortBy', 'year', options);
    }
    reloadPage();
};
function sortByTitle() {
    if (!sortD.value) {
        setCookie('sortDir', 1, options);
    } else {
        setCookie('sortDir', 0, { path: '/', 'Max-Age': -1 });
    }

    if (!sortT.value) {
        setCookie('sortBy', 'name', options);
    }
    reloadPage();
};
function sortByWriter() {
    if (!sortD.value) {
        setCookie('sortDir', 1, options);
    } else {
        setCookie('sortDir', 0, { path: '/', 'Max-Age': -1 });
    }

    if (!sortW.value) {
        setCookie('sortBy', 'writer', options);
    }
    reloadPage();
};
function sortByCategory() {
    if (!sortD.value) {
        setCookie('sortDir', 1, options);
    } else {
        setCookie('sortDir', 0, { path: '/', 'Max-Age': -1 });
    }

    if (!sortC.value) {
        setCookie('sortBy', 'category', options);
    }
    reloadPage();
};
function sortByType() {
    if (!sortD.value) {
        setCookie('sortDir', 1, options);
    } else {
        setCookie('sortDir', 0, { path: '/', 'Max-Age': -1 });
    }

    if (!sortTy.value) {
        setCookie('sortBy', 'type', options);
    }
    reloadPage();
};
function sortByGenre() {
    if (!sortD.value) {
        setCookie('sortDir', 1, options);
    } else {
        setCookie('sortDir', 0, { path: '/', 'Max-Age': -1 });
    }

    if (!sortG.value) {
        setCookie('sortBy', 'genre', options);
    }
    reloadPage();
};

function removeAllFilters() {
    setCookie('likesAreNotNull', 0, { path: '/', 'Max-Age': -1 });
    setCookie('sortDir', 0, { path: '/', 'Max-Age': -1 });
    setCookie('sortBy', 'liked_users_count', { path: '/', 'Max-Age': -1 });
    setCookie('yearMini', '', { path: '/', 'Max-Age': -1 });
    setCookie('yearMaxi', '', { path: '/', 'Max-Age': -1 });
    setCookie('titleSearch', '', { path: '/', 'Max-Age': -1 });
    setCookie('writerSearch', '', { path: '/', 'Max-Age': -1 });
    setCookie('categorySearch', '', { path: '/', 'Max-Age': -1 });
    setCookie('tagSearch', '', { path: '/', 'Max-Age': -1 });
    setCookie('genreSearch', '', { path: '/', 'Max-Age': -1 });
    setCookie('typeSearch', '', { path: '/', 'Max-Age': -1 });

    reloadPage();
};


function setYearsParameters(e) {

    setCookie('yearMini', e.minValue, options);
    setCookie('yearMaxi', e.maxValue, options);


    //console.log(yearMinimum, yearMaximum);
    //console.log(getQuryString());

    reloadPage();
}

function setTitleParameter(e) {

    let data = e.target.value;

    if (data.length > 2) {
        setCookie('titleSearch', data, options);
        reloadPage();
    }

    if (data == '' || data.length == 0) {
        setCookie('titleSearch', '', { path: '/', 'Max-Age': -1 });
        reloadPage();
    }
}

const writersOptions = [];
props.writers.map(elem => { writersOptions.push(elem) });

const setResultWriter = (val) => {
    resultWriter.value = [...val];

    let writer_id = [];
    Object.keys(val).map(key => writer_id.push(val[key]));

    if (writer_id.length > 0) {
        setCookie('writerSearch', writer_id, options);
    } else {
        setCookie('writerSearch', '', { path: '/', 'Max-Age': -1 });
    }
}

function setCategoryParameter(value) {
    let cat_id = [];
    value.map(item => {
        Object.keys(optionsCategory).map(cat => {
            if (optionsCategory[cat].name == item) {
                cat_id.push(optionsCategory[cat].id);
            };
        });
    });

    if (cat_id.length > 0) {
        setCookie('categorySearch', cat_id, options);
    } else {
        setCookie('categorySearch', '', { path: '/', 'Max-Age': -1 });
    }
    reloadPage();
}

function setTagParameter(value) {
    let tag_id = [];
    value.map(item => {
        Object.keys(optionsTag).map(tag => {
            if (optionsTag[tag].name == item) {
                tag_id.push(optionsTag[tag].id);
            };
        });
    });

    if (tag_id.length > 0) {
        setCookie('tagSearch', tag_id, options);
    } else {
        setCookie('tagSearch', '', { path: '/', 'Max-Age': -1 });
    }
    reloadPage();
}

function setGenreParameter(e) {

    if (e.target.value != 'id-genre-all') {
        setCookie('genreSearch', e.target.value, options);
    } else {
        setCookie('genreSearch', '', { path: '/', 'Max-Age': -1 });
    }

    reloadPage();
}
function setTypeParameter(e) {

    let type_id = [];

    document.querySelectorAll('.check-type-list').forEach(elem => {
        if (elem.checked) {
            type_id.push(elem.value.split('-')[2]);
        }
    });

    if (type_id.length > 0) {
        setCookie('typeSearch', type_id, options);
    } else {
        setCookie('typeSearch', '', { path: '/', 'Max-Age': -1 });
    }

    reloadPage();
}
function removeAllTypeParameter(e) {

    setCookie('typeSearch', '', { path: '/', 'Max-Age': -1 });

    reloadPage();
}


//document.querySelector('select.wayfmf6wh3').style.minWidth = '200px';
onMounted(() => {
     document.getElementsByClassName('wayfmf6wh3')[0].style.minWidth = '220px';

     document.getElementsByClassName('min-caption')[0].style.background = 'darkgreen';
     document.getElementsByClassName('max-caption')[0].style.background = 'darkgreen';
     document.getElementsByClassName('multi-range-slider-black')[0].style.background = 'green';
     document.getElementsByClassName('multi-range-slider-black')[0].style.border = '2px solid darkgreen';

    //console.log();
});


</script>




<template>
    <div class="border-3 border-green-600 bg-green-200 p-1 rounded-2xl w-full my-2">
        <div class="text-bold px-1 flex items-center justify-between border-b-3 border-green-600">

            <div class="text-red-700 border-r-3 border-green-600 pr-3">
                <b>Global</b>
            </div>
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 inline ">
                    <path fill-rule="evenodd"
                        d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z"
                        clip-rule="evenodd" />
                </svg>
                Filters<br>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 inline ">
                    <path fill-rule="evenodd"
                        d="M2.24 6.8a.75.75 0 001.06-.04l1.95-2.1v8.59a.75.75 0 001.5 0V4.66l1.95 2.1a.75.75 0 101.1-1.02l-3.25-3.5a.75.75 0 00-1.1 0L2.2 5.74a.75.75 0 00.04 1.06zm8 6.4a.75.75 0 00-.04 1.06l3.25 3.5a.75.75 0 001.1 0l3.25-3.5a.75.75 0 10-1.1-1.02l-1.95 2.1V6.75a.75.75 0 00-1.5 0v8.59l-1.95-2.1a.75.75 0 00-1.06-.04z"
                        clip-rule="evenodd" />
                </svg>
                Sorts
            </div>
            <div class="border-r-3 border-green-600 pr-3">
                &
            </div>


            <SetBooksOnPageSmall />

        </div>

        <div class="text-bold px-1 flex items-center justify-between border-b-1 border-green-600">
            <label for="likesAreNotNull">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" class="w-6 h-6 inline mx-1">
                    <path
                        d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                </svg> are not <span class="text-bold text-red-500">0</span>
            </label>
            <input class="mx-1" checked="{ checked }" type="checkbox" id="likesAreNotNull" @change="likesAreNotNullCheck"
                v-model="checked" />
            |
            <ButtonSortGlobal class=" w-1/5" @click="sortByLikes" :sort="sortL" :direction="sortD" nameBtn="Likes" />

        </div>

        <div class="text-bold px-1 flex items-center justify-between border-b-1 border-green-600">
            <MultiRangeSlider baseClassName="multi-range-slider-black" :min="props.years[0]" :max="props.years[1]" :step="5"
                :ruler="true" :label="true" :minValue="yearMinMax[0]" :maxValue="yearMinMax[1]" @input="setYearsParameters"
                class="rounded-md w-5/6 mb-1 mt-6 bg-green-400" v-model="yearMinMax" />

            <ButtonSortGlobal @click="sortByYears" :sort="sortY" :direction="sortD" nameBtn="Year" class="w-1/6" />
        </div>

        <div class="text-bold px-1 flex items-center justify-between border-b-1 border-green-600">

            <input class="my-1 w-5/6 rounded-xl" placeholder="At least three characters: press Enter" v-model="titleSearch"
                @change="setTitleParameter" />

            <ButtonSortGlobal class="my-1 w-1/6" @click="sortByTitle" :sort="sortT" :direction="sortD" nameBtn="Title" />
        </div>
        <div class="text-bold mt-1 px-1 flex items-center justify-between border-b-1 border-green-600">


            <Vue3MultiselectCheckboxed class="rounded-md" :options="writersOptions" bindLabel="name" bindValue="id"
                :preSelected="resultWriter" :hasSearch="true" @onVSelect="setResultWriter" />

            <button
                class="text-bold  py-1 px-3 m-1 border-2 border-black bg-blue-300 hover:bg-blue-400 hover:text-white  rounded-lg"
                @click="reloadPage">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </button>

            <ButtonSortGlobal class="my-1 w-1/6" @click="sortByWriter" :sort="sortW" :direction="sortD" nameBtn="Writer" />
        </div>

        <div class="text-bold px-1 flex items-center justify-between border-b-1 border-green-600">
            <div class="my-1 w-4/6">
                <Multiselect v-model="valueCategory" mode="tags" placeholder="Select categories"
                    :options="optionsCategoryArr" :search="false" @change="setCategoryParameter"
                    style="background:rgb(186, 248, 186); border:2px solid green; border-radius: 10px;" />
            </div>


            <ButtonSortGlobal class="my-1 w-2/6" @click="sortByCategory" :sort="sortC" :direction="sortD"
                nameBtn="Category" />
        </div>

        <div class="text-bold px-1 flex items-center justify-between border-dashed border-b-1 border-green-600">
            <ul class="grid w-full gap-1 md:grid-cols-3 ">
                <li>
                    <input v-if="valueGenre == 'id-genre-all'" v-model="valueGenre" checked type="radio" id="id-genre-all"
                        name="genre" value="id-genre-all" class="hidden peer" @click="setGenreParameter">
                    <input v-else v-model="valueGenre" type="radio" id="id-genre-all" name="genre" value="id-genre-all"
                        class="hidden peer" @click="setGenreParameter">
                    <label for="id-genre-all"
                        class="inline-flex items-center justify-between w-full p-2 my-1 text-gray-500 bg-white border-3 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-green-700 dark:peer-checked:text-green-700 peer-checked:border-green-700 peer-checked:text-green-700 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">

                        <div class="text-sm font-semibold mx-auto">All Genres</div>

                    </label>
                </li>
                <li v-for="g in props.genre">
                    <input v-if="valueGenre == 'id-genre-' + g.id" v-model="valueGenre" checked type="radio"
                        :id="'id-genre-' + g.id" name="genre" :value="'id-genre-' + g.id" class="hidden peer"
                        @click="setGenreParameter">
                    <input v-else v-model="valueGenre" type="radio" :id="'id-genre-' + g.id" name="genre"
                        :value="'id-genre-' + g.id" class="hidden peer" @click="setGenreParameter">
                    <label :for="'id-genre-' + g.id"
                        class="inline-flex items-center justify-between w-full p-2 my-1 text-gray-500 bg-white border-3 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-green-700 dark:peer-checked:text-green-700 peer-checked:border-green-700 peer-checked:text-green-700 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">

                        <div class="text-sm font-semibold mx-auto">{{ g.name }}</div>

                    </label>
                </li>
            </ul>

            <ButtonSortGlobal class=" w-1/5" @click="sortByGenre" :sort="sortG" :direction="sortD" nameBtn="Genre" />
        </div>

        <div class="text-bold px-1 flex items-center justify-between border-b-1 border-green-600">
            <div class="w-full">
                <div v-for="t in props.type" class="inline-block w-1/2">
                    <div :v-model="valueGenre"
                        v-if="t.genre_id == valueGenre.split('-')[2] || valueGenre == 'id-genre-all'">
                        <div :v-model="valueType" v-if="Object.values(valueType).includes(t.id.toString())">
                            <input @change="setTypeParameter" :id="'id-type-' + t.id" checked type="checkbox"
                                :value="'id-type-' + t.id"
                                class="check-type-list w-4 h-4 text-green-600 bg-gray-100 border-gray-400 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="green-checkbox" class="ml-2 text-sm font-bold text-green-900 dark:text-gray-300">{{
                                t.name }}</label>
                        </div>
                        <div :v-model="valueType" v-else>
                            <input @change="setTypeParameter" :id="'id-type-' + t.id" type="checkbox"
                                :value="'id-type-' + t.id"
                                class="check-type-list w-4 h-4 text-green-600 bg-gray-100 border-2 border-green-600 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="green-checkbox" class="ml-2 text-sm font-bold text-green-900 dark:text-gray-300">{{
                                t.name }}</label>
                        </div>
                    </div>
                    <div :v-model="valueGenre" v-else>
                        <div :v-model="valueType" v-if="Object.values(valueType).includes(t.id.toString())">
                            <input disabled @change="setTypeParameter" :id="'id-type-' + t.id" checked type="checkbox"
                                :value="'id-type-' + t.id"
                                class="check-type-list w-4 h-4 text-red-300 bg-gray-100 border-gray-400 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="green-checkbox" class="ml-2 text-sm font-bold text-gray-500 dark:text-gray-300">{{
                                t.name }}</label>
                        </div>
                        <div :v-model="valueType" v-else>
                            <input disabled @change="setTypeParameter" :id="'id-type-' + t.id" type="checkbox"
                                :value="'id-type-' + t.id"
                                class="check-type-list w-4 h-4 text-red-300 bg-gray-300 border-gray-400 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="green-checkbox" class="ml-2 text-sm font-bold text-gray-400 dark:text-gray-300">{{
                                t.name }}</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-1/5 text-center">

                <ButtonSortGlobal class="my-5" @click="sortByType" :sort="sortTy" :direction="sortD" nameBtn="Type" />

                <button
                    class="hidden text-bold my-5 py-1 px-3  border-2 border-black bg-blue-300 hover:bg-blue-400 hover:text-white  rounded-lg"
                    @click="reloadPage">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </button>

                <button
                    class="text-bold my-5 py-1 px-3 border-2 border-red-700 bg-red-300 hover:bg-red-600 hover:text-white  rounded-lg"
                    @click="removeAllTypeParameter">
                    All
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>


                </button>


            </div>
        </div>

        <div class="text-bold p-1 flex items-center justify-center border-b-1 border-green-600">

            <Multiselect v-model="valueTag" mode="tags" placeholder="Select tags" :options="optionsTagArr" :search="false"
                @change="setTagParameter"
                style="background:rgb(186, 248, 186); border:2px solid green; border-radius: 10px;" />
        </div>

        <div class="text-bold px-1 flex items-center justify-center mt-1">
            <button @click="removeAllFilters"
                class="m-1 p-2 border-2 border-black bg-green-400 hover:bg-green-500  rounded-lg">
                <b>DEFAULT: <span class="text-red-600">reset</span></b> all Filters & all Sorts
            </button>
        </div>
    </div>
</template>


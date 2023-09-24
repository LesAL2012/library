<script setup>
import { Head } from '@inertiajs/vue3';
import SettingsLayout from '@/Layouts/SettingsLayout.vue';
import { reFormat } from '@/functions';

import { DoughnutChart, BarChart, PolarAreaChart, RadarChart, PieChart } from 'vue-chart-3';

import { Chart, registerables } from "chart.js";

Chart.register(...registerables);

let props = defineProps({
    title: String,
    take: Number,
    data: Object,
});
let take = props.take;
let writers = props.data.writers;
let categories = props.data.categories;
let genres = props.data.genres;
let typeGenres = props.data.typeGenres;
let tags = props.data.tags;
let likes = props.data.likes;

console.log();

function setChartData(dataObj) {
    let labels = [];
    let data = [];

    for (let index = 0; index < take; index++) {

        if (dataObj[index] != undefined) {
            labels.push(dataObj[index].name);
            data.push(dataObj[index].books_count);
        }
    }

    return {
        labels: labels,
        datasets: [
            {
                data: data,
                backgroundColor: ['#77CEFF', '#0079AF', '#123E6B', '#97B0C4', '#A5C8ED'],
            },
        ],
    }
};

function toggleTableChart(event){
    let card = event.target.closest('div.card');
    //
    let btn = card.querySelector('button');
    if(btn.innerHTML  == 'Switch to chart'){
        btn.innerHTML = 'Switch to table';
        btn.classList.add('bg-indigo-600');
        btn.classList.add('hover:bg-indigo-700');
        btn.classList.remove('bg-green-600');
        btn.classList.remove('hover:bg-green-700');
    }else{
        btn.innerHTML = 'Switch to chart';
        btn.classList.add('bg-green-600');
        btn.classList.add('hover:bg-green-700');
        btn.classList.remove('bg-indigo-600');
        btn.classList.remove('hover:bg-indigo-700');
    };

    card.querySelectorAll('.toggle-table-chart').forEach(element => {
        element.classList.toggle('hidden');
    });
}

</script>


<template>
    <Head :title="props.title" />
    <SettingsLayout>

        <h1 class="text-4xl py-2 text-center font-bold">Details - {{ take }} most popular</h1>

        <div class=" flex flex-wrap">
            <div class="m-3 card bg-yellow-200">
                <div class="flex justify-between">
                    <button @click="toggleTableChart($event)" class="font-bold border-2 border-black px-3 rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Switch to table</button>
                    <h1 class="border-b-2 border-green-800 p-1 text-end text-xl font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-5 h-5 inline">
                            <path
                                d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                            <path
                                d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                        </svg>
                        Writers - {{ writers.writersCount }}
                    </h1>
                </div>

                <table class="table-auto toggle-table-chart hidden">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Writer</th>
                            <th>Books</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="writer in writers.writersData">
                            <td>{{ writer.id }}</td>
                            <td>{{ writer.name }}</td>
                            <td v-html="reFormat(writer.books_count)"></td>
                        </tr>
                        <tr v-if="writers.writersCount > take">
                            <td></td>
                            <td> - - -</td>
                            <td>...</td>
                        </tr>

                    </tbody>
                </table>

                <BarChart :legend="false" :chartData="setChartData(writers.writersData)" class="charts toggle-table-chart"
                    :options="{ plugins: { legend: { display: false } } }" />

            </div>
            <div class="m-3 card bg-blue-200">
                <div class="flex justify-between">
                    <button @click="toggleTableChart($event)" class="font-bold border-2 border-black px-3 rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Switch to table</button>
                <h1 class="border-b-2 border-green-800 p-1 text-end text-xl font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 inline">
                        <path
                            d="M7 3.5A1.5 1.5 0 018.5 2h3.879a1.5 1.5 0 011.06.44l3.122 3.12A1.5 1.5 0 0117 6.622V12.5a1.5 1.5 0 01-1.5 1.5h-1v-3.379a3 3 0 00-.879-2.121L10.5 5.379A3 3 0 008.379 4.5H7v-1z" />
                        <path
                            d="M4.5 6A1.5 1.5 0 003 7.5v9A1.5 1.5 0 004.5 18h7a1.5 1.5 0 001.5-1.5v-5.879a1.5 1.5 0 00-.44-1.06L9.44 6.439A1.5 1.5 0 008.378 6H4.5z" />
                    </svg>
                    Categories - {{ categories.categoriesCount }}
                </h1>
            </div>

                <table class="table-auto toggle-table-chart hidden">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category</th>
                            <th>Books</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="category in categories.categoriesData">
                            <td>{{ category.id }}</td>
                            <td>{{ category.name }}</td>
                            <td v-html="reFormat(category.books_count)"></td>
                        </tr>
                        <tr v-if="categories.categoriesCount > take">
                            <td></td>
                            <td> - - -</td>
                            <td>...</td>
                        </tr>

                    </tbody>
                </table>

                <DoughnutChart :chartData="setChartData(categories.categoriesData)" class="charts toggle-table-chart" />


            </div>
            <div class="m-3 card bg-green-200">
                <div class="flex justify-between">
                    <button @click="toggleTableChart($event)" class="font-bold border-2 border-black px-3 rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Switch to table</button>
                <h1 class="border-b-2 border-green-800 p-1 text-end text-xl font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 inline">
                        <path
                            d="M11.983 1.907a.75.75 0 00-1.292-.657l-8.5 9.5A.75.75 0 002.75 12h6.572l-1.305 6.093a.75.75 0 001.292.657l8.5-9.5A.75.75 0 0017.25 8h-6.572l1.305-6.093z" />
                    </svg>
                    Genres - {{ genres.genresCount }}
                </h1>
            </div>
                <table class="table-auto hidden toggle-table-chart">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Genre</th>
                            <th>Books</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="genre in genres.genresData">
                            <td>{{ genre.id }}</td>
                            <td>{{ genre.name }}</td>
                            <td v-html="reFormat(genre.books_count)"></td>
                        </tr>
                        <tr v-if="genres.genresCount > take">
                            <td></td>
                            <td> - - -</td>
                            <td>...</td>
                        </tr>

                    </tbody>
                </table>

                <PieChart :chartData="setChartData(genres.genresData)" class="charts toggle-table-chart " />
            </div>
            <div class="m-3 card bg-red-200">
                <div class="flex justify-between">
                    <button @click="toggleTableChart($event)" class="font-bold border-2 border-black px-3 rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Switch to table</button>
                <h1 class="border-b-2 border-green-800 p-1 text-end text-xl font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 inline">
                        <path fill-rule="evenodd"
                            d="M2.5 3A1.5 1.5 0 001 4.5v4A1.5 1.5 0 002.5 10h6A1.5 1.5 0 0010 8.5v-4A1.5 1.5 0 008.5 3h-6zm11 2A1.5 1.5 0 0012 6.5v7a1.5 1.5 0 001.5 1.5h4a1.5 1.5 0 001.5-1.5v-7A1.5 1.5 0 0017.5 5h-4zm-10 7A1.5 1.5 0 002 13.5v2A1.5 1.5 0 003.5 17h6a1.5 1.5 0 001.5-1.5v-2A1.5 1.5 0 009.5 12h-6z"
                            clip-rule="evenodd" />
                    </svg>
                    Type of genres - {{ typeGenres.typeGenresCount }}
                </h1>
            </div>
                <table class="table-auto hidden toggle-table-chart">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type of genre</th>
                            <th>Books</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="typeGenre in typeGenres.typeGenresData">
                            <td>{{ typeGenre.id }}</td>
                            <td>{{ typeGenre.name }}</td>
                            <td v-html="reFormat(typeGenre.books_count)"></td>
                        </tr>
                        <tr v-if="typeGenres.typeGenresCount > take">
                            <td></td>
                            <td> - - -</td>
                            <td>...</td>
                        </tr>

                    </tbody>
                </table>

                <PolarAreaChart :legend="false" :chartData="setChartData(typeGenres.typeGenresData)" class="charts toggle-table-chart"
                    :options="{ plugins: { legend: { display: false } } }" />
            </div>
            <div class="m-3 card bg-orange-200">
                <div class="flex justify-between">
                    <button @click="toggleTableChart($event)" class="font-bold border-2 border-black px-3 rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Switch to table</button>
                <h1 class="border-b-2 border-green-800 p-1 text-end text-xl font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 inline">
                        <path fill-rule="evenodd"
                            d="M2.5 3A1.5 1.5 0 001 4.5v4A1.5 1.5 0 002.5 10h6A1.5 1.5 0 0010 8.5v-4A1.5 1.5 0 008.5 3h-6zm11 2A1.5 1.5 0 0012 6.5v7a1.5 1.5 0 001.5 1.5h4a1.5 1.5 0 001.5-1.5v-7A1.5 1.5 0 0017.5 5h-4zm-10 7A1.5 1.5 0 002 13.5v2A1.5 1.5 0 003.5 17h6a1.5 1.5 0 001.5-1.5v-2A1.5 1.5 0 009.5 12h-6z"
                            clip-rule="evenodd" />
                    </svg>
                    Tags - {{ tags.tagsCount }}
                </h1>
            </div>
                <table class="table-auto toggle-table-chart hidden">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tags</th>
                            <th>Books</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="tag in tags.tagsData">
                            <td>{{ tag.id }}</td>
                            <td>{{ tag.name }}</td>
                            <td v-html="reFormat(tag.books_count)"></td>
                        </tr>
                        <tr v-if="tags.tagsCount > take">
                            <td></td>
                            <td> - - -</td>
                            <td>...</td>
                        </tr>

                    </tbody>
                </table>

                <RadarChart :chartData="setChartData(tags.tagsData)" :options="{ plugins: { legend: { display: false } } }"
                    class="charts toggle-table-chart" />

            </div>
            <div class="m-3 card bg-purple-200">
                <div class="flex justify-between">
                    <h1 class="border-b-2 border-green-800 p-1 text-end text-xl font-bold"
                        v-html="'&#128366; '+   reFormat(likes.booksCount)"></h1>

                    <h1 class="border-b-2 border-green-800 p-1 text-end text-xl font-bold"
                        v-html="'&#9829; ' +   reFormat(likes.likesCount)"></h1>
                </div>

                <table class="table-auto">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Book</th>
                            <th>Likes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="like in likes.likesData">
                            <td>{{ like.id }}</td>
                            <td>{{ like.name }}</td>
                            <td v-html="reFormat(like.liked_users_count)"></td>
                        </tr>
                        <tr v-if="likes.likesCount > take">
                            <td></td>
                            <td> - - -</td>
                            <td>...</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </SettingsLayout>
</template>

<style scoped>
.card {
    width: 380px;
    padding: 10px;
    border: 2px solid darkgreen;
    border-radius: 20px;
}

table th,
table td {
    padding: 0 10px;
    /* border: 2px solid darkgreen; */

}

table {
    margin: 10px auto;
}

.charts {
    background-color: lemonchiffon;
    margin: 10px auto;
    border: 1px solid black;
    border-radius: 10px;
    padding: 10px;
}
</style>

<script setup>

import { Head } from '@inertiajs/vue3';

import Layout from '@/Layouts/Layout.vue';



let props = defineProps({
    title: String,

});


</script>

<template>
    <Head :title="title" />

    <Layout>
        <div class="w-full  p-5 bg-yellow-100 bg-gradient-to-t from-green-300 to-orange-300">


            <table class="table-auto">
                <thead>
                    <tr>
                        <th>Resource</th>
                        <th>Description</th>
                        <th>Link</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Laravel</td>
                        <td>Basic framework - backend</td>
                        <td>
                            <a href="https://laravel.com/docs/10.x" target=”_blank”>
                                composer create-project laravel/laravel ./
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Inertia </td>
                        <td>Basic framework - frontend</td>
                        <td>
                            <a href="https://jetstream.laravel.com/installation.html" target=”_blank”>
                                composer require laravel/jetstream
                                <br>
                                php artisan jetstream:install inertia
                            </a>

                        </td>
                    </tr>
                    <tr>
                        <td>Tailwind CSS</td>
                        <td>Basic CSS framework</td>
                        <td>
                            <a href="https://tailwindcss.com/docs/installation" target=”_blank”>
                                npm install -D tailwindcss
                                <br>
                                npx tailwindcss init
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Intervention Image</td>
                        <td>Uploading the image to the server</td>
                        <td>
                            <a href="https://image.intervention.io/v2/introduction/installation#installation"
                                target=”_blank”>
                                composer require intervention/image
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>BelongsToThrough</td>
                        <td>HasManyThrough relationship</td>
                        <td>
                            <a href="https://github.com/staudenmeir/belongs-to-through" target=”_blank”>
                                composer require staudenmeir/belongs-to-through:"^2.5"
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>MultiRangeSlider.vue</td>
                        <td>import MultiRangeSlider from "multi-range-slider-vue";</td>
                        <td>
                            <a href="https://www.npmjs.com/package/multi-range-slider-vue?activeTab=readme" target=”_blank”>
                                npm install multi-range-slider-vue
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Multiselect Checkboxed</td>
                        <td>import { Vue3MultiselectCheckboxed } from "vue3-multiselect-checkboxed"</td>
                        <td>
                            <a href="https://vuejsexamples.com/a-simple-multiselect-checkboxed-using-vuejs-3/"
                                target=”_blank”>
                                npm i vue3-multiselect-checkboxed
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Vue 3 Multiselect</td>
                        <td>import Multiselect from '@vueform/multiselect'</td>
                        <td>
                            <a href="https://www.npmjs.com/package/@vueform/multiselect" target=”_blank”>
                                npm install @vueform/multiselect
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>QuillEditor</td>
                        <td>import { QuillEditor } from '@vueup/vue-quill'</td>
                        <td>
                            <a href="https://vueup.github.io/vue-quill/guide/installation.html" target=”_blank”>
                                npm install @vueup/vue-quill@latest --save
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Vue-chart-3</td>
                        <td>import { Chart, registerables } from "chart.js"</td>
                        <td>
                            <a href="https://github.com/victorgarciaesgi/vue-chart-3" target=”_blank”>
                                npm i vue-chart-3 chart.js
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Laratrust</td>
                        <td>Add roles and permissions</td>
                        <td>
                            <a href="https://laratrust.santigarcor.me/docs/8.x/installation.html" target=”_blank”>
                                composer require santigarcor/laratrust
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>L5-Swagger</td>
                        <td>API routes for Writers - sample</td>
                        <td>
                            <a href="https://github.com/DarkaOnLine/L5-Swagger" target=”_blank”>
                                composer require "darkaonline/l5-swagger"
                            </a>
                        </td>
                    </tr>

                </tbody>
            </table>


        </div>
    </Layout>
</template>

<style scoped>
table th,
table td {
    padding: 5px 15px;
    border: 2px solid darkgreen;

}

table {
    margin: 10px auto;
}

table a {
    color: blue;
}

table a:hover {
    text-decoration: underline;
}
</style>

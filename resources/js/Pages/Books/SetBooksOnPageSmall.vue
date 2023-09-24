<script setup>

import { getCookie, setCookie, timeCookieLife, arrPagination } from '@/functions';

let arrPag = arrPagination;

let options = {
    path: '/',
    'Max-Age': timeCookieLife
};

function setSelected(item) {
    if (item == getCookie('paginate')) {
        return item;
    }
};
function setLocalSelected() {
    let item = document.querySelector('#select_op_small').value;
    setCookie('paginate', item, options);

    /* let page = 1;
    if (document.querySelector('.link_is_active')) {
        page = document.querySelector('.link_is_active').innerHTML;
    }
    window.location.href = '/?page=' + page + '&paginate=' + item; */
    window.location.reload();
};

</script>

<template>
    <!-- <div class="border-3 border-green-600 bg-green-200 p-1 rounded-2xl w-full flex justify-between"> -->
    <!-- <div class="text-bold px-1 flex items-center justify-center ">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 inline-block">
                <path
                    d="M10.75 16.82A7.462 7.462 0 0115 15.5c.71 0 1.396.098 2.046.282A.75.75 0 0018 15.06v-11a.75.75 0 00-.546-.721A9.006 9.006 0 0015 3a8.963 8.963 0 00-4.25 1.065V16.82zM9.25 4.065A8.963 8.963 0 005 3c-.85 0-1.673.118-2.454.339A.75.75 0 002 4.06v11a.75.75 0 00.954.721A7.506 7.506 0 015 15.5c1.579 0 3.042.487 4.25 1.32V4.065z" />
            </svg>

        </div>
        <div class="flex items-center justify-center ">
            Books per page:
        </div> -->
    <!-- <div class="flex items-center justify-center  "> -->
    <div class="text-center px-1 w-1/4">

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 inline-block">
            <path
                d="M10.75 16.82A7.462 7.462 0 0115 15.5c.71 0 1.396.098 2.046.282A.75.75 0 0018 15.06v-11a.75.75 0 00-.546-.721A9.006 9.006 0 0015 3a8.963 8.963 0 00-4.25 1.065V16.82zM9.25 4.065A8.963 8.963 0 005 3c-.85 0-1.673.118-2.454.339A.75.75 0 002 4.06v11a.75.75 0 00.954.721A7.506 7.506 0 015 15.5c1.579 0 3.042.487 4.25 1.32V4.065z" />
        </svg>


        Books per page
    </div>
    <select id="select_op_small" @change="setLocalSelected"
        class="rounded-xl border-3 border-green-600 py-1 bg-yellow-100 block">
        <option v-for="(item, key) in arrPag" :key="key + '_select'" :value="item" :label="item"
            :selected="item == setSelected(item)" />
    </select>

    <!-- </div> -->
    <!-- </div> -->
</template>

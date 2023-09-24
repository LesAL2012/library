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
    let item = document.querySelector('#select_op').value;
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
    <div class="border-3 border-green-600 bg-green-200 p-1 rounded-2xl w-full flex justify-between">
        <div class="flex items-center justify-center ">
            Per page:
        </div>
        <div class="flex items-center justify-center  ">
            <select id="select_op" @change="setLocalSelected"
                class="rounded-xl border-3 border-green-600 py-1 bg-yellow-100 ">
                <option v-for="(item, key) in arrPag" :key="key + '_select'" :value="item" :label="item"
                    :selected="item == setSelected(item)" />
            </select>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { getKeyPlus } from '@/functions'

const props = defineProps({
    links: Array,
});

//console.log(props.links);

</script>

<template>
    <div v-if="links.length > 3" class="px-1 py-1 flex items-center justify-between sm:px-6 ">
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div class="mx-auto py-2">
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <!-- active - text-blue-500 font-bold -->
                    <!-- url null - bg-gray-100 -->

                    <Link v-for="(link, k) in links" :href="link.url ? link.url : '#'"
                        :key="k + getKeyPlus() + link.label + Math.random()"
                        :class="{
                            'text-blue-600 font-bold bg-yellow-200 link_is_active': link.active,
                            'pointer-events-none opacity-50 border-gray-500 bg-gray-300': link.url === null,
                        }"
                        v-html="link.label"
                        class="pages_links bg-white
                       rounded-md
                       border-3 border-green-600
                       text-gray-500
                       relative inline-flex items-center
                       px-2 md:px-3 py-1
                       text-xs md:text-sm"
                       />
                </nav>
            </div>
        </div>
    </div>
</template>

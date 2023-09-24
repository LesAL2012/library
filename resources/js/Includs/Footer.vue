<script setup>
import { version } from "vue";
</script>

<template>
    <footer class="flex justify-around text-center text-white bg-green-600 text-xs">
        <div class=" text-center">
            &copy; Les
        </div>
        <div class=" text-center">
            Laravel v - {{ $page.props.laravelVersion }}
        </div>
        <div class=" text-center">
            PHP v - {{ $page.props.phpVersion }}
        </div>
        <div class=" text-center">
            Vue v - {{ version }}
        </div>
        <div class=" text-center">
            Inertia
        </div>
        <div class=" text-center">
            Tailwind
        </div>
    </footer>
</template>

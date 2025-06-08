<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex min-h-screen flex-col items-center bg-gradient pt-6 sm:justify-center sm:pt-0 ">
        <div>
            <img src="..\..\..\public\img\image_29-removebg-preview.png" alt="">
        </div>

        <div
            class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg dark:bg-gray-800">
            <slot />
        </div>
    </div>
</template>

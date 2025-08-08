<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen bg-purple-950 flex items-center justify-center px-4">
        <div class="mt-6 w-full overflow-hidden px-6 shadow-md sm:max-w-md sm:rounded-lg bg-purple-950">
            <Link :href="route('welcome')" class="flex gap-1 w-20 items-center text-purple-100">
              <i class="fa-solid fa-arrow-left"></i>
                <p class="hover:underline">Voltar</p>
            </Link>
            <slot />
        </div>
    </div>
</template>

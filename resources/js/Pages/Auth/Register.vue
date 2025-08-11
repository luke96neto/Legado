<script setup>
import RegisterForm from '@/components/RegisterForm.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
<div class="flex min-h-svh w-full items-center justify-center p-6 md:p-10">
    <div class="w-full max-w-sm">
        <Link :href="route('welcome')" class="flex gap-1 w-20 items-center text-foreground">
        <i class="fa-solid fa-arrow-left"></i>
        </Link>
        <RegisterForm />
    </div>
    </div>
</template>

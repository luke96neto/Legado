<script setup>
import RegisterForm from '@/components/RegisterForm.vue';
import { Link } from '@inertiajs/vue3';
import { Switch } from '@/components/ui/switch';
import { useDark, useToggle } from "@vueuse/core";

const isDark = useDark();
const toggleDark = useToggle(isDark);
</script>

<template>
<div class="flex min-h-svh w-full items-center justify-center p-6 md:p-10">
    <div class="w-full max-w-sm">
        <div class="flex justify-between">
            <Link :href="route('welcome')" class="flex gap-1 w-20 items-center text-foreground transform transition-transform duration-200 hover:scale-105">
            <i class="fa-solid fa-arrow-left "></i>
            </Link>
            <Switch :model-value="isDark" @update:model-value="toggleDark" class="transform transition-transform duration-200 hover:scale-105">
                <template #thumb>
                    <svg v-if="isDark" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-moon size-3">
                        <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-sun size-3">
                        <circle cx="12" cy="12" r="4"></circle>
                        <path d="M12 2v2"></path>
                        <path d="M12 20v2"></path>
                        <path d="m4.93 4.93 1.41 1.41"></path>
                        <path d="m17.66 17.66 1.41 1.41"></path>
                        <path d="M2 12h2"></path>
                        <path d="M20 12h2"></path>
                        <path d="m6.34 17.66-1.41 1.41"></path>
                        <path d="m19.07 4.93-1.41 1.41"></path>
                    </svg>
                </template>
            </Switch>
        </div>
        <RegisterForm />
    </div>
    </div>
</template>

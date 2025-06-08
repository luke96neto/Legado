<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>

    <Head title="Welcome" />
    <div class="bg-gradient">
        <div
            class="relative flex min-h-screen flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:col-start-2 lg:justify-center">
                        <img src="..\..\..\public\img\image_29-removebg-preview.png" alt="">
                    </div>
                    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                            class="border rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Dashboard
                        </Link>

                        <template v-else>
                            <Link :href="route('login')"
                                class="border rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Login/cadastro  ->
                            </Link>
                        </template>
                    </nav>
                </header>

                <main class="mt-6">
                    
                </main>

                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                </footer>
            </div>
        </div>
    </div>
</template>

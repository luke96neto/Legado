<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue'

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});

const navbar = ref(null)
const scrolled = ref(false)

const handleScroll = () => {
    scrolled.value = window.scrollY > 50
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll)
})

onBeforeUnmount(() => {
    window.removeEventListener('scroll', handleScroll)
})
</script>
<template>

    <Head title="Welcome" />
    <div class="bg-[#170423] relative">
        <div class="absolute inset-0 overflow-hidden h-[2064px]">
            <div class="w-full">
                <img src="/img/landingimg.png" alt="Background" class="w-full object-cover object-center">
            </div>
        </div>
        <nav ref="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" :class="{
            'py-4 bg-[#11021b]': scrolled,
            'py-6 bg-transparent': !scrolled
        }">
            <div class="flex justify-between mx-[47px]">
                <img src="/img/logo-legado-wname.png" class="w-[173.5px] h-[59px]" alt="">
                <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                    class="w-40 h-10 text-center py-2 m-2 rounded-lg font-extrabold text-black bg-white hover:bg-gray-100 transition-all duration-200 shadow-md hover:shadow-lg focus:outline-hidden focus:ring-2 focus:ring-blue-500">
                Dashboard
                </Link>
                <Link v-else :href="route('login')"
                    class="w-40 h-10 text-center py-2 m-2 rounded-lg font-extrabold text-black bg-white hover:bg-gray-100 transition-all duration-200 shadow-md hover:shadow-lg focus:outline-hidden focus:ring-2 focus:ring-blue-500">
                Entrar ->
                </Link>
            </div>
        </nav>

        <div class="relative pt-[150px]">
 <main class="h-[5000px]">
                <div class="w-[65%] ml-[17%] mt-[14%]">
                    <h1 class="font-extrabold text-center text-[64px] text-white leading-[63px] -tracking-[1.2px]">Explore. Aprenda. Inspire-se. O Legado conecta gerações através do conhecimento.</h1>
                    <p class=" text-[#C5C5C5] italic text-center text-[32px]">Construímos pontes entre o passado e o futuro, porque o conhecimento só se multiplica quando é compartilhado.</p>
                    <div class="flex justify-center  mt-[12%] h-[40px]">
                        <Link :href="route('register')"
                            class="w-[150px] py-1.5 text-center rounded-lg font-extrabold text-black bg-white hover:bg-gray-100 transition-all duration-200 shadow-md hover:shadow-lg focus:outline-hidden focus:ring-2 focus:ring-blue-500">
                        Criar conta ->
                        </Link>
                    </div>
                </div>
            </main>
            <footer class="py-16 text-center text-sm text-white/70">
            </footer>
        </div>
    </div>
</template>

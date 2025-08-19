<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { Button } from '@/components/ui/button'

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
    
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 relative overflow-hidden">
        <!-- Animated Background Particles -->
        <div class="absolute inset-0 z-0">
            <div class="absolute top-20 left-10 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
            <div class="absolute top-20 right-10 w-72 h-72 bg-yellow-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
        </div>

        <!-- Main Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/20 to-black/80 z-10"></div>
            <img src="/img/landingimg.png" alt="Background" class="w-full h-full object-cover opacity-30">
        </div>

        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 z-5 opacity-10">
            <div class="h-full w-full bg-[radial-gradient(circle,white_1px,transparent_1px)] bg-[size:50px_50px]"></div>
        </div>

        <!-- Navbar -->
        <nav 
            ref="navbar" 
            :class="[
                'fixed top-0 left-0 right-0 z-50 transition-all duration-500',
                scrolled ? 'bg-black/80 backdrop-blur-lg border-b border-white/10 py-2' : 'bg-transparent py-4'
            ]"
        >
            <div class="container mx-auto px-6 flex justify-between items-center">
                <div class="transform transition-transform duration-300 hover:scale-105">
                    <img src="/img/logo-legado-wname.png" class="w-40 h-auto" alt="Logo Legado">
                </div>
                
                <div v-if="$page.props.auth.user" class="transform transition-all duration-300">
                    <Button as-child variant="default" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 border-0 shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <Link :href="route('dashboard')" class="font-semibold">
                            Dashboard
                        </Link>
                    </Button>
                </div>
                <div v-else class="transform transition-all duration-300">
                    <Button as-child variant="default" class="bg-gradient-to-r from-primary to-primary hover:from-primary hover:to-foreground border-0 shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                        <Link :href="route('login')" class="flex items-center gap-2 font-semibold">
                            Entrar
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right transition-transform duration-300 group-hover:translate-x-1">
                                <path d="M5 12h14"/>
                                <path d="m12 5 7 7-7 7"/>
                            </svg>
                        </Link>
                    </Button>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative z-20 min-h-screen flex items-center justify-center px-4">
            <div class="container mx-auto max-w-5xl text-center">
                <!-- Main Heading -->
                <div class="mb-8 animate-fade-in-up">
                    <h1 class="text-6xl md:text-8xl font-bold bg-gradient-to-r from-white via-primary to-pink-200 bg-clip-text text-transparent leading-tight mb-6 animate-pulse-glow">
                        Explore. Aprenda. 
                        <span class="block mt-2">Inspire-se.</span>
                    </h1>
                </div>

                <!-- Subtitle -->
                <div class="mb-12 animate-fade-in-up animation-delay-300">
                    <p class="text-xl md:text-2xl text-gray-300 italic leading-relaxed max-w-3xl mx-auto">
                        Construímos pontes entre o passado e o futuro, porque o conhecimento 
                        só se multiplica quando é compartilhado.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-center gap-6 animate-fade-in-up animation-delay-600">
                    <Button 
                        as-child 
                        size="lg" 
                        v-if="!$page.props.auth.user"
                        class="group bg-gradient-to-r from-primary to-primary hover:from-primary hover:to-primary border-0 shadow-2xl hover:shadow-purple-500/25 hover:scale-105 transition-all duration-300 text-lg px-8 py-4 h-14"
                    >
                        <Link :href="route('register')" class="flex items-center gap-3 font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles">
                                <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/>
                                <path d="M5 3v4"/>
                                <path d="M19 17v4"/>
                                <path d="M3 5h4"/>
                                <path d="M17 19h4"/>
                            </svg>
                            Começar Jornada
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right transition-transform duration-300 group-hover:translate-x-1">
                                <path d="M5 12h14"/>
                                <path d="m12 5 7 7-7 7"/>
                            </svg>
                        </Link>
                    </Button>
                    
                    <Button 
                        as-child 
                        variant="outline" 
                        size="lg" 
                        v-if="!$page.props.auth.user"
                        class="group border-2 border-purple-400/30 bg-black/20 backdrop-blur-sm hover:bg-purple-600/10 hover:border-purple-400/60 hover:scale-105 transition-all duration-300 text-lg px-8 py-4 h-14 text-white hover:text-white"
                    >
                        <Link :href="route('login')" class="flex items-center gap-3 font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-in">
                                <path d="m15 3 4 4-4 4"/>
                                <path d="M2 3h5v18h-5"/>
                                <path d="M7 12h12"/>
                            </svg>
                            Já tenho conta
                        </Link>
                    </Button>
                </div>

            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}

@keyframes fade-in-up {
    0% {
        opacity: 0;
        transform: translateY(30px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse-glow {
    0%, 100% {
        text-shadow: 0 0 20px rgba(168, 85, 247, 0.5);
    }
    50% {
        text-shadow: 0 0 30px rgba(168, 85, 247, 0.8), 0 0 40px rgba(236, 72, 153, 0.3);
    }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

.animate-fade-in-up {
    animation: fade-in-up 1s ease-out forwards;
    opacity: 0;
}

.animation-delay-300 {
    animation-delay: 0.3s;
}

.animation-delay-600 {
    animation-delay: 0.6s;
}

.animation-delay-900 {
    animation-delay: 0.9s;
}

.animate-pulse-glow {
    animation: pulse-glow 3s ease-in-out infinite;
}
</style>
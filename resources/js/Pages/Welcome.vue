<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Button } from '@/components/ui/button';
import { Switch } from '@/components/ui/switch';
import { useDark, useToggle } from "@vueuse/core";

const isDark = useDark();
const toggleDark = useToggle(isDark);

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
    
    <div class="min-h-screen bg-[var(--color-background)] relative overflow-hidden">
        <!-- Navbar -->
        <nav 
            ref="navbar" 
            class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 bg-[var(--color-sidebar)] border-b border-[var(--color-sidebar-border)] py-2"
        >
            <div class="container mx-auto px-6 flex justify-between items-center">
                <div class="transform transition-transform duration-300 hover:scale-102">
                    <img src="/img/logoimg.png" class="w-40 h-auto text-[var(--color-primary)]" alt="Logo Legado">
                </div>
                <div class="flex items-center gap-10">
                    <Switch :model-value="isDark" @update:model-value="toggleDark" class="transform transition-transform duration-300 hover:scale-105">
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
                    <div v-if="$page.props.auth.user" class="transform transition-all duration-300">
                        <Button as-child variant="default" class="bg-[var(--color-primary)] border-0 shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                            <Link :href="route('dashboard')" class="font-semibold text-[var(--color-primary-foreground)]">
                                Dashboard
                            </Link>
                        </Button>
                    </div>
                    <div v-else class="transform transition-all duration-300">
                        <Button as-child variant="default" class="bg-[var(--color-primary)] border-0 shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
                            <Link :href="route('login')" class="flex items-center gap-2 font-semibold text-[var(--color-primary-foreground)]">
                                Entrar
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right transition-transform duration-300 group-hover:translate-x-1">
                                    <path d="M5 12h14"/>
                                    <path d="m12 5 7 7-7 7"/>
                                </svg>
                            </Link>
                        </Button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative z-20 mt-50 h-7xl flex items-center justify-center px-4">
            <div class="container mx-auto max-w-5xl text-center">
                <img src="/img/globo-Legado.png" alt="Logo" class="mx-auto  h-auto" />
                <!-- Main Heading -->
                <div class="mb-8">
                    <h1 class="text-6xl md:text-8xl font-bold bg-gradient-to-r from-[var(--color-primary)] via-[var(--color-primary)/60] to-[var(--color-accent)] bg-clip-text text-transparent leading-tight mb-6">
                        Explore. Aprenda. 
                        <span class="block mt-2">Inspire-se.</span>
                    </h1>
                </div>

                <!-- Subtitle -->
                <div class="mb-12">
                    <p class="text-xl md:text-2xl text-[var(--color-muted-foreground)] italic leading-relaxed max-w-3xl mx-auto">
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
                        class="group bg-[var(--color-primary)] border-0 shadow-2xl hover:shadow-[0_20px_40px_-10px_rgba(138,121,171,0.25)] hover:scale-105 transition-all duration-300 text-lg px-8 py-4 h-14"
                    >
                        <Link :href="route('register')" class="flex items-center gap-3 font-semibold text-[var(--color-primary-foreground)]">
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
                        class="group border-2 border-[var(--color-sidebar-border)]/40 bg-[var(--color-sidebar)]/10 backdrop-blur-sm hover:bg-[var(--color-sidebar)]/20 hover:border-[var(--color-sidebar-border)]/60 hover:scale-105 transition-all duration-300 text-lg px-8 py-4 h-14 text-[var(--color-foreground)]"
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

h1 {
    color: var(--color-primary);
}

p {
    color: var(--color-muted-foreground);
}

button .text-\[var\(--color-primary-foreground\)\] {
    text-shadow: 0 1px 0 rgba(0,0,0,0.05);
}
</style>
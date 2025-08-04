<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="p-6 text-white bg-black min-h-screen">
            <!-- Título -->
            <div class="w-full flex justify-center items-center mt-1">
            <!-- <img src="/img/globo-Legado.png" alt="Logo Legado" class="h-45"> -->
            </div>

            <!-- Estatísticas -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center mb-8">
                <div>
                    <p class="text-purple-400 text-2xl font-bold">14</p>
                    <p class="text-sm">projetos cadastrados</p>
                </div>
                <div>
                    <p class="text-purple-400 text-2xl font-bold">30</p>
                    <p class="text-sm">ideias cadastradas</p>
                </div>
                <div>
                    <p class="text-purple-400 text-2xl font-bold">5</p>
                    <p class="text-sm">instituições cadastradas</p>
                </div>
                <div>
                    <p class="text-purple-400 text-2xl font-bold">14</p>
                    <p class="text-sm">projetos pendentes</p>
                </div>
            </div>

            <!-- Campo de pesquisa -->
            <div class="flex justify-center mb-10">
                <input
                    type="text"
                    placeholder="Pesquisar..."
                    class="w-full sm:w-1/2 px-4 py-2 rounded-full text-black"
                />
            </div>

            <!-- Projetos mais ou menos -->
            <section class="mb-10">
                <h2 class="text-white text-lg font-bold mb-2">Projetos mais ou menos</h2>
                <div class="flex overflow-x-auto space-x-4">
                    <!-- Exemplo de card de projeto -->
                    <div class="min-w-[120px] bg-gray-800 p-2 rounded text-center">
                        <img src="/projetos/figma.png" alt="Figma" class="w-full h-24 object-cover rounded mb-1">
                        <p class="text-sm">Figma</p>
                    </div>
                    <!-- Repita cards para outros projetos... -->
                </div>
            </section>

            <!-- Criadores exemplares -->
            <section class="mb-10">
                <h2 class="text-white text-lg font-bold mb-2">Criadores exemplares</h2>
                <div class="flex overflow-x-auto space-x-4">
                    <div class="min-w-[80px] text-center">
                        <img src="/usuarios/david.png" class="w-12 h-12 rounded-full mx-auto mb-1" />
                        <p class="text-sm">DaV1D</p>
                    </div>
                    <!-- Adicione mais criadores -->
                </div>
            </section>

            <!-- Meus projetos -->
            <section>
                <h2 class="text-white text-lg font-bold mb-2">Meus projetos</h2>
                <div class="flex overflow-x-auto space-x-4">
                    <div class="min-w-[120px] bg-gray-800 p-2 rounded text-center">
                        <img src="/meus-projetos/master_of_puppets.png" alt="Master" class="w-full h-24 object-cover rounded mb-1">
                        <p class="text-sm">Master of Puppets</p>
                    </div>
                    <!-- Adicione mais cards -->
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
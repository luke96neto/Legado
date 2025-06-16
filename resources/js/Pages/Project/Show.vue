<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    project: Object,
});

</script>

<template>

    <Head title="Detalhes do Projeto" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Projeto: {{ project.title }}
            </h2>
        </template>
        <div class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">
                    <span class="text-blue-600">Título:</span> {{ project.title }}
                </h2>
                <p class="text-gray-600 mb-3">
                    <span class="text-blue-600">Descrição:</span> {{ project.description }}
                </p>
                <p class="text-sm mb-4">
                    <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded-full">
                        {{ project.status }}
                    </span>
                </p>

                <div class="border-t pt-3">
                    <p class="text-sm text-gray-500">Autores:</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <span v-for="author in project.authors" :key="author.id"
                            class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">
                            {{ author.name }}
                        </span>
                    </div>
                </div>
            </div>
            <Link :href="route('project.index')">
                <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                    Voltar para Projetos
                </button>
            </Link>
        </div>
    </AuthenticatedLayout>

</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    projects: Object,
});
</script>

<template>

    <Head title="Projetos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Projetos
            </h2>
        </template>

        <div class="container mx-auto px-4 py-8">
            <div class="mb-6">
                <Link :href="route('project.create')"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                    Criar Novo Projeto
                </Link>
            </div>
            <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <li v-for="project in projects.data" :key="project.id"
                    class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <Link :href="route('project.show', project.slug)" class="block h-full">
                        <div class="p-6">
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

                            <p class="text-sm text-gray-500 mb-3">
                                <span class="text-blue-600">Criado em:</span> 
                                {{ new Date(project.created_at).toLocaleDateString() }}
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
                    </Link>
                </li>
            </ul>
            <div class="mt-8 flex justify-center">
                <nav class="flex items-center gap-1">
                    <Link 
                        v-for="(link, index) in projects.links"
                        :key="index"
                        :href="link.url || '#'"
                        :class="{
                            'px-4 py-2 rounded-md': true,
                            'bg-blue-600 text-white': link.active,
                            'bg-white text-gray-700 hover:bg-gray-100': !link.active && link.url,
                            'text-gray-400 cursor-not-allowed': !link.url
                        }"
                        v-html="link.label"
                        preserve-state
                    />
                </nav>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
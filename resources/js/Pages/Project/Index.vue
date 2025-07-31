<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { onMounted, reactive } from 'vue';

const props = defineProps({
    projects: Object,
    formData: Object,
});

const user = usePage().props.auth?.user;

const form = reactive({
    isFavorite: 0,
    ...props.formData
})

function isAuthor(project) {
  if (!user) return false;
  // Ajuste conforme o backend: user_id ou id
  return project.authors.some(author => author.user_id === user.id);
}

function setFavorites() {
    form.isFavorite = (+form.isFavorite + 1) % 2;
    router.get(route('project.index'), form);
}

</script>

<template>

    <Head title="Projetos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                
            </h2>
        </template>

        <div class="container mx-auto px-4 py-8">
            <div class="mb-6">
                <Link :href="route('project.create')"
                    class="inline-flex items-center px-4 py-2 bg-purple-800 text-white rounded hover:bg-blue-700 transition-colors">
                    Criar Novo Projeto
                </Link>
            </div>
            <div>
                <label class="text-white">
                    <input type="checkbox" :checked="+form.isFavorite == 1" v-on:change="setFavorites" /> 
                    Favoritos
                </label>
            </div>
            <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <li v-for="project in projects.data" :key="project.id"
                    class="bg-black border-2 border-purple-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="h-full flex flex-col">
                        <Link :href="route('project.show', project.slug)" class="flex-1">
                            <div class="p-6">
                                <h2 class="text-xl font-semibold text-gray-300 mb-2">
                                    <span class="text-purple-600">Título:</span> {{ project.title }}
                                </h2>
                                <p class="text-gray-300 mb-3">
                                    <span class="text-purple-600">Descrição:</span> {{ project.description }}
                                </p>
                                <p class="text-sm mb-4">
                                    <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded-full">
                                        {{ project.status }}
                                    </span>
                                </p>
                                <p class="text-sm text-gray-300 mb-3">
                                    <span class="text-purple-600">Criado em:</span> 
                                    {{ new Date(project.created_at).toLocaleDateString() }}
                                </p>
                                <div class="border-t pt-3">
                                    <p class="text-sm text-gray-300">Autores:</p>
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        <span v-for="author in project.authors" :key="author.id"
                                            class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">
                                            {{ author.name }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-3 border-t pt-3">
                                    <p class="text-sm text-gray-300">Tags:</p>
                                    <div v-if="project.tags.length > 0" class="flex flex-wrap gap-2 mt-2">
                                        <span 
                                            v-for="tag in project.tags" 
                                            :key="tag.id"
                                            class="text-xs px-3 py-1 rounded-full"
                                            :style="{
                                                'background-color': `${tag.color}20`, 
                                                'color': tag.color,
                                            }"
                                        >
                                            {{ tag.name }}
                                        </span>
                                    </div>
                                    <div v-else class="flex flex-wrap gap-2 mt-2">
                                        <span 
                                            class="text-gray-300 text-sm"
                                        >
                                            Sem tags
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-3 border-t pt-3">
                                    <p class="text-sm text-gray-300">Avaliação Média:</p>
                                    <div class="flex items-center mt-2">
                                        <span 
                                            v-if="project.feedbacks_avg_rating"
                                            class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full"
                                        >
                                            {{ Math.round(project.feedbacks_avg_rating * 10) / 10 }} ★
                                        </span>
                                        <span v-else class="text-gray-300 text-sm">
                                            Sem avaliações
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </Link>
                        <!-- Botão de edição para o autor -->
                        <div v-if="isAuthor(project)" class="mt-4 px-6 pb-4">
                            <Link :href="route('project.edit', project.slug)"
                                class="inline-flex items-center px-3 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition-colors">
                                Editar
                            </Link>
                        </div>
                    </div>
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
                            'bg-purple-600 text-white': link.active,
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
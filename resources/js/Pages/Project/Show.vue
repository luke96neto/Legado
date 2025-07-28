<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3'; // Adicionado usePage
import StarRating from '@/Components/StarRating.vue'; // Importe seu componente StarRating
import FavoriteButton from '@/Components/FavoriteButton.vue';

// Define as props que este componente Vue espera receber do Laravel
const props = defineProps({
    project: Object, // O objeto project, que agora deve incluir avg_rating, ratings_count, user_rating
});

const page = usePage(); // Hook para acessar as props globais do Inertia (como auth.user e flash)

// Lógica para obter a avaliação atual do usuário, se existir
const currentUserRating = props.project.user_rating ? props.project.user_rating.rating : 0;
const currentUserFavorited = props.project.user_favorited ? true : false;

// Lógica para verificar se o usuário está logado
const userIsLoggedIn = !!page.props.auth.user;

</script>

<template>

    <Head :title="project.title" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text- dark:text-gray-200">
                Projeto: {{ project.title }}
            </h2>
        </template>
        <div class="container mx-auto px-4 py-8">
            <div class="bg-black rounded-lg shadow-md p-6">
                <div class="flex justify-between">
                    <h2 class="text-xl font-semibold text-gray-300 mb-2">
                        <span class="text-purple-600">Título:</span> {{ project.title }}
                    </h2>
                    <favorite-button :project-id="project.id" :current-fav-value="currentUserFavorited"></favorite-button>
                </div>
                <p class="text-gray-300 mb-3">
                    <span class="text-purple-600">Descrição:</span> {{ project.description }}
                </p>
                <div v-if="project.image">
                    <p>Imagem do projeto:</p>
                    <img class="m-3" :src="`/storage/${project.image}`" :alt="`Imagem do projeto ${project.title}`">
                </div>

                <div class="border-t pt-3">
                    <p class="text-sm text-gray-300">Autores:</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <span v-for="author in project.authors" :key="author.id"
                            class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">
                            {{ author.name }}
                        </span>
                    </div>
                </div>
                <div class="mt-2 border-t pt-3">
                    <p class="text-sm text-gray-300">Link repositório:</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <a :href="project.repo_url" target="_blank"
                            class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full">
                            {{ project.repo_url }}
                        </a>
                    </div>
                </div>
                <div class="mt-2 border-t pt-3">
                    <p class="text-sm text-gray-300">Status:</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full">
                            {{ project.status }}
                        </span>
                    </div>
                </div>

                <hr class="my-6">

                <h3 class="text-xl text-white font-semibold mb-3">Avaliações</h3>
                <template v-if="project.ratings_count > 0">
                    <p class="text-lg text-white mb-2">Média de Avaliações:
                        <strong class="text-yellow-500">
                            {{ parseFloat(project.average_rating).toFixed(1) }}
                            <i class="fa-solid fa-star"></i>
                        </strong>
                        (de {{ project.ratings_count }} avaliações)
                    </p>
                </template>
                <template v-else>
                    <p class="text-gray-300 mb-2">Ainda não há avaliações para este projeto.</p>
                </template>

                <template v-if="userIsLoggedIn">
                    <h4 class="text-lg text-white font-semibold mt-6 mb-3">Sua Avaliação:</h4>
                    <star-rating :project-id="project.id" :current-rating="currentUserRating"></star-rating>
                </template>
                <template v-else>
                    <p class="text-blue-600 mt-6">
                        <Link :href="route('login')" class="underline hover:no-underline">Faça login</Link> para avaliar
                        este projeto.
                    </p>
                </template>

                <template v-if="page.props.flash?.success">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4"
                        role="alert">
                        {{ page.props.flash.success }}
                    </div>
                </template>
                <template v-if="page.props.flash?.error">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4"
                        role="alert">
                        {{ page.props.flash.error }}
                    </div>
                </template>
                <template v-if="page.props.errors?.rating">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4"
                        role="alert">
                        {{ page.props.errors.rating }}
                    </div>
                </template>

            </div>
            <Link :href="route('project.index')">
            <button class="mt-4 px-4 py-2 bg-purple-600 text-white rounded hover:bg-blue-700 transition-colors">
                Voltar para Projetos
            </button>
            </Link>
        </div>
    </AuthenticatedLayout>

</template>
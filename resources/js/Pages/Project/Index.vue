<script setup>
import ProjectCard from '@/components/ProjectCard.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { reactive, watch } from 'vue';
import Card from '@/Components/Card.vue';
import { Input } from '@/components/ui/input'; // Adicione esta importação

const props = defineProps({
    projects: Object,
    formData: Object,
    countItems: Number,
    all_tags: Array,
});

const user = usePage().props.auth?.user;
const hasItems = props.countItems !== 0;

const form = reactive({
    isFavorite: 0,
    selectedTags: [],
    search: '', // Adicione este campo
    ...props.formData
})

function setFavorites() {
    form.isFavorite = (+form.isFavorite + 1) % 2;
    submitForm();
}

function toggleTag(tagId) {
    const index = form.selectedTags.indexOf(tagId.toString());
    if (index === -1) {
        form.selectedTags.push(tagId.toString());
    } else {
        form.selectedTags.splice(index, 1);
    }
    submitForm();
}

function submitForm() {
    router.get(route('project.index'), {
        ...form,
        tags: form.selectedTags.join(','),
        page: 1 // Reset para a primeira página ao aplicar filtros
    }, {
        preserveState: true
    });
}

function isTagSelected(tagId) {
    return form.selectedTags.includes(tagId.toString());
}

// Debounce para a pesquisa
let searchTimeout = null;
watch(() => form.search, (newValue) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        submitForm();
    }, 500);
});

</script>

<template>

    <Head title="Projetos" />

    <AuthenticatedLayout>
        <div class="container mx-auto px-4 py-8">
            <!-- Barra de pesquisa e filtros -->
            <div class="mb-6">
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                <!-- Botão de adicionar projeto (à esquerda) -->
                <div class="md:flex-1">
                    <Link :href="route('project.create')"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-primary-foreground rounded-sm hover:bg-primary/90 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-circle-plus">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M8 12h8"></path>
                            <path d="M12 8v8"></path>
                        </svg>
                        Adicionar Projeto
                    </Link>
                </div>
                <div class="w-full md:w-1/2 mx-auto flex items-center gap-3">
                    <label for="search">
                        <svg data-prefix="fas" data-icon="magnifying-glass" role="img" viewBox="0 0 512 512" aria-hidden="true" class="svg-inline--fa fa-magnifying-glass size-4"><path fill="currentColor" d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376C296.3 401.1 253.9 416 208 416 93.1 416 0 322.9 0 208S93.1 0 208 0 416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" class=""></path></svg>
                    
                    </label>
                    <Input 
                        type="text"
                        name="search"
                        v-model="form.search" 
                        placeholder="Pesquisar projetos..." 
                        class="w-full py-2 px-4 text-base" 
                    />
                </div>
        <div class="md:flex-1"></div>
            </div>
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <!-- Tags -->
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-foreground">Filtrar por tags:</span>
                        <div class="flex flex-wrap gap-2">
                            <span v-for="tag in props.all_tags" :key="tag.id"
                                class="text-xs px-3 py-1 rounded-full bg-secondary hover:bg-secondary/80 hover:text-secondary-foreground/90 text-secondary-foreground hover:cursor-pointer transition-colors"
                                :class="{ 'bg-primary text-white': isTagSelected(tag.id) }" @click="toggleTag(tag.id)">
                                {{ tag.name }}
                                <span v-if="isTagSelected(tag.id)" class="ml-1">×</span>
                            </span>
                        </div>
                    </div>

                    <!-- Favoritos -->
                    <label class="flex items-center gap-2 text-foreground hover:cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 text-primary rounded border-gray-300 focus:ring-primary"
                            :checked="+form.isFavorite == 1" @change="setFavorites" />
                        Mostrar apenas favoritos
                    </label>
                </div>
            </div>

            <!-- Resultados -->
            <div v-if="hasItems" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <Card v-for="project in projects.data" :key="project.id" :title="project.title" :image="project.image"
                    :description="project.description" :link="route('project.show', project.slug)"
                    :status="project.status" :tags="project.tags" :ownerId="project.user_id" :slug="project.slug"
                    :averageRating="project.feedbacks_avg_rating" fallback="/project-images/default.jpg" />
            </div>

            <!-- Mensagem quando não há resultados -->
            <div v-else class="text-center py-12">
                <p class="text-muted-foreground">Nenhum projeto encontrado com os filtros atuais.</p>
                <Button variant="outline" class="mt-4" @click="() => {
                    form.search = '';
                    form.selectedTags = [];
                    form.isFavorite = 0;
                    submitForm();
                }">
                    Limpar filtros
                </Button>
            </div>

            <!-- Paginação -->
            <div v-if="hasItems" class="mt-8 flex justify-center">
                <nav class="flex items-center gap-1">
                    <Link v-for="(link, index) in projects.links" :key="index" :href="link.url || '#'" :class="{
                        'px-4 py-2 rounded-md': true,
                        'bg-primary text-white': link.active,
                        'bg-card text-foreground/80 hover:bg-secondary/90': !link.active && link.url,
                        'text-gray-400 cursor-not-allowed': !link.url
                    }" v-html="link.label" preserve-state />
                </nav>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
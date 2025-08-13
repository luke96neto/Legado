<script setup>
import ProjectCard from '@/components/ProjectCard.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { reactive } from 'vue';
import Card from '@/Components/Card.vue';

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
        page: 1
    });
}

function isTagSelected(tagId) {
    return form.selectedTags.includes(tagId.toString());
}

</script>

<template>

    <Head title="Projetos" />

    <AuthenticatedLayout>

        <div class="container mx-auto px-4 py-8">
            <div class="flex justify-between">
                <div class="mb-6">
                    <Link :href="route('project.create')"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-primary-foreground rounded-sm hover:bg-secondary/80 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-plus"><circle cx="12" cy="12" r="10"></circle><path d="M8 12h8"></path><path d="M12 8v8"></path></svg>
                        Adicionar Projeto
                    </Link>
                </div>
                
                <div class="flex items-center gap-2">
                    <span class="text-foreground">Tags:</span>
                    <div class="flex flex-wrap gap-2 mt-2 mb-2">
                        <span
                            v-for="tag in props.all_tags"
                            :key="tag.id"
                            class="text-xs px-3 py-1 rounded-full bg-secondary hover:bg-secondary/80 hover:text-secondary-foreground/90 text-secondary-foreground hover:cursor-pointer"
                            @click="toggleTag(tag.id)"
                            >
                            {{ tag.name }}
                            <div v-if="isTagSelected(tag.id)" class="inline">
                                ×
                            </div>
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="text-foreground hover:cursor-pointer">
                    <input class="hover:cursor-pointer" type="checkbox" :checked="+form.isFavorite == 1" v-on:change="setFavorites" /> 
                    Favoritos
                </label>
            </div>
            
            <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <li v-for="project in projects.data" :key="project.id">
                    <Card
                        :title="project.title"
                        :image="project.image"
                        :description="project.description"
                        :link="route('project.show', project.slug)"
                        :status="project.status"
                        :tags="project.tags"
                        :ownerId="project.user_id"
                        :slug="project.slug"
                        :averageRating="project.feedbacks_avg_rating"
                        fallback="/project-images/default.jpg"
                    />
                </li>
                </ul>
                <div v-if="hasItems" class="mt-8 flex justify-center">
                <nav class="flex items-center gap-1">
                    <Link 
                        v-for="(link, index) in projects.links"
                        :key="index"
                        :href="link.url || '#'"
                        :class="{
                            'px-4 py-2 rounded-md': true,
                            'bg-primary text-background': link.active,
                            'bg-card text-foreground/80 hover:bg-secondary/90': !link.active && link.url,
                            'text-gray-400 cursor-not-allowed': !link.url
                        }"
                        v-html="link.label"
                        preserve-state
                    />
                </nav>
            </div>
            <div v-else class="flex flex-wrap gap-2 mt-2 text-center">
                <span 
                    class="text-gray-400 text-sm text-center"
                    >
                    Sem registros.
                </span>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

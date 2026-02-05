<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import StarRating from '@/components/StarRating.vue';
import FavoriteButton from '@/components/FavoriteButton.vue';
import { Button } from '@/components/ui/button';
import { Card, CardHeader, CardTitle, CardContent, CardFooter } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';

const props = defineProps({
    project: Object,
});

const page = usePage();
const currentUserRating = props.project.user_rating ? props.project.user_rating.rating : 0;
const currentUserFavorited = props.project.user_favorited ? true : false;
const userIsLoggedIn = !!page.props.auth.user;
</script>

<template>

    <Head :title="project.title" />

    <AuthenticatedLayout>

        <div class="container max-w-5xl mx-auto px-4 py-8">
            <Card class="border border-ring bg-card rounded-lg">
                <CardHeader class="border-b border-ring">
                    <div class="flex justify-between items-center">
                        <CardTitle class="text-2xl font-semibold text-foreground">
                            {{ project.title }}
                        </CardTitle>
                        <FavoriteButton :project-id="project.id" :current-fav-value="currentUserFavorited"
                            class="text-primary" />
                    </div>
                </CardHeader>

                <CardContent class=" grid gap-6">
                    <div v-if="project.image" class="rounded-md overflow-hidden">
                        <img :src="`/storage/${project.image}`" :alt="`Imagem do projeto ${project.title}`"
                            class="w-full h-auto max-h-96 object-contain">
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-foreground mb-2">Descrição</h3>
                        <p class="text-muted-foreground">{{ project.description || 'Nenhuma descrição fornecida' }}</p>
                    </div>

                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <h3 class="text-lg font-medium text-foreground mb-2">Autores</h3>
                            <div class="flex flex-wrap gap-2">
                                <Badge v-for="author in project.authors" :key="author.id" variant="secondary">
                                    {{ author.name }}
                                </Badge>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-foreground mb-2">Status</h3>
                            <Badge :variant="project.status === 'concluido' ? 'success' :
                                project.status === 'em_andamento' ? 'warning' : 'default'
                                ">
                                {{
                                    project.status === 'em_andamento' ? 'Em andamento' :
                                        project.status === 'concluido' ? 'Concluído' : 'Rascunho'
                                }}
                            </Badge>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-foreground mb-2">Repositório</h3>
                            <div v-if="project.repo_url">
                                <a :href="project.repo_url" target="_blank"
                                    class="text-primary hover:underline inline-flex items-center gap-1">
                                    <span>Ver no GitHub</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-external-link">
                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                                        <polyline points="15 3 21 3 21 9" />
                                        <line x1="10" x2="21" y1="14" y2="3" />
                                    </svg>
                                </a>
                            </div>
                            <p v-else class="text-muted-foreground">Nenhum link fornecido</p>
                        </div>
                    </div>

                    <div class="border-t border-ring pt-6">
                        <h3 class="text-xl font-semibold text-foreground mb-4">Avaliações</h3>

                        <div v-if="project.ratings_count > 0" class="flex items-center gap-4 mb-6">
                            <div class="text-4xl font-bold text-foreground">
                                {{ parseFloat(project.average_rating).toFixed(1) }}
                            </div>
                            <div>
                                <p class="text-sm text-muted-foreground mt-1">
                                    Baseado em {{ project.ratings_count }} avaliações
                                </p>
                            </div>
                        </div>
                        <p v-else class="text-muted-foreground mb-6">Ainda não há avaliações para este projeto.</p>

                        <div v-if="userIsLoggedIn">
                            <h4 class="text-lg font-medium text-foreground mb-3">Sua Avaliação</h4>
                            <StarRating :project-id="project.id" :current-rating="currentUserRating" />
                        </div>
                        <div v-else class="text-center py-4 border-t border-ring mt-4">
                            <p class="text-muted-foreground">
                                <Link :href="route('login')" class="text-primary hover:underline">
                                Faça login
                                </Link>
                                para avaliar este projeto.
                            </p>
                        </div>
                    </div>
                </CardContent>

                <CardFooter class="border-t border-ring flex justify-between items-center pt-6">
                    <Link :href="route('project.index')">
                    <Button variant="outline">
                        Voltar para Projetos
                    </Button>
                    </Link>

                    <div v-if="page.props.auth.user?.id === project.user_id">
                        <Link :href="route('project.edit', project.slug)">
                        <Button variant="secondary">
                            Editar Projeto
                        </Button>
                        </Link>
                    </div>
                </CardFooter>
            </Card>

            <template v-if="page.props.flash?.success">
                <div class="mt-4 p-4 bg-success/15 text-success border border-success rounded-lg">
                    {{ page.props.flash.success }}
                </div>
            </template>
            <template v-if="page.props.flash?.error">
                <div class="mt-4 p-4 bg-destructive/15 text-destructive border border-destructive rounded-lg">
                    {{ page.props.flash.error }}
                </div>
            </template>
            <template v-if="page.props.errors?.rating">
                <div class="mt-4 p-4 bg-destructive/15 text-destructive border border-destructive rounded-lg">
                    {{ page.props.errors.rating }}
                </div>
            </template>
        </div>
    </AuthenticatedLayout>
</template>
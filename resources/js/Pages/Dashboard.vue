<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Card, CardHeader, CardTitle, CardContent, CardFooter } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Avatar, AvatarImage, AvatarFallback } from '@/components/ui/avatar';

const props = defineProps({
  totalProjects: Number,
  projectsInProgress: Number,
  completedProjects: Number,
  draftProjects: Number,
  examples: Array,
  topCreators: Array,
  myProjects: Array,
});
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <div class="container max-w-7xl mx-auto px-4 py-8">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <Card class="hover:shadow-md transition-shadow">
          <CardHeader class="pb-2">
            <p class="text-sm font-medium text-muted-foreground">Total de Projetos</p>
          </CardHeader>
          <CardContent>
            <div class="text-3xl font-bold text-primary">{{ totalProjects }}</div>
          </CardContent>
        </Card>

        <Card class="hover:shadow-md transition-shadow">
          <CardHeader class="pb-2">
            <p class="text-sm font-medium text-muted-foreground">Em Andamento</p>
          </CardHeader>
          <CardContent>
            <div class="text-3xl font-bold text-yellow-500">{{ projectsInProgress }}</div>
          </CardContent>
        </Card>

        <Card class="hover:shadow-md transition-shadow">
          <CardHeader class="pb-2">
            <p class="text-sm font-medium text-muted-foreground">Concluídos</p>
          </CardHeader>
          <CardContent>
            <div class="text-3xl font-bold text-green-500">{{ completedProjects }}</div>
          </CardContent>
        </Card>

        <Card class="hover:shadow-md transition-shadow">
          <CardHeader class="pb-2">
            <p class="text-sm font-medium text-muted-foreground">Rascunhos</p>
          </CardHeader>
          <CardContent>
            <div class="text-3xl font-bold text-muted-foreground">{{ draftProjects }}</div>
          </CardContent>
        </Card>
      </div>

      <section class="mb-10">
        <Card>
          <CardHeader>
            <CardTitle class="text-xl">Top Criadores</CardTitle>
            <p class="text-sm text-muted-foreground">Quem mais contribui com projetos</p>
          </CardHeader>
          <CardContent>
            <div class="flex flex-wrap gap-6">
              <div
                v-for="creator in topCreators"
                :key="creator.id"
                class="flex flex-col items-center text-center"
              >
                <Avatar class="w-16 h-16 mb-2">
                  <AvatarImage :src="'/storage/' + creator.image" />
                  <AvatarFallback class="bg-input">
                    {{ creator.name?.charAt(0) || creator.nickname?.charAt(0) || 'U' }}
                  </AvatarFallback>
                </Avatar>
                <div>
                  <p class="font-medium">{{ creator.name || creator.nickname || 'Usuário' }}</p>
                  <Badge variant="secondary" class="mt-1">
                    {{ creator.projects_count }} projeto{{ creator.projects_count !== 1 ? 's' : '' }}
                  </Badge>
                </div>
              </div>
            </div>
          </CardContent>
        </Card>
      </section>

      <section>
        <Card>
          <CardHeader>
            <CardTitle class="text-xl">Meus Projetos</CardTitle>
            <p class="text-sm text-muted-foreground">Seus projetos recentes</p>
          </CardHeader>
          <CardContent>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
              <Card 
                v-for="project in myProjects" 
                :key="project.id"
                class="hover:shadow-md transition-shadow h-full"
              >
                <CardHeader>
                  <img
                    :src="project.image ? `/storage/${project.image}` : '/storage/project-images/default.jpg'"
                    :alt="`Imagem do projeto ${project.title}`"
                    class="w-full h-40 object-cover rounded-md mb-3"
                  >
                  <CardTitle class="text-lg">{{ project.title }}</CardTitle>
                  <Badge 
                    :variant="
                      project.status === 'concluido' ? 'success' : 
                      project.status === 'em_andamento' ? 'warning' : 'default'
                    "
                  >
                    {{ 
                      project.status === 'em_andamento' ? 'Em andamento' : 
                      project.status === 'concluido' ? 'Concluído' : 'Rascunho'
                    }}
                  </Badge>
                </CardHeader>
                <CardContent>
                  <p class="text-sm text-muted-foreground line-clamp-2">{{ project.description }}</p>
                </CardContent>
                <CardFooter>
                  <Button 
                    as-child
                    variant="outline" 
                    class="w-full"
                  >
                    <a :href="`/project/${project.slug}`">Ver Projeto</a>
                  </Button>
                </CardFooter>
              </Card>
            </div>
          </CardContent>
        </Card>
      </section>
    </div>
  </AuthenticatedLayout>
</template>2
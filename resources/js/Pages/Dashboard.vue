<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';

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
    <div class="p-6 text-white bg-black min-h-screen">
      <!-- Estatísticas -->
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center mb-8">
        <div>
          <p class="text-purple-400 text-2xl font-bold">{{ totalProjects }}</p>
          <p class="text-sm">Projetos cadastrados</p>
        </div>
        <div>
          <p class="text-purple-400 text-2xl font-bold">{{ projectsInProgress }}</p>
          <p class="text-sm">Em andamento</p>
        </div>
        <div>
          <p class="text-purple-400 text-2xl font-bold">{{ completedProjects }}</p>
          <p class="text-sm">Projetos concluídos</p>
        </div>
        <div>
          <p class="text-purple-400 text-2xl font-bold">{{ draftProjects }}</p>
          <p class="text-sm">Rascunhos</p>
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

      <!-- Projetos exemplo -->
      <section class="mb-10">
        <h2 class="text-white text-lg font-bold mb-2">Exemplos</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 gap-4">
          <Card
            v-for="example in examples"
            :key="example.id"
            :title="example.title"
            :image="example.image"
            :description="example.description"
            :link="`/projects/${example.id}`"
            fallback="/projetos/default.png"
          />
        </div>
      </section>

      <!-- Criadores com mais projetos -->
      <section class="mb-10">
        <h2 class="text-white text-lg font-bold mb-2">Criadores com mais projetos</h2>
        <div class="flex overflow-x-auto space-x-4">
          <div
            v-for="creator in topCreators"
            :key="creator.id"
            class="min-w-[80px] text-center"
          >
            <img
              :src="creator.profile_photo_url || '/usuarios/default.png'"
              alt="Foto do criador"
              class="w-12 h-12 rounded-full mx-auto mb-1"
            />
            <p class="text-sm">{{ creator.name || creator.nickname || 'Usuário' }}</p>
          </div>
        </div>
      </section>

      <!-- Meus projetos -->
      <section>
        <h2 class="text-white text-lg font-bold mb-2">Meus projetos</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 gap-4">
          <Card
            v-for="project in myProjects"
            :key="project.id"
            :title="project.title"
            :image="project.image"
            :description="project.description"
            :link="`/project/${project.slug}`"
            fallback="/meus-projetos/default.png"
          />
        </div>
      </section>
    </div>
  </AuthenticatedLayout>
</template>

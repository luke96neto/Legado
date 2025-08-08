<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

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
      <!-- Título -->
      <div class="w-full flex justify-center items-center mt-1">
        <!-- <img src="/img/globo-Legado.png" alt="Logo Legado" class="h-45"> -->
      </div>

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
        <div class="flex overflow-x-auto space-x-4">
          <div
            v-for="example in examples"
            :key="example.id"
            class="min-w-[120px] bg-gray-800 p-2 rounded-sm text-center"
          >
            <img
              :src="example.image ? `/storage/${example.image}` : '/projetos/default.png'"
              :alt="example.title"
              class="w-full h-24 object-cover rounded-sm mb-1"
            />
            <p class="text-sm">{{ example.title }}</p>
          </div>
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
        <div class="flex overflow-x-auto space-x-4">
          <div
            v-for="project in myProjects"
            :key="project.id"
            class="min-w-[120px] bg-gray-800 p-2 rounded-sm text-center"
          >
            <img
              :src="project.image ? `/storage/${project.image}` : '/meus-projetos/default.png'"
              :alt="project.title"
              class="w-full h-24 object-cover rounded-sm mb-1"
            />
            <p class="text-sm">{{ project.title }}</p>
          </div>
        </div>
      </section>
    </div>
  </AuthenticatedLayout>
</template>

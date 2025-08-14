<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProjectForm from '@/components/Project/ProjectForm.vue';

const props = defineProps({
  project: Object,
  tags: Array
});

function onFileChange(e) {
  form.image = e.target.files[0];
}

function submit(form) {
  form.put(route('project.update', { project: props.project.slug }), {
    preserveScroll: true,
    onError: (errors) => {
      console.error(errors);
    }
  });
}
</script>

<template>
  <Head title="Projects - Edit" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-300 dark:text-gray-200">
        Editar Projeto
      </h2>
    </template>
    <div class="container mx-auto px-4 py-8">
      <ProjectForm :project="props.project" :tags="props.tags" @submit="submit" />
    </div>
  </AuthenticatedLayout>
</template>

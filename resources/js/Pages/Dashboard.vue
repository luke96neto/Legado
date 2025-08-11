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
    <div class="flex flex-1 flex-col gap-4 p-4 pt-0">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
          <div class="aspect-video rounded-xl bg-muted/50" />
          <div class="aspect-video rounded-xl bg-muted/50" />
          <div class="aspect-video rounded-xl bg-muted/50" />
        </div>
        <div class="min-h-[100vh] flex-1 rounded-xl bg-muted/50 md:min-h-min" />
      </div>
  </AuthenticatedLayout>
</template>

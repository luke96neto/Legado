<script setup>
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProjectForm from '@/Components/Project/ProjectForm.vue';

const props = defineProps({
  project: Object,
  tags: Array
});

// const tags = ref(props.tags || []);

// const form = useForm({
//   title: props.project.title,
//   description: props.project.description,
//   status: props.project.status,
//   tag_id: props.project.tags?.[0]?.id || '',
//   image: null
// });

function onFileChange(e) {
  form.image = e.target.files[0];
}

function submit(form) {
  form.put(route('project.update', { project: props.project.slug }), {
    // method: 'put',
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

    <!-- <div class="container mx-auto px-4 py-8">
      <form @submit.prevent="submit" enctype="multipart/form-data" class="space-y-6">
        <div>
          <label for="title" class="block text-sm font-medium text-gray-300">Título</label>
          <input
            v-model="form.title"
            type="text"
            id="title"
            class="mt-1 block w-full bg-gray-300 border-gray-300 rounded-md shadow-xs focus:border-blue-500 focus:ring-blue-500"
            :class="{ 'border-red-500': form.errors.title }"
            required
          />
          <p v-if="form.errors.title" class="mt-1 text-sm text-red-500">
            {{ form.errors.title }}
          </p>
        </div>

        <div>
          <label for="description" class="block text-sm font-medium text-gray-300">Descrição</label>
          <textarea
            v-model="form.description"
            id="description"
            class="mt-1 block w-full bg-gray-300 border-gray-300 rounded-md shadow-xs focus:border-blue-500 focus:ring-blue-500"
            :class="{'border-red-500' : form.errors.description}"
            rows="4"
            required>
          </textarea>
          <p v-if="form.errors.description" class="mt-1 text-sm text-red-500">
            {{ form.errors.description }}
          </p>
        </div>

        <div>
          <label for="status" class="block text-sm font-medium text-gray-300">Status</label>
          <select
            v-model="form.status"
            id="status"
            class="mt-1 block w-full bg-gray-300 border-gray-300 rounded-md shadow-xs focus:border-blue-500 focus:ring-blue-500"
          >
            <option value="rascunho">Rascunho</option>
            <option value="em_andamento">Em andamento</option>
            <option value="concluido">Concluído</option>
          </select>
        </div>

        <div>
          <label for="tag_id" class="block text-sm font-medium text-gray-300">Tag</label>
          <select
            v-model="form.tag_id"
            id="tag_id"
            class="mt-1 block w-full bg-gray-300 border-gray-300 rounded-md shadow-xs focus:border-blue-500 focus:ring-blue-500"
          >
            <option v-for="tag in tags" :key="tag.id" :value="tag.id">{{ tag.name }}</option>
          </select>
        </div>

        <div>
          <label for="image" class="block text-sm font-medium text-gray-600 dark:text-black">Imagem do projeto (opcional)</label><br>
          <input
            type="file"
            @change="onFileChange"
            accept="image/*"
            class="block w-full text-sm text-black file:mr-4 file:py-2 file:px-4
            file:rounded-sm file:border-0
            file:text-sm file:font-semibold
            file:bg-purple-600 file:text-white
            hover:file:bg-purple-900
            bg-gray-300 border border-gray-600 rounded-lg cursor-pointer"
            id="image"
          />
          <p class="mt-1 text-xs text-gray-600 dark:text-gray-300" id="file_input_help">PNG, JPG or JPEG (MAX. 10mb).</p>
          <p v-if="form.errors.image" class="mt-1 text-sm text-red-500">
            {{ form.errors.image }}
          </p>
        </div>

        <button
          type="submit"
          class="px-4 py-2 bg-purple-600 text-white rounded-sm hover:bg-purple-900 transition-colors"
          :disabled="form.processing"
        >
          <span v-if="form.processing">Salvando...</span>
          <span v-else>Salvar</span>
        </button>
      </form>
    </div> -->
    <div class="container mx-auto px-4 py-8">
      <ProjectForm :project="props.project" :tags="props.tags" @submit="submit" />
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
// import { ref, onMounted, watch } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const submit = (form) => {
    form.post('store', {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error(errors);
        }
    });
};

import ProjectForm from '@/components/Project/ProjectForm.vue';

</script>

<template>
    <Head title="Projects - create" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-300 dark:text-gray-200">
                Criar Novo Projeto
            </h2>
        </template>

        <div class="container mx-auto px-4 py-8">
            <ProjectForm @submit="submit" />
        </div>
    </AuthenticatedLayout>
</template>

<!-- <template>
    <Head title="Projects - create" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-300 dark:text-gray-200">
                Criar Novo Projeto
            </h2>
        </template>

        <div class="container mx-auto px-4 py-8">
            <form @submit.prevent="submit" class="space-y-6">
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

                <div class="mt-4">
                    <label for="collaborators" class="block text-sm font-medium text-gray-300">
                        Autor(es)
                    </label>
                    <input
                        v-model="collaboratorsInput"
                        type="text"
                        id="collaborators"
                        class="mt-1 block w-full bg-gray-300 border-gray-300 rounded-md shadow-xs focus:border-blue-500 focus:ring-blue-500"
                    >
                    <p v-if="form.errors.authors" class="mt-1 text-sm text-red-500">
                        {{ form.errors.authors }}
                    </p>
                </div>

                <div class="">
                    <label for="img_link" class="block text-sm font-medium text-gray-600 dark:text-black">Imagem do projeto (opcional)</label><br>
                    <input 
                        type="file"
                        @input="form.image = $event.target.files[0]"
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
                
                <div class="flex gap-4 justify-between">
                    <div class="w-full">
                        <label for="repo_url" class="block text-sm font-medium text-gray-300">URL do repositório</label>
                        <input 
                            v-model="form.repo_url"
                            type="url" 
                            id="repo_url"
                            class="mt-1 w-full bg-gray-300 block border-gray-300 rounded-md shadow-xs focus:border-blue-500 focus:ring-blue-500"
                            :class="{ 'border-red-500': form.errors.repo_url }"
                            placeholder="https://github.com/usuario/projeto"
                        >
                        <p v-if="form.errors.repo_url" class="mt-1 text-sm text-red-500">
                            {{ form.errors.repo_url }}
                        </p>
                    </div>
                    <div class="w-full">
                        <label for="select_repo" class="block text-sm font-medium text-gray-300">Selecionar repositório</label>
                        <select 
                            v-model="selectedRepo"
                            id="select_repo"
                            class="mt-1 block w-full bg-gray-300 border-gray-300 rounded-md shadow-xs focus:border-blue-500 focus:ring-blue-500"
                            >
                            <option :value="null">Selecione um repositório</option>
                            <option v-for="repo in repositories" :key="repo.id" :value="repo">
                                {{ repo.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <button 
                    type="submit"
                    class="px-4 py-2 bg-purple-600 text-white rounded-sm hover:bg-purple-900 transition-colors"
                    :disabled="form.processing"
                >
                    <span v-if="form.processing">Enviando...</span>
                    <span v-else>Criar Projeto</span>
                </button>
            </form>
        </div>
    </AuthenticatedLayout>
</template> -->


    

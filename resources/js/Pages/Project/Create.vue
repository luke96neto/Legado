<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    title: '',
    description: '',
    status: 'rascunho',
    image: null,
    repo_url: ''
});

const submit = () => {
    form.post('store', {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error(errors);
        }
    });
};
</script>

<template>
    <Head title="Projects - create" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Criar Novo Projeto
            </h2>
        </template>

        <div class="container mx-auto px-4 py-8">
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-white">Título</label>
                    <input  
                        v-model="form.title"
                        type="text"
                        id="title"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        :class="{ 'border-red-500': form.errors.title }"
                        required 
                    />
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-white">Descrição</label>
                    <textarea
                        v-model="form.description"
                        id="description"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        :class="{'border-red-500' : form.errors.description}"
                        rows="4" 
                        required>
                    </textarea>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-white">Status</label>
                    <select 
                        v-model="form.status"
                        id="status"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="rascunho">Rascunho</option>
                        <option value="em_andamento">Em andamento</option>
                        <option value="concluido">Concluído</option>
                    </select>
                </div>

                <div class="">
                    <label for="img_link" class="block text-sm font-medium text-gray-900 dark:text-white">Imagem do projeto (opcional): </label><br>
                    <input 
                        type="file"
                        @input="form.image = $event.target.files[0]"
                        accept="image/*" 
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" 
                        id="image"
                    />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-300" id="file_input_help">PNG, JPG or JPEG (MAX. 10mb).</p>
                    <p v-if="form.errors.image" class="mt-1 text-sm text-red-500">
                        {{ form.errors.image }}
                    </p>
                </div>
                
                <div>
                    <label for="repo_url" class="block text-sm font-medium text-white">URL do repositório:</label>
                    <input 
                        v-model="form.repo_url"
                        type="url" 
                        id="repo_url"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        :class="{ 'border-red-500': form.errors.repo_url }"
                        placeholder="https://github.com/usuario/projeto"
                    />
                    <p v-if="form.errors.repo_url" class="mt-1 text-sm text-red-500">
                        {{ form.errors.repo_url }}
                    </p>
                </div>

                <button 
                    type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors"
                    :disabled="form.processing"
                >
                    <span v-if="form.processing">Enviando...</span>
                    <span v-else>Criar Projeto</span>
                </button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>


    

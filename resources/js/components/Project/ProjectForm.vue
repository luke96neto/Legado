<script setup>
import { ref, onMounted, watch } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Button } from '@/components/ui/button';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { 
    TagsInput, 
    TagsInputInput, 
    TagsInputItem, 
    TagsInputItemDelete, 
    TagsInputItemText 
} from "@/components/ui/tags-input";

const repositories = ref([]);
const collaborators = ref([]);
const selectedRepo = ref(null);
const loadingCollabs = ref(false);
const collaboratorsInput = ref('');
const isLoading = ref(false);
const editMode = ref(false);
const user = usePage().props.auth.user;
const modelValue = ref([`${user.nickname}`]);

const props = defineProps({
    project: Object | null,
    tags: Array | null,
    onSubmit: Function
});

const loadRepositories = async () => {
    isLoading.value = true;
    try {
        const response = await axios.get('/github/repos');
        repositories.value = response.data;
    } catch (error) {
        console.error('Falha ao carregar os repositorios:', error);
    } finally {
        isLoading.value = false;
    }
};

const loadRepoCollaborators = async (repoFullName) => {
    if (!repoFullName) return;

    const [owner, repo] = repoFullName.split('/');
    loadingCollabs.value = true;

    try {
        const response = await axios.get(`/github/repos/${owner}/${repo}/collaborators`);
        collaborators.value = response.data;
        collaboratorsInput.value = response.data.map(c => c.login).join(', ');
    } catch (error) {
        console.error('Error loading collaborators:', error);
    } finally {
        loadingCollabs.value = false;
    }
};

watch(selectedRepo, (newRepo) => {
    if (newRepo) {
        form.title = newRepo.name;
        form.description = newRepo.description;
        form.repo_url = newRepo.html_url;
        form.authors = collaboratorsInput;
        loadRepoCollaborators(newRepo.full_name);
    }
});

const form = useForm({
    title: props.project?.title,
    description: props.project?.description,
    status: props.project?.status,
    tags: props.project?.tags || [],
    image: null,
    repo_url: props.project?.repo_url || '',
});

const submit = () => {
    props.onSubmit(form);
};

const initForm = () => {
    if (props.project) {
        editMode.value = true;
        collaboratorsInput.value = props.project.authors?.map(author => author.name).join(', ');
    } else {
        editMode.value = false;
        loadRepositories();
        selectedRepo.value = null;
    }
};

console.log(repositories);

onMounted(() => {
    initForm();
    console.log(editMode.value ? 'Edit mode' : 'Create mode');
});

</script>

<template>
    <div class="container max-w-5xl mx-auto px-4 py-8 border border-ring bg-card rounded">
        <form @submit.prevent="submit" class="grid gap-6">
            <div class="flex justify-between gap-4 items-center">
                <div class="grid gap-3 w-full">
                    <Label>Selecionar um repositório</Label>
                    <Select class="w-full">
                        <SelectTrigger clas>
                            <SelectValue placeholder="Selecione um repositório" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel v-if="repositories">repositorio</SelectLabel>
                                <SelectLabel v-else>Sem repositórios</SelectLabel>
                                <SelectItem
                                    v-for="repo in repositories" :key="repo.id" :value="repo"
                                >
                                {{ repositories }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
                <div class="grid gap-3 w-full">
                    <Label for="repo_url" >URL do repositório</Label>
                    <Input
                        id="repo_url"
                        type="url"
                        v-model="form.repo_url"
                        placeholder="https://github.com/usuario/projeto"
                    />
                    <p v-if="form.errors.repo_url" class="mt-1 text-sm text-red-500">
                        {{ form.errors.repo_url }}
                    </p>
                </div>
            </div>
            <div class="w-full">
                <Label for="title" class="pb-2">Título</Label>
                <Input
                    id="title"
                    type="text"
                    v-model="form.title"
                />
                <p v-if="form.errors.title" class="mt-1 text-sm text-red-500">
                    {{ form.errors.title }}
                </p>
            </div>
            <div class="w-full">
                <Label for="descricao" class="pb-2">Descrição</Label>
                <Textarea 
                    class="h-50"
                    id="descricao"
                    type="text"
                    v-model="form.descricao"
                />
                <p v-if="form.errors.descricao" class="mt-1 text-sm text-red-500">
                    {{ form.errors.descricao }}
                </p>
            </div>
            <div class="flex justify-between gap-4">
                <div class="grid gap-3 w-100 ">
                    <Label>Adicionar autores</Label>
                    <TagsInput v-model="modelValue">
                        <TagsInputItem v-for="item in modelValue" :key="item" :value="item">
                            <TagsInputItemText />
                            <TagsInputItemDelete />
                        </TagsInputItem>
                        <TagsInputInput placeholder="autor1, autor2..." />
                    </TagsInput>
                </div>
                <div class="grid gap-3 ">
                    <Label>Selecionar um status</Label>
                    <Select>
                        <SelectTrigger>
                            <SelectValue placeholder="status" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem
                                    v-for="repo in repositories" :key="repo.id" :value="repo"
                                >
                                {{ repositories }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
            </div>
            <div class="flex justify-between gap-4">
                <div class="w-full">
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <Label for="picture">Imagem</Label>
                        <Input id="picture" type="file"/>
                    </div>
                                    <p class="mt-1 text-xs text-foreground" id="file_input_help">PNG, JPG or JPEG (MAX.
                        10mb).
                    </p>
                </div>
                <div class="w-full">
                    <Label class="pb-2">Selecionar tags</Label>
                    <Select>
                        <SelectTrigger>
                            <SelectValue placeholder="tags" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem
                                    v-for="tag in tags" :key="tag.id" :value="tag"
                                >
                                {{ tag.name }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
            </div>
            <Button type="submit"
                class="w-full"
                :disabled="form.processing">
                <span v-if="form.processing">Enviando...</span>
                <span v-else>{{ editMode ? 'Atualizar' : 'Criar' }} Projeto</span>
            </Button>
        </form>
    </div>
</template>

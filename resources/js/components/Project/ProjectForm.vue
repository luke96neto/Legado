<script setup>
import { ref, onMounted, watch } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Button } from '@/components/ui/button';
import { ChevronDown, Check } from 'lucide-vue-next';
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

const user = usePage().props.auth.user;
const repositories = ref([]);
const collaborators = ref([]);
const selectedRepo = ref(null);
const loadingCollabs = ref(false);
const collaboratorsInput = ref([`${user.nickname}`]);
const isLoading = ref(false);
const editMode = ref(false);
const statusInput = ref(['rascunho', 'em_andamento', 'concluido']);
const statusSelected = ref('');
const isTagsDropdownOpen = ref(false);

const props = defineProps({
    project: Object | null,
    tags: Array,
    onSubmit: Function
});

const previewImage = ref(props.project?.image ? `/storage/${props.project.image}` : '');
const isEditing = ref(!!props.project);

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
        collaboratorsInput.value = response.data.map(c => c.login);
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
const selectedTags = ref(props.project?.tags?.map(t => t.name) || ['java', 'vue']);

const form = useForm({
    title: props.project?.title || '',
    description: props.project?.description || '',
    status: props.project?.status || 'rascunho',
    tags: selectedTags.value,
    image: null,
    existing_image: props.project?.image || '',
    repo_url: props.project?.repo_url || '',
    authors: props.project?.authors?.map(a => a.name) || [`${user.nickname}`],
});

const toggleTag = (tagName) => {
    const index = selectedTags.value.indexOf(tagName);
    if (index === -1) {
        selectedTags.value.push(tagName);
    } else {
        selectedTags.value.splice(index, 1);
    }
    form.tags = selectedTags.value;
};

const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.image = file;
        previewImage.value = URL.createObjectURL(file);
    }
};

const submit = () => {
    if (form.tags.length === 0) {
        form.errors.tags = ['Selecione pelo menos uma tag'];
        return;
    }

    if (form.authors.length === 0) {
        form.errors.authors = ['Adicione pelo menos um autor'];
        return;
    }

    if (isEditing.value) {
        form.transform((data) => ({
            ...data,
            _method: 'PUT'
        }));
    }

    props.onSubmit(form);
};

const initForm = () => {
    if (props.project) {
        editMode.value = true;
        collaboratorsInput.value = props.project.authors?.map(author => author.name);
        selectedTags.value = props.project.tags?.map(tag => tag.name) || [];

        form.title = props.project.title;
        form.description = props.project.description;
        form.status = props.project.status;
        form.repo_url = props.project.repo_url;
        form.existing_image = props.project.image;
        form.authors = collaboratorsInput.value;
        form.tags = selectedTags.value;
    } else {
        editMode.value = false;
        loadRepositories();
        selectedRepo.value = null;
    }
};

onMounted(() => {
    initForm();
});

</script>

<template>
    <div class="container max-w-5xl mx-auto px-4 py-8 border border-ring bg-card rounded">
        <form @submit.prevent="submit" class="grid gap-6">
            <div class="flex justify-between gap-4 items-center">
                <div class="grid gap-3 w-full">
                    <Label>Selecionar um repositório</Label>
                    <Select class="w-full" v-model="selectedRepo" id="select_repo" :disabled="isLoading">
                        <SelectTrigger clas>
                            <SelectValue placeholder="Selecione um repositório" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel v-if="repositories">repositórios</SelectLabel>
                                <SelectLabel v-else>Sem repositórios</SelectLabel>
                                <SelectItem v-for="repo in repositories" :key="repo.id" :value="repo">
                                    {{ repo.name }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
                <div class="grid gap-3 w-full">
                    <Label for="repo_url">URL do repositório</Label>
                    <Input id="repo_url" type="url" v-model="form.repo_url" :value="form.repo_url"
                        placeholder="https://github.com/usuario/projeto" />
                    <p v-if="form.errors.repo_url" class="mt-1 text-sm text-red-500">
                        {{ form.errors.repo_url }}
                    </p>
                </div>
            </div>
            <div class="w-full">
                <Label for="title" class="pb-2">Título</Label>
                <Input id="title" type="text" v-model="form.title" />
                <p v-if="form.errors.title" class="mt-1 text-sm text-red-500">
                    {{ form.errors.title }}
                </p>
            </div>
            <div class="w-full">
                <Label for="descricao" class="pb-2">Descrição</Label>
                <Textarea class="h-20" id="descricao" type="text" v-model="form.description" />
                <p v-if="form.errors.description" class="mt-1 text-sm text-red-500">
                    {{ form.errors.description }}
                </p>
            </div>
            <div class="flex justify-between gap-4 items-center">
                <div class="grid gap-3 w-full">
                    <Label>Adicionar autores</Label>
                    <TagsInput v-model="form.authors">
                        <TagsInputItem v-for="item in form.authors" :key="item" :value="item">
                            <TagsInputItemText />
                            <TagsInputItemDelete @click="form.authors.splice(index, 1)" />
                        </TagsInputItem>
                        <TagsInputInput placeholder="Digite um autor e pressione Enter" />
                    </TagsInput>
                </div>
                <div class="w-full relative">
                    <Label class="pb-2">Selecionar tags</Label>
                    <div @click="isTagsDropdownOpen = !isTagsDropdownOpen"
                        class="flex items-center justify-between w-full px-3 py-2 border rounded-md cursor-pointer hover:border-primary">
                        <div class="flex flex-wrap gap-1">
                            <span v-for="tag in selectedTags" :key="tag"
                                class="px-2 py-1 bg-primary text-primary-foreground rounded-full text-xs flex items-center">
                                {{ tag }}
                                <span @click.stop="toggleTag(tag)" class="ml-1 cursor-pointer">×</span>
                            </span>
                            <span v-if="selectedTags.length === 0" class="text-muted-foreground">
                                Selecione as tags...
                            </span>
                        </div>
                        <ChevronDown class="h-4 w-4 opacity-50" />
                    </div>
                    <Transition name="fade">
                        <div v-if="isTagsDropdownOpen" @click.stop
                            class="absolute z-10 w-full mt-1 p-2 bg-popover border rounded-md shadow-lg max-h-60 overflow-auto">
                            <div v-for="tag in props.tags" :key="tag.id" @click="toggleTag(tag.name)"
                                class="px-3 py-2 rounded-md cursor-pointer flex items-center hover:bg-accent"
                                :class="{ 'bg-accent': selectedTags.includes(tag.name) }">
                                <Check v-if="selectedTags.includes(tag.name)" class="h-4 w-4 mr-2 text-primary" />
                                <span class="flex-1">{{ tag.name }}</span>
                            </div>
                        </div>
                    </Transition>
                </div>
            </div>
            <div class="flex justify-between gap-4">
                <div class="w-full">
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <Label for="image">Imagem</Label>

                        <div v-if="previewImage" class="mb-2">
                            <img :src="previewImage" class="h-20 w-auto rounded-md object-cover" />
                        </div>

                        <Input id="image" type="file" @change="handleImageChange" accept="image/*" />
                        <p v-if="form.errors.image" class="mt-1 text-sm text-red-500">
                            {{ form.errors.image }}
                        </p>
                        <p class="mt-1 text-xs text-foreground">
                            PNG, JPG or JPEG (MAX. 10mb).
                        </p>
                    </div>
                </div>
                <div class="grid gap-3 w-full">
                    <Label>Selecionar um status</Label>
                    <Select v-model="form.status">
                        <SelectTrigger>
                            <SelectValue placeholder="Selecione um status" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem v-for="(status, index) in statusInput" :key="index" :value="status">
                                    <p v-if="status == 'em_andamento'">
                                        Em andamento
                                    </p>
                                    <p v-else>
                                        {{ status }}
                                    </p>
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <p v-if="form.errors.status" class="mt-1 text-sm text-red-500">
                        {{ form.errors.status }}
                    </p>
                </div>
            </div>
            <Button type="submit" class="w-full" :disabled="form.processing">
                <span v-if="form.processing">
                    <Loader2 class="h-4 w-4 animate-spin mr-2" />
                    Processando...
                </span>
                <span v-else>{{ editMode ? 'Atualizar' : 'Criar' }} Projeto</span>
            </Button>
        </form>
    </div>
</template>
<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s, transform 0.2s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
</style>

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
			<div class="flex items-center justify-between">
				<Link :href="route('project.index')"
					class="flex items-center text-sm text-primary hover:text-primary/80">
				<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
					stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
					<path d="m12 19-7-7 7-7" />
					<path d="M19 12H5" />
				</svg>
				Voltar
				</Link>
				<h2 class="text-xl font-semibold leading-tight text-center flex-1">
					Editar Projeto
				</h2>
				<div class="w-20"></div>
			</div>
		</template>

		<div class="container mx-auto px-4 py-8">
			<ProjectForm :project="props.project" :tags="props.tags" @submit="submit" />
		</div>
	</AuthenticatedLayout>
</template>

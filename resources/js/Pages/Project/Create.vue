<script setup>
// import { ref, onMounted, watch } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

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

        <div class="container mx-auto px-4 py-8">
            <ProjectForm @submit="submit" />
        </div>
    </AuthenticatedLayout>
</template>
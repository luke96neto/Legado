<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    favoritedProjects: Object,
});

const user = usePage().props.auth.user;
console.log(user.image);

</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Profile
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-4 shadow-sm sm:rounded-lg sm:p-8 dark:bg-gray-800"
                >
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>
                <div
                    class="bg-white dark:bg-gray-800 p-4 shadow-sm sm:rounded-lg sm:p-8"
                >
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                Projetos favoritos
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Todos os projetos no qual você favoritou.
                            </p>
                        </header>
                        <div class="w-full">
                            <label for="select_repo" class="block text-sm font-medium text-gray-300">Selecionar repositório</label>
                            <select 
                                class="mt-1 block w-full bg-gray-300 border-gray-300 rounded-md shadow-xs focus:border-blue-500 focus:ring-blue-500"
                                >
                                <option>Seus projetos favoritados:</option>
                                <option v-for="project in favoritedProjects" :key="project.id">
                                    {{ project.title }}
                                </option>
                            </select>
                        </div>
                    </section>

                </div>

                <div
                    class="bg-white dark:bg-gray-800 p-4 shadow-sm sm:rounded-lg sm:p-8"
                >
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div
                    class="bg-black p-4 shadow-sm sm:rounded-lg sm:p-8 dark:bg-gray-800"
                >
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

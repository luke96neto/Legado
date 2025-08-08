<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    nickname: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <div class="bg-gray-900 p-8 rounded-sm shadow-sm w-full max-w-md">

            <img src="/img/logo-legado-wname.png" alt="Logo" class="mx-auto mb-6 w-24 h-auto" />

            <h1 class="text-2xl text-white font-bold text-center mb-4">Registro</h1>

            <form @submit.prevent="submit">
                <div class="mt-4">
                    <InputLabel for="name" value="Name" />

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="(Not compulsory)"
                        />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-4">
                    <InputLabel for="nickname" value="Nickname" />

                    <TextInput
                        id="nickname"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.nickname"
                        required
                        autofocus
                        autocomplete="nickname"
                        placeholder="Nickname"
                    />

                    <InputError class="mt-2" :message="form.errors.nickname" />
                </div>

                <div class="mt-4">
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                        placeholder="Email"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" />

                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                        placeholder="Password"
                    />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mt-4">
                    <InputLabel
                        for="password_confirmation"
                        value="Confirm Password"
                    />

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Confirm Password"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.password_confirmation"
                    />
                </div>

                <div class="mt-4 flex items-center justify-end gap-4">
                    <Link
                        :href="route('login')"
                        class="rounded-md text-sm text-gray-400 underline hover:text-gray-800 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Already registered?
                    </Link>
                
                    <Button
                        class="w-20 bg-purple-600 hover:bg-purple-700 py-2 rounded-sm font-semibold text-white disabled:opacity-50"
                        :disabled="form.processing"
                    >
                        Register
                    </Button>
                </div>
            </form>
        </div>    
    </GuestLayout>
</template>

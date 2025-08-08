<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
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
        <img src="/img/globo-Legado.png" alt="Logo" class="mx-auto mb-6 w-[180px] h-auto" />
        <div>
            <a :href="route('github.login')" class="border w-full block text-center bg-black text-white py-2 rounded-sm mb-2">
                <i class="fa-brands fa-github"></i>
                Cadastre-se com o GitHub
            </a>
            <a :href="route('google.login')" class="w-full block text-center bg-white text-black py-2 rounded-sm">
                <i class="fa-brands fa-google"></i>
                Cadastre-se com o Google
            </a>
        </div>
        <div class="text-white flex gap-1 items-center m-2">
            <div class="bg-gray-500 w-full h-[0.1px]"/>
            <p>ou</p>
            <div class="bg-gray-500 w-full h-[0.1px]"/>
        </div>
        <form @submit.prevent="submit">
            <div class="mt-4">
                <InputLabel for="nickname" value="Apelido" />
                <TextInput
                    id="nickname"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.nickname"
                    required
                    autofocus
                    autocomplete="nickname"
                    placeholder="Apelido"
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
                <InputLabel for="password" value="Senha" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    placeholder="Senha"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirmar senha"
                />
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Confirme a senha"
                />
                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <Button
                class="w-full mt-4 bg-purple-600 hover:bg-purple-700 py-2 rounded-sm font-semibold text-white disabled:opacity-50"
                :disabled="form.processing"
            >
                Registrar
            </Button>
            <div class="text-center mt-4 text-sm text-gray-400">
                Já possui uma conta?
                <Link :href="route('login')" class="text-purple-400 hover:underline">Entrar</Link>
            </div>
        </form>
    </GuestLayout>
</template>

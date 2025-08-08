<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
}); 

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <GuestLayout>
    <div class="bg-gray-900 p-8 rounded-sm shadow-sm w-full max-w-md">

      <img src="/img/logo-legado-wname.png" alt="Logo" class="mx-auto mb-6 w-24 h-auto" />

      <h1 class="text-2xl text-white font-bold text-center mb-4">Login</h1>

      <a :href="route('github.login')" class="w-full block text-center bg-black text-white py-2 rounded-sm mb-2">Continuar com GitHub</a>
      <a :href="route('google.login')" class="w-full block text-center bg-white text-black py-2 rounded-sm mb-4">Continuar com Google</a>

      <!-- Formulário -->
      <form @submit.prevent="submit">
        <input 
          v-model="form.email"
          type="email"
          placeholder="Email"
          class="w-full bg-gray-800 border border-gray-700 rounded-sm px-3 py-2 mb-1 text-white"
        />
        <InputError :message="form.errors.email" class="mb-2 text-red-400 text-sm" />

        <div class="py-1"></div>

        <input
          v-model="form.password"
          type="password"
          placeholder="Senha"
          class="w-full bg-gray-800 border border-gray-700 rounded-sm px-3 py-2 mb-1 text-white"
        />
        <InputError :message="form.errors.password" class="mb-2 text-red-400 text-sm" />

        <div class="py-2"></div>

        <button
          type="submit"
          class="w-full bg-purple-600 hover:bg-purple-700 py-2 rounded-sm font-semibold text-white disabled:opacity-50"
          :disabled="form.processing"
        >
          Entrar
        </button>
      </form>

      <!-- Link para registro -->
      <div class="text-center mt-4 text-sm text-gray-400">
        Não tem uma conta?
        <Link :href="route('register')" class="text-purple-400 hover:underline">Criar conta</Link>
      </div>
    </div>
  </GuestLayout>
</template>

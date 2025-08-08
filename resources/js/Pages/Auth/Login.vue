<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

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
    <img src="/img/globo-Legado.png" alt="Logo" class="mx-auto mb-6 w-[180px] h-auto" />
    <a :href="route('github.login')" class="border w-full block text-center bg-black text-white py-2 rounded-sm mb-2">
      <i class="fa-brands fa-github"></i>
      Continuar com GitHub
    </a>
    <a :href="route('google.login')" class="w-full block text-center bg-white text-black py-2 rounded-sm">
      <i class="fa-brands fa-google"></i>
      Continuar com Google
    </a>
    <div class="text-white flex gap-1 items-center m-2">
      <div class="bg-gray-500 w-full h-[0.1px]"></div>
      <p>ou</p>
      <div class="bg-gray-500 w-full h-[0.1px]"></div>
    </div>
    <form class="text-white" @submit.prevent="submit">
      <div class="mt">
        <InputLabel for="email" value="Email" />
        <TextInput
          id="email"
          type="email"
          class="w-full bg-gray-900 border border-gray-700 rounded-sm px-3 py-2 mb-1 text-white"
          v-model="form.email"
          placeholder="dominio@email.com"
          required
          />
        <InputError class="mt-2" :message="form.errors.email" />
      </div>
      <div class="mt-4">
        <InputLabel for="password" value="Senha" />
        <TextInput
          id="password"
          type="password"
          class="w-full bg-gray-900 border border-gray-700 rounded-sm px-3 py-2 mb-1"
          v-model="form.password"
          placeholder="Senha"
          required
        />
        <InputError :message="form.errors.password" class="mb-2 text-red-400 text-sm" />
      </div>
      <button
        type="submit"
        class="w-full mt-4 bg-purple-600 hover:bg-purple-700 py-2 rounded-sm font-semibold text-white disabled:opacity-50"
        :disabled="form.processing"
        >
        Entrar
    </button>
    </form>
    <div class="text-center mt-4 text-sm text-gray-400">
      Não possui uma conta?
      <Link :href="route('register')" class="text-purple-400 hover:underline">Criar conta</Link>
    </div>
  </GuestLayout>
</template>

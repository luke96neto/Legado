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
      <div class="">
        <label>
          Email
          <input 
            v-model="form.email"
            type="email"
            placeholder="dominio@email.com"
            class="w-full bg-gray-900 border border-gray-700 rounded-sm px-3 py-2 mb-1 text-white"
          />
          <InputError :message="form.errors.email" class="mb-2 text-red-400 text-sm" />
        </label>
      </div>
      <div class="">
        <label>
          Senha
          <input
            v-model="form.password"
            type="password"
            placeholder="Senha"
            class="w-full bg-gray-900 border border-gray-700 rounded-sm px-3 py-2 mb-1"
          />
          <InputError :message="form.errors.password" class="mb-2 text-red-400 text-sm" />
        </label>
      </div>
      <button
        type="submit"
        class="w-full mt-4 bg-purple-600 hover:bg-purple-700 py-2 rounded-sm font-semibold text-white disabled:opacity-50"
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
  </GuestLayout>
</template>

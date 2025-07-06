<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <<div class="min-h-screen bg-gray-950 flex items-center justify-center px-4">
    <div class="bg-gray-900 p-8 rounded shadow w-full max-w-md">

        <!-- Logo -->
      <img src="/img/logo-legado-wname.png" alt="Logo" class="mx-auto mb-6 w-24 h-auto" />

      
      <h1 class="text-2xl text-white font-bold text-center mb-4">Login</h1>

      <a :href="route('github.login')" class="w-full block text-center bg-black text-white py-2 rounded mb-2">continuar com  GitHub</a>
      <a :href="route('google.login')" class="w-full block text-center bg-white text-black py-2 rounded mb-4">continuar com  Google</a>

      <input type="email" placeholder="Email" class="w-full bg-gray-800 border border-gray-700 rounded px-3 py-2 mb-2" />
      <input type="password" placeholder="Senha" class="w-full bg-gray-800 border border-gray-700 rounded px-3 py-2 mb-4" />

      <button class="w-full bg-purple-600 hover:bg-purple-700 py-2 rounded font-semibold">Entrar</button>

      <div class="text-center mt-4 text-sm text-gray-400">
        Não tem uma conta?
        <Link :href="route('register')" class="text-purple-400 hover:underline">Criar conta</Link>
      </div>
    </div>
  </div>
</template>

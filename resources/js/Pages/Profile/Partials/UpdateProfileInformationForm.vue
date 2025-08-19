<script setup>
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Avatar, AvatarImage, AvatarFallback } from '@/components/ui/avatar';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const previewImage = ref(null);
const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    nickname: user.nickname,
    image: null,
});

const handleImageChange = (e) => {
    const file = e.target.files[0];
    form.image = file;
    
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    form.transform((data) => ({
        ...data,
        _method: 'patch'
    })).post(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.image = null;
            previewImage.value = null;
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-foreground">
                Informações do Perfil
            </h2>

            <p class="mt-1 text-sm text-muted-foreground">
                Atualize as informações do seu perfil e endereço de e-mail.
            </p>
        </header>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <!-- Seção da Imagem de Perfil -->
            <div class="space-y-2">
                <InputLabel for="image" value="Foto de Perfil" />
                
                <div class="relative inline-block group">
                    <Avatar class="w-24 h-24">
                        <AvatarImage 
                            :src="previewImage || (user.image ? '/storage/' + user.image : '')" 
                            class="object-cover"
                        />
                        <AvatarFallback class="bg-card text-xl">
                            {{ user.name?.charAt(0) || user.nickname?.charAt(0) || 'U' }}
                        </AvatarFallback>
                    </Avatar>
                    
                    <label 
                        for="image-upload"
                        class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 rounded-full transition-opacity duration-200 cursor-pointer"
                    >
                        <span class="text-white text-sm font-medium">Alterar</span>
                    </label>
                    
                    <input 
                        id="image-upload"
                        type="file"
                        @change="handleImageChange"
                        accept="image/*"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                    />
                </div>
                
                <p class="text-xs text-muted-foreground mt-1">
                    Clique na imagem para alterar sua foto de perfil
                </p>
                
                <InputError class="mt-2" :message="form.errors.image" />
            </div>

            <!-- Campos do formulário -->
            <div>
                <InputLabel for="name" value="Nome" />
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="nickname" value="Apelido" />
                <TextInput
                    id="nickname"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.nickname"
                    required
                    autocomplete="nickname"
                />
                <InputError class="mt-2" :message="form.errors.nickname" />
            </div>

            <!-- Verificação de e-mail -->
            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-foreground">
                    Seu endereço de e-mail não foi verificado.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="text-sm text-primary underline hover:text-primary/80"
                    >
                        Clique aqui para reenviar o e-mail de verificação.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-600"
                >
                    Um novo link de verificação foi enviado para seu e-mail.
                </div>
            </div>

            <!-- Botões de ação -->
            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">
                    Salvar
                </PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-muted-foreground"
                    >
                        Salvo.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
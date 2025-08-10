<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link
        :href="href"
        class="block w-full px-4 py-2 text-start text-sm leading-5 text-foreground transition duration-150 ease-in-out hover:text-foreground/80 focus:bg-foreground/80 focus:outline-hidden"
    >
        <slot />
    </Link>
</template>

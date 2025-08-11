<script setup>
const props = defineProps({
  title: String,
  image: String,
  description: String,
  link: String,
  status: String,
  tags: Array,
  averageRating: Number,
  fallback: {
    type: String,
    default: '/default.png'
  }
});
</script>

<template>
  <a
    :href="link"
    class="relative block rounded-xl overflow-hidden shadow-lg cursor-pointer group bg-gray-800"
    :aria-label="title || 'Card sem título'"
  >
    <figure class="relative w-full h-48">
      <img
        :src="image ? `/storage/${image}` : fallback"
        :alt="title || 'Imagem padrão do card'"
        loading="lazy"
        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
      />
      <div
        v-if="!image"
        class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center text-gray-300 font-semibold"
      >
        Sem imagem
      </div>
      <span
        class="absolute top-2 left-2 bg-green-600 text-white text-xs px-2 py-1 rounded-full"
        v-if="status"
      >
        {{ status }}
      </span>
    </figure>

    <!-- Conteúdo básico -->
    <figcaption class="p-4 text-white">
      <h3 class="text-lg font-semibold mb-1 line-clamp-2">{{ title }}</h3>
      <p v-if="description" class="text-sm text-gray-300 line-clamp-3">{{ description }}</p>
    </figcaption>

    <!-- Overlay com mais informações ao hover -->
    <div
      class="absolute inset-0 bg-black bg-opacity-90 text-white p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-between"
      style="backdrop-filter: blur(6px);"
    >
      <div>
        <h3 class="text-lg font-bold mb-2">{{ title }}</h3>
        <p class="text-sm mb-3">{{ description }}</p>
        <div>
          <span class="font-semibold">Tags: </span>
          <template v-if="tags && tags.length">
            <span
              v-for="tag in tags"
              :key="tag.id"
              class="inline-block text-xs px-2 py-0.5 mr-1 rounded"
              :style="{
                backgroundColor: `${tag.color}33`,
                color: tag.color
              }"
            >
              {{ tag.name }}
            </span>
          </template>
          <span v-else class="text-gray-400">Sem tags</span>
        </div>
      </div>
      <div class="flex justify-between items-center mt-4">
        <span class="text-yellow-400 font-semibold">
          {{ averageRating ? (Math.round(averageRating * 10) / 10) + ' ★' : 'Sem avaliações' }}
        </span>
        <span class="text-sm text-gray-300 italic">Clique para ver mais</span>
      </div>
    </div>
  </a>
</template>

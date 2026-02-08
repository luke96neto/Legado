<script setup>
import { usePage, Link } from '@inertiajs/vue3';

const props = defineProps({
	title: String,
	image: String,
	description: String,
	link: String,
	status: String,
	tags: Array,
	slug: String,
	ownerId: Number,
	averageRating: Number,
	fallback: {
		type: String,
		default: 'default-project-image.png'
	}
});

const user = usePage().props.auth.user;

function isAuthor(project) {
    if (!user) return false;
    return props.ownerId === user.id;
}

</script>

<template>
	<a
		:href="link"
		class="relative block rounded-xl overflow-hidden text-foreground shadow-lg cursor-pointer group bg-card"
		:aria-label="title || 'Card sem título'"
	>
		<figure class="relative w-full h-48">
			<img
				:src="image ? `/storage/${image}` : `/storage/project-images/${fallback}`"
				:alt="title || 'Imagem padrão do card'"
				loading="lazy"
				class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
			/>
			<div
				v-if="!image"
				class="absolute inset-0 bg-secondary/70 flex items-center justify-center text-foreground/30 font-semibold"
			>
				Sem imagem
			</div>
			<div
				v-if="status"
				>
				<span
					class="absolute top-2 left-2 bg-chart-4 text-background font-semibold text-xs px-2 py-1 rounded-full"
				>
					<p v-if="status == `rascunho`">
						Rascunho
					</p>
					<p v-else-if="status == `em_andamento`">
						Em andamento
					</p>
					<p v-else>
						Concluído
					</p>
				</span>
			</div>
		</figure>

		<!-- Conteúdo básico -->
		<figcaption class="p-4 text-foreground">
			<h3 class="text-lg font-semibold mb-1 line-clamp-2">{{ title }}</h3>
			<p v-if="description" class="text-sm text-foreground/70 line-clamp-3">{{ description }}</p>
		</figcaption>

		<!-- Overlay com mais informações ao hover -->
		<div
			class="absolute inset-0 bg-background/95 text-foreground p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-between"
			style="backdrop-filter: blur(6px);"
		>
			<div>
				<h3 class="text-lg font-bold mb-2">{{ title }}</h3>
				<p class="text-sm mb-3 max-h-30 overflow-hidden">{{ description }}</p>
				<div>
					<span class="font-semibold">Tags: </span>
					<template v-if="tags && tags.length">
						<span
							v-for="tag in tags"
							:key="tag.id"
							class="inline-block text-xs px-2 py-0.5 font-bold mr-1 rounded"
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
				<span class="text-chart-4 font-semibold">
					{{ averageRating ? (Math.round(averageRating * 10) / 10) + ' ★' : 'Sem avaliações' }}
				</span>
				<div>
					<div v-if="isAuthor(project)" class="mt-4 px-6 pb-4">
						<Link :href="route('project.edit', slug)"
							class="inline-flex items-center px-3 py-1 bg-chart-1 text-white rounded hover:bg-chart-1/70 hover:text-white/70 transition-colors">
							Editar
						</Link>
					</div>
					<span v-else class="text-sm text-muted-foreground italic">Clique para ver mais</span>
				</div>
			</div>
		</div>
	</a>
</template>

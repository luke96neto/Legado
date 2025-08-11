<script setup>
import { cn } from "@/lib/utils";
import {
	Card,
	CardContent,
	CardDescription,
	CardHeader,
	CardTitle,
} from '@/components/ui/card';
import { Link } from '@inertiajs/vue3';
import {
	HoverCard,
	HoverCardContent,
	HoverCardTrigger,
} from '@/components/ui/hover-card';

const props = defineProps({
	class: { type: null, required: false },
	project: Object
});

const formatDate = (dateString) => {
	const date = new Date(dateString);
	return ('0' + date.getDate()).slice(-2) + '/' + ('0' + (date.getMonth()+1)).slice(-2); 
};

</script>
<template>
	<Link :href="route('project.show', project.slug )" :class="cn('flex flex-col gap-6', props.class)">
		<Card>
			<CardHeader>
				<CardTitle class="text-xl"> {{ project.title }} </CardTitle>
				<CardDescription class="overflow-hidden max-h-10">
						{{ project.description }}
				</CardDescription>
			</CardHeader>
			<CardContent>
				<div class="text-muted-foreground flex space-x-2 text-sm">
					<div class="flex w-full relative justify-between overflow-hidden">
						<HoverCard>
							<div class="absolute inset-y-0 right-0 w-25 bg-gradient-to-l from-card to-transparent z-10 pointer-events-none"></div>
							<HoverCardTrigger class="flex space-x-3 overflow-x-auto pb-2 -mb-2 hide-scrollbar">
							<div v-for="tag in project.tags" :key="tag.id" class="flex items-center shrink-0">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
								viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
								stroke-linecap="round" stroke-linejoin="round"
								class="lucide lucide-circle mr-1 h-3 w-3"
								:style="{ fill: tag.color, color: tag.color }">
								<circle cx="12" cy="12" r="10"></circle>
								</svg>
								{{ tag.name }}
							</div>
						</HoverCardTrigger>
							<HoverCardContent>
								<div v-for="tag in project.tags" :key="tag.id" class="flex items-center">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
									viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
									stroke-linecap="round" stroke-linejoin="round"
									class="lucide lucide-circle mr-1 h-3 w-3"
									:style="{ fill: tag.color, color: tag.color }">
									<circle cx="12" cy="12" r="10"></circle>
									</svg>
									{{ tag.name }}
								</div>
							</HoverCardContent>
						</HoverCard>
					</div>
					
					<div class="flex items-center">
					<i class="fa-regular fa-bookmark"></i>
					{{ project.favorited_by_count }}
					</div>
					<div>{{ formatDate(project.created_at) }}</div>
				</div>
			</CardContent>
		</Card>
	</Link>
</template>

<style>
.hide-scrollbar {
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none; /* IE/Edge */
}
.hide-scrollbar::-webkit-scrollbar {
  display: none; /* Chrome/Safari/Opera */
}
</style>

<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/components/ApplicationLogo.vue";
import Dropdown from "@/components/Dropdown.vue";
import DropdownLink from "@/components/DropdownLink.vue";
import NavLink from "@/components/NavLink.vue";
import ResponsiveNavLink from "@/components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { Switch } from '@/components/ui/switch'
import { useDark, useToggle } from "@vueuse/core";



const isDark = useDark();
const toggleDark = useToggle(isDark);
const showingNavigationDropdown = ref(false);

</script>

<template>
	<div>
		<div class="min-h-screen bg-background">
			<nav class="border-b bg-sidebar">
				<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
					<div class="flex h-16 justify-between">
						<div class="flex">
							<div class="flex shrink-3 items-center">
								<Link :href="route('dashboard')">
								<img src="/img/globo-Legado.png"
									class="block h-12 w-auto fill-current top-0 left-0 z-30 p-0" />
								</Link>
							</div>

							<!-- Navigation Links -->
							<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
								<NavLink :href="route('dashboard')" :active="route().current('dashboard')">
									Dashboard
								</NavLink>
								<NavLink :href="route('project.index')" :active="route().current('project.index')">
									Projects
								</NavLink>
							</div>
						</div>
						<div class="sm:ms-6 sm:flex sm:items-center space-x-4">
							<div class="hidden sm:ms-6 sm:flex sm:items-center gap-2">
								<Switch :model-value="isDark" @update:model-value="toggleDark">
									<template #thumb>
										<svg v-if="isDark" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
											viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
											stroke-linecap="round" stroke-linejoin="round"
											class="lucide lucide-moon size-3">
											<path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
										</svg>
										<svg v-else xmlns="http://www.w3.org/2000/svg" width="24" height="24"
											viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
											stroke-linecap="round" stroke-linejoin="round"
											class="lucide lucide-sun size-3">
											<circle cx="12" cy="12" r="4"></circle>
											<path d="M12 2v2"></path>
											<path d="M12 20v2"></path>
											<path d="m4.93 4.93 1.41 1.41"></path>
											<path d="m17.66 17.66 1.41 1.41"></path>
											<path d="M2 12h2"></path>
											<path d="M20 12h2"></path>
											<path d="m6.34 17.66-1.41 1.41"></path>
											<path d="m19.07 4.93-1.41 1.41"></path>
										</svg>
									</template>
								</Switch>
								<div class="relative ms-3">
									<Dropdown align="right" width="48">
										<template #trigger>
											<span class="inline-flex rounded-md">
												<button type="button"
													class="inline-flex items-center rounded-md border px-3 py-2 text-sm font-medium leading-4 transition duration-150 ease-in-out bg-background hover:bg-foreground/30 border-input">
													{{ $page.props.auth.user.nickname }}

													<svg class="-me-0.5 ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
														viewBox="0 0 20 20" fill="currentColor">
														<path fill-rule="evenodd"
															d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
															clip-rule="evenodd" />
													</svg>
												</button>
											</span>
										</template>
										<template #content>
											<DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
											<DropdownLink :href="route('logout')" method="post" as="button">
												Log Out
											</DropdownLink>
										</template>
									</Dropdown>
								</div>
								<Avatar>
									<AvatarImage :src="'/storage/' + $page.props.auth.user.image" alt="@unovue" />
									<AvatarFallback>Profile image</AvatarFallback>
								</Avatar>
							</div>
							<div class="-me-2 flex items-center sm:hidden">
								<button @click="showingNavigationDropdown = !showingNavigationDropdown"
									class="inline-flex items-center justify-center rounded-md p-2 transition duration-150 ease-in-out focus:outline-hidden hover:bg-primary/90 hover:text-white focus:bg-white focus:text-white">
									<svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
										<path :class="{
											hidden: showingNavigationDropdown,
											'inline-flex': !showingNavigationDropdown,
										}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
										<path :class="{
											hidden: !showingNavigationDropdown,
											'inline-flex': showingNavigationDropdown,
										}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
									</svg>
								</button>
								<Avatar>
									<AvatarImage :src="'/storage/' + $page.props.auth.user.image" alt="@unovue" />
									<AvatarFallback>Profile image</AvatarFallback>
								</Avatar>
							</div>
						</div>
					</div>
				</div>

				<!-- Responsive Navigation Menu -->
				<div :class="{
					block: showingNavigationDropdown,
					hidden: !showingNavigationDropdown,
				}" class="sm:hidden">
					<div class="space-y-1 pb-3 pt-2">
						<ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
							Dashboard
						</ResponsiveNavLink>
						<ResponsiveNavLink :href="route('project.index')" :active="route().current('project.index')">
							Projects
						</ResponsiveNavLink>
					</div>

					<!-- Responsive Settings Options -->
					<div class="border-t pb-1 pt-4 border-gray-600">
						<div class="px-4">
							<div class="text-base font-medium text-gray-200">
								{{ $page.props.auth.user.nickname }}
							</div>
							<div class="text-sm font-medium text-white">
								{{ $page.props.auth.user.email }}
							</div>
						</div>

						<div class="mt-3 space-y-1">
							<ResponsiveNavLink :href="route('profile.edit')">
								Profile
							</ResponsiveNavLink>
							<ResponsiveNavLink :href="route('logout')" method="post" as="button">
								Log Out
							</ResponsiveNavLink>
						</div>
					</div>
				</div>
			</nav>

			<!-- Page Heading -->
			<header class="shadow-sm bg-gray-800" v-if="$slots.header">
				<div class="mx-auto max-w-7xl px-4 py-2 sm:px-4 lg:px-6">
					<slot name="header" />
				</div>
			</header>

			<!-- Page Content -->
			<main>
				<slot />
			</main>
		</div>
	</div>
</template>
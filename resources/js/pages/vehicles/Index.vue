<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';

import { CircleDot, ChevronRightIcon, Search, CircleX } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import {
  Item,
  ItemActions,
  ItemContent,
  ItemDescription,
  ItemTitle,
} from '@/components/ui/item'
import { ref, computed } from 'vue'
import { InputGroup, InputGroupAddon, InputGroupButton, InputGroupInput, InputGroupText, InputGroupTextarea } from '@/components/ui/input-group'

import { can } from '@/lib/can';

interface Props {
    vehicles: Array<any>;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Vehicles',
        href: '/vehicles',
    },
];

const searchQuery = ref('')

const filteredVehicles = computed(() => {
  if (!searchQuery.value) return props.vehicles
  
  const query = searchQuery.value.toLowerCase()
  return props.vehicles.filter(vehicle => 
    vehicle.license_plate?.toLowerCase().includes(query) ||
    vehicle.description?.toLowerCase().includes(query)
  )
})

</script>

<template>

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto flex h-full w-full max-w-6xl flex-1 flex-col p-4">

            <Heading title="Vehicles" description="List of your vehicles.">
                <Link href="/vehicles/create" v-if="can('vehicles.create')">
                    <Button variant="outline" size="sm">Create</Button>
                </Link>
            </Heading>

            <div class="grid gap-3 text-gray-500 mb-8">
                <InputGroup>
                    <InputGroupInput placeholder="Search..." v-model="searchQuery"/>
                    <InputGroupAddon>
                        <Search />
                    </InputGroupAddon>
                    <InputGroupAddon align="inline-end">
                        <InputGroupButton aria-label="Clear" title="Clear" size="sm" @click="searchQuery = ''">
                            <CircleX />
                        </InputGroupButton>
                    </InputGroupAddon>
                </InputGroup>
                <div class="text-sm">
                    Showing {{ filteredVehicles.length }} of {{ vehicles.length }} vehicles
                </div>
            </div>

            <div class="grid gap-2">
                <Item variant="outline" v-for="vehicle in filteredVehicles" :key="vehicle.id" as-child>
                    <Link :href="`/vehicles/${vehicle.id}`">
                        <CircleDot v-if="vehicle.status == 'active'" color="green" :size="10"/>
                        <CircleDot v-if="vehicle.status != 'active'" color="orange" :size="10"/>
                        <ItemContent>
                            <ItemTitle>{{ vehicle.license_plate }}</ItemTitle>
                            <ItemDescription>{{ vehicle.description }}</ItemDescription>
                        </ItemContent>
                        <ItemActions>
                            <ChevronRightIcon class="size-4" />
                        </ItemActions>
                    </Link>
                </Item>

                <div v-if="filteredVehicles.length === 0" class="text-center py-8 text-gray-500">
                    No vehicles found
                </div>
            </div>
        </div>
    </AppLayout>
</template>

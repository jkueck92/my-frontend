<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';

import { CircleDot, ChevronRightIcon, Search, CircleX } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import {
  Item,
  ItemActions,
  ItemContent,
  ItemTitle,
} from '@/components/ui/item'
import { ref, computed } from 'vue'
import { InputGroup, InputGroupAddon, InputGroupButton, InputGroupInput, InputGroupText, InputGroupTextarea } from '@/components/ui/input-group'

interface Props {
    roles: Array<any>;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Roles',
        href: '/roles',
    },
];

const searchQuery = ref('')

const filteredRoles = computed(() => {
  if (!searchQuery.value) return props.roles
  
  const query = searchQuery.value.toLowerCase()
  return props.roles.filter(role => 
    role.name?.toLowerCase().includes(query)
  )
})

</script>

<template>

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto flex h-full w-full max-w-6xl flex-1 flex-col p-4">

            <Heading title="Roles" description="List of your roles.">
                <Link href="/roles/create">
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
                    Showing {{ filteredRoles.length }} of {{ roles.length }} roles
                </div>
            </div>

            <div class="grid gap-2">
                <Item variant="outline" v-for="role in filteredRoles" :key="role.id" as-child>
                    <Link :href="`/roles/${role.id}`">
                        <CircleDot v-if="role.status == 'active'" color="green" :size="10"/>
                        <CircleDot v-if="role.status != 'active'" color="orange" :size="10"/>
                        <ItemContent>
                            <ItemTitle>{{ role.name }}</ItemTitle>
                        </ItemContent>
                        <ItemActions>
                            <ChevronRightIcon class="size-4" />
                        </ItemActions>
                    </Link>
                </Item>

                <div v-if="filteredRoles.length === 0" class="text-center py-8 text-gray-500">
                    No roles found.
                </div>
            </div>
        </div>
    </AppLayout>
</template>

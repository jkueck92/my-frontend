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

interface Props {
    users: Array<any>;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Users',
        href: '/users',
    },
];

const searchQuery = ref('')

const filteredUsers = computed(() => {
  if (!searchQuery.value) return props.users
  
  const query = searchQuery.value.toLowerCase()
  return props.users.filter(user => 
    user.name?.toLowerCase().includes(query) ||
    user.email?.toLowerCase().includes(query)
  )
})

</script>

<template>

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto flex h-full w-full max-w-6xl flex-1 flex-col p-4">

            <Heading title="Users" description="List of your users.">
                <Link href="/users/create">
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
                    Showing {{ filteredUsers.length }} of {{ users.length }} users
                </div>
            </div>

            <div class="grid gap-2">
                <Item variant="outline" v-for="user in filteredUsers" :key="user.id" as-child>
                    <Link :href="`/users/${user.id}`">
                        <CircleDot v-if="user.status == 'active'" color="green" :size="10"/>
                        <CircleDot v-if="user.status != 'active'" color="orange" :size="10"/>
                        <ItemContent>
                            <ItemTitle>{{ user.name }}</ItemTitle>
                            <ItemDescription>{{ user.email }}</ItemDescription>
                        </ItemContent>
                        <ItemActions>
                            <ChevronRightIcon class="size-4" />
                        </ItemActions>
                    </Link>
                </Item>

                <div v-if="filteredUsers.length === 0" class="text-center py-8 text-gray-500">
                    No users found.
                </div>
            </div>
        </div>
    </AppLayout>
</template>

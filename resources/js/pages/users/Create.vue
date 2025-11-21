<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Form, Link} from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Spinner } from '@/components/ui/spinner'

import UserController from '@/actions/App/Http/Controllers/UserController';

import { Field, FieldDescription, FieldGroup, FieldLabel, FieldSet } from '@/components/ui/field'

import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'

import { can } from '@/lib/can';

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
        title: 'Users',
        href: '/users',
    },
    {        
        title: 'Create User',
        href: '/users/create',
    }
];
</script>

<template>

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto flex h-full w-full max-w-6xl flex-1 flex-col p-4">

            <Heading title="Users" description="Create a new user."/>

            <Form v-bind="UserController.store.form()" reset-on-success v-slot="{ errors, processing }">
                <FieldGroup>
                    <FieldSet>
                        <FieldGroup>
                            <Field>
                                <FieldLabel for="name">
                                    Name
                                </FieldLabel>
                                <Input id="name" placeholder="Name" required name="name"/>
                                <FieldDescription v-if="errors.name" class="text-red-500">
                                    {{ errors.name }}
                                </FieldDescription>
                            </Field>
                            <Field>
                                <FieldLabel for="email">
                                    Email
                                </FieldLabel>
                                <Input id="email" placeholder="Email" required name="email"/>
                                <FieldDescription v-if="errors.email" class="text-red-500">
                                    {{ errors.email }}
                                </FieldDescription>
                            </Field>
                            <Field>
                                <FieldLabel for="password">
                                    Password
                                </FieldLabel>
                                <Input id="password" placeholder="Password" required name="password" type="password"/>
                                <FieldDescription v-if="errors.password" class="text-red-500">
                                    {{ errors.password }}
                                </FieldDescription>
                            </Field>
                            <Field>
                                <FieldLabel for="password_confirmation">
                                    Password Confirmation
                                </FieldLabel>
                                <Input id="password_confirmation" placeholder="Password Confirmation" required name="password_confirmation" type="password"/>
                                <FieldDescription v-if="errors.password_confirmation" class="text-red-500">
                                    {{ errors.password_confirmation }}
                                </FieldDescription>
                            </Field>
                            <Field>
                                <FieldLabel for="role">
                                    Role
                                </FieldLabel>
                                <Select name="role" :disabled="!can('users.edit.roles')">
                                    <SelectTrigger>
                                        <SelectValue placeholder="Select role"/>
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel>Roles</SelectLabel>
                                            <SelectItem v-for="role in props.roles" :key="role.id" :value="role.id">{{ role.name }}</SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                                <FieldDescription v-if="errors.role" class="text-red-500">
                                    {{ errors.role }}
                                </FieldDescription>
                            </Field>
                        </FieldGroup>
                    </FieldSet>
                    <Field orientation="horizontal">
                        <Button type="submit">
                            <Spinner class="animate-spin" v-if="processing"/>
                            Save
                        </Button>
                        <Link href="/users">
                            <Button variant="outline" type="button">
                                Cancel
                            </Button>
                        </Link>
                    </Field>
                </FieldGroup>
            </Form>
        </div>
    </AppLayout>
</template>

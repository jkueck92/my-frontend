<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Form, Link} from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Spinner } from '@/components/ui/spinner'
import DeleteUser from '@/components/DeleteUser.vue';

import UserController from '@/actions/App/Http/Controllers/UserController';

import {
  Field,
  FieldDescription,
  FieldGroup,
  FieldLabel,
  FieldSet,
} from '@/components/ui/field'

import {
  Select,
  SelectContent,
  SelectItem,
  SelectGroup,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'

import { can } from '@/lib/can';

interface Props {
    user: any;
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
        title: 'Show User',
        href: `/users/${props.user.id}`,
    }
];

</script>

<template>

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto flex h-full w-full max-w-6xl flex-1 flex-col p-4">

            <Heading title="Users" description="Update user details."/>

            <Form v-bind="UserController.update.form(props.user.id)" reset-on-success v-slot="{ errors, processing }" class="mb-8">
                <FieldGroup>
                    <FieldSet>
                        <FieldGroup>
                            <Field>
                                <FieldLabel for="name">
                                    Name
                                </FieldLabel>
                                <Input
                                    id="name"
                                    placeholder="e.g. HB F 123"
                                    required
                                    name="name"
                                    :default-value="props.user.name"
                                    :disabled="!can('users.edit')"
                                />
                                <FieldDescription v-if="errors.name" class="text-red-500">
                                    {{ errors.name }}
                                </FieldDescription>
                            </Field>
                            <Field>
                                <FieldLabel for="email">
                                    Email
                                </FieldLabel>
                                <Input
                                    id="email"
                                    placeholder="e.g. HLF 20"
                                    required
                                    name="email"
                                    :default-value="props.user.email"
                                    :disabled="!can('users.edit')"
                                />
                                <FieldDescription v-if="errors.email" class="text-red-500">
                                    {{ errors.email }}
                                </FieldDescription>
                            </Field>
                            <Field>
                                <FieldLabel for="role">
                                    Role
                                </FieldLabel>
                                <Select :default-value="props.user?.roles[0].id" name="role" :disabled="!can('users.edit.roles')">
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
                        <Button type="submit" :disabled="!can('users.edit')">
                            <Spinner class="animate-spin" v-if="processing"/>
                            Save
                        </Button>
                        <Link href="/users">
                            <Button variant="outline" type="button">
                                Back
                            </Button>
                        </Link>
                    </Field>
                </FieldGroup>
            </Form>
            <DeleteUser :user="props.user" v-if="can('users.delete')"/>
        </div>
    </AppLayout>
</template>

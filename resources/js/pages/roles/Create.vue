<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Form } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Input } from '@/components/ui/input'

import RoleController from '@/actions/App/Http/Controllers/RoleController';

import { Field, FieldDescription, FieldGroup, FieldLabel, FieldSet } from '@/components/ui/field'

import { Checkbox } from '@/components/ui/checkbox'
import { Label } from '@/components/ui/label'
import FormActions from '@/components/custom/FormActions.vue';

interface Props {
    permissions: Array<any>;
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
    {        
        title: 'Create Role',
        href: '/roles/create',
    }
];

</script>

<template>

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto flex h-full w-full max-w-6xl flex-1 flex-col p-4">

            <Heading title="Roles" description="Create a new role."/>

            <Form v-bind="RoleController.store.form()" reset-on-success v-slot="{ errors, processing }">
                <FieldGroup>
                    <FieldSet>
                        <FieldGroup>
                            <Field>
                                <FieldLabel for="name">Name</FieldLabel>
                                <Input id="name" placeholder="Name" required name="name"/>
                                <FieldDescription v-if="errors.name" class="text-red-500">{{ errors.name }}</FieldDescription>
                            </Field>
                            <Field>
                                <FieldLabel for="permissions">Permissions</FieldLabel>
                                <div v-for="permission in props.permissions" :key="permission.id">
                                    <Label class="hover:bg-accent/50 flex items-start gap-3 rounded-lg border p-3 has-[[aria-checked=true]]:border-blue-600 has-[[aria-checked=true]]:bg-blue-50 dark:has-[[aria-checked=true]]:border-blue-900 dark:has-[[aria-checked=true]]:bg-blue-950">
                                        <Checkbox :id="`permission-${permission.id}`" :value="permission.id" :name="`permissions[${permission.id}]`" class="data-[state=checked]:border-blue-600 data-[state=checked]:bg-blue-600 data-[state=checked]:text-white dark:data-[state=checked]:border-blue-700 dark:data-[state=checked]:bg-blue-700"/>
                                        <div class="grid gap-1.5 font-normal">
                                            <p class="text-sm leading-none font-medium">
                                                {{ permission.name }}
                                            </p>
                                            <p class="text-muted-foreground text-sm">
                                                You can enable or disable notifications at any time.
                                            </p>
                                        </div>
                                    </Label>
                                </div>
                                <FieldDescription v-if="errors.permissions" class="text-red-500">
                                    {{ errors.permissions }}
                                </FieldDescription>
                            </Field>
                        </FieldGroup>
                    </FieldSet>
                    <FormActions :processing="processing" :can-edit-permission="'roles.create'" back-href="/roles"/>
                </FieldGroup>
            </Form>
        </div>
    </AppLayout>
</template>

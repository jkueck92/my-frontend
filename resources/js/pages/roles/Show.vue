<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Form, Link} from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Spinner } from '@/components/ui/spinner'
import DeleteRole from '@/components/DeleteRole.vue';

import RoleController from '@/actions/App/Http/Controllers/RoleController';

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

import { Checkbox } from '@/components/ui/checkbox'
import { Label } from '@/components/ui/label'

import { can } from '@/lib/can';
import { computed } from 'vue';
import FormActions from '@/components/custom/FormActions.vue';

interface Props {
    role: any;
    permissions: any[];
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
        title: 'Show Role',
        href: `/roles/${props.role.id}`,
    }
];

const assignedPermissionIds = computed(() => {
    return props.role.permissions?.map((permission: any) => permission.id) || [];
});

const isPermissionAssigned = (permissionId: string) => {
    return assignedPermissionIds.value.includes(permissionId);
};

</script>

<template>

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto flex h-full w-full max-w-6xl flex-1 flex-col p-4">

            <Heading title="Roles" description="Update role details."/>

            <Form v-bind="RoleController.update.form(props.role.id)" reset-on-success v-slot="{ errors, processing }" class="mb-8">
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
                                    :default-value="props.role.name"
                                    :disabled="!can('roles.edit')"
                                />
                                <FieldDescription v-if="errors.name" class="text-red-500">
                                    {{ errors.name }}
                                </FieldDescription>
                            </Field>
                            
                            <Field>
                                <FieldLabel for="permissions">
                                    Permissions
                                </FieldLabel>

                                <div v-for="permission in props.permissions" :key="permission.id">
                                    <Label class="hover:bg-accent/50 flex items-start gap-3 rounded-lg border p-3 has-[[aria-checked=true]]:border-blue-600 has-[[aria-checked=true]]:bg-blue-50 dark:has-[[aria-checked=true]]:border-blue-900 dark:has-[[aria-checked=true]]:bg-blue-950">
                                        <Checkbox :id="`permission-${permission.id}`" :value="permission.id" :name="`permissions[${permission.id}]`" :default-value="isPermissionAssigned(permission.id)" class="data-[state=checked]:border-blue-600 data-[state=checked]:bg-blue-600 data-[state=checked]:text-white dark:data-[state=checked]:border-blue-700 dark:data-[state=checked]:bg-blue-700"/>
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
                    <FormActions :processing="processing" :can-edit-permission="'roles.edit'" back-href="/roles"/>
                </FieldGroup>
            </Form>
            <DeleteRole :role="props.role" v-if="can('roles.delete')"/>
        </div>
    </AppLayout>
</template>

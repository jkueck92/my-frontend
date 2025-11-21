<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Form, Link} from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Spinner } from '@/components/ui/spinner'

import VehicleController from '@/actions/App/Http/Controllers/VehicleController';

import { Field, FieldDescription, FieldGroup, FieldLabel, FieldSet } from '@/components/ui/field'

interface Props {
    vehicles: Array<any>;
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Vehicles',
        href: '/vehicles',
    },
    {        
        title: 'Create Vehicle',
        href: '/vehicles/create',
    }
];
</script>

<template>

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto flex h-full w-full max-w-6xl flex-1 flex-col p-4">

            <Heading title="Vehicles" description="Create a new vehicle."/>

            <Form v-bind="VehicleController.store.form()" reset-on-success v-slot="{ errors, processing }">
                <FieldGroup>
                    <FieldSet>
                        <FieldGroup>
                            <Field>
                                <FieldLabel for="license_plate">
                                    License Plate
                                </FieldLabel>
                                <Input id="license_plate" placeholder="e.g. HB F 123" required name="license_plate"/>
                                <FieldDescription v-if="errors.license_plate" class="text-red-500">
                                    {{ errors.license_plate }}
                                </FieldDescription>
                            </Field>
                            <Field>
                                <FieldLabel for="description">
                                    Description
                                </FieldLabel>
                                <Input id="description" placeholder="e.g. HLF 20" required name="description"/>
                                <FieldDescription v-if="errors.description" class="text-red-500">
                                    {{ errors.description }}
                                </FieldDescription>
                            </Field>
                        </FieldGroup>
                    </FieldSet>
                    <Field orientation="horizontal">
                        <Button type="submit">
                            <Spinner class="animate-spin" v-if="processing"/>
                            Save
                        </Button>
                        <Link href="/vehicles">
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

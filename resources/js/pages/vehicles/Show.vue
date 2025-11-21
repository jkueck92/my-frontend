<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Form, Link} from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Spinner } from '@/components/ui/spinner'
import DeleteVehicle from '@/components/DeleteVehicle.vue';

import VehicleController from '@/actions/App/Http/Controllers/VehicleController';

import {
  Field,
  FieldDescription,
  FieldGroup,
  FieldLabel,
  FieldSet,
} from '@/components/ui/field'
import { can } from '@/lib/can';

interface Props {
    vehicle: any;
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
    {        
        title: 'Show Vehicle',
        href: `/vehicles/${props.vehicle.id}`,
    }
];

</script>

<template>

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto flex h-full w-full max-w-6xl flex-1 flex-col p-4">

            <Heading title="Vehicles" description="Update vehicle details." />

            <Form v-bind="VehicleController.update.form(props.vehicle.id)" reset-on-success v-slot="{ errors, processing }" class="mb-8">
                <FieldGroup>
                    <FieldSet>
                        <FieldGroup>
                            <Field>
                                <FieldLabel for="checkout-7j9-card-name-43j">
                                    License Plate
                                </FieldLabel>
                                <Input
                                    id="checkout-7j9-card-name-43j"
                                    placeholder="e.g. HB F 123"
                                    required
                                    name="license_plate"
                                    :default-value="props.vehicle.license_plate"
                                    :disabled="!can('vehicles.edit')"
                                />
                                <FieldDescription v-if="errors.license_plate" class="text-red-500">
                                    {{ errors.license_plate }}
                                </FieldDescription>
                            </Field>
                            <Field>
                                <FieldLabel for="checkout-7j9-card-number-uw1">
                                    Description
                                </FieldLabel>
                                <Input
                                    id="checkout-7j9-card-number-uw1"
                                    placeholder="e.g. HLF 20"
                                    required
                                    name="description"
                                    :default-value="props.vehicle.description"
                                    :disabled="!can('vehicles.edit')"
                                />
                                <FieldDescription v-if="errors.description" class="text-red-500">
                                    {{ errors.description }}
                                </FieldDescription>
                            </Field>
                        </FieldGroup>
                    </FieldSet>
                    <Field orientation="horizontal">
                        <Button type="submit" :disabled="!can('vehicles.edit')">
                            <Spinner class="animate-spin" v-if="processing"/>
                            Save
                        </Button>
                        <Link href="/vehicles">
                            <Button variant="outline" type="button">
                                Back
                            </Button>
                        </Link>
                    </Field>
                </FieldGroup>
            </Form>
            <DeleteVehicle :vehicle="props.vehicle" v-if="can('vehicles.delete')"/>
        </div>
    </AppLayout>
</template>

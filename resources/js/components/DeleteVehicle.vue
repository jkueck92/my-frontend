<script setup lang="ts">
import VehicleController from '@/actions/App/Http/Controllers/VehicleController';
import { Form } from '@inertiajs/vue3';
import { useTemplateRef } from 'vue';

import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const licensePlateInput = useTemplateRef('licensePlateInput');

interface Props {
    vehicle: any;
}

const props = defineProps<Props>();

</script>

<template>
    <div class="space-y-4 rounded-lg border border-red-100 bg-red-50 p-4 dark:border-red-200/10 dark:bg-red-700/10">
        <div class="relative space-y-0.5 text-red-600 dark:text-red-100">
            <p class="font-medium">Warning</p>
            <p class="text-sm">
                Please proceed with caution, this cannot be undone.
            </p>
        </div>
        <Dialog>
            <DialogTrigger as-child>
                <Button variant="destructive" data-test="delete-vehicle-button">Delete vehicle</Button>
            </DialogTrigger>
            <DialogContent>
                <Form
                    v-bind="VehicleController.destroy.form(props.vehicle.id)"
                    reset-on-success
                    @error="() => licensePlateInput?.$el?.focus()"
                    :options="{
                        preserveScroll: true,
                    }"
                    class="space-y-6"
                    v-slot="{ errors, processing, reset, clearErrors }"
                >
                    <DialogHeader class="space-y-3">
                        <DialogTitle
                            >Are you sure you want to delete your
                            vehicle?</DialogTitle
                        >
                        <DialogDescription>
                            Once your vehicle is deleted, all of its
                            resources and data will also be permanently
                            deleted. Please enter your password to confirm
                            you would like to permanently delete your
                            vehicle.
                        </DialogDescription>
                    </DialogHeader>

                    <div class="grid gap-2">
                        <Label for="password" class="sr-only"
                            >Password</Label
                        >
                        <Input
                            id="licensePlateInput"
                            type="text"
                            name="licensePlate"
                            ref="licensePlateInput"
                            placeholder="License Plate"
                        />
                        <InputError :message="errors.licensePlate" />
                    </div>

                    <DialogFooter class="gap-2">
                        <DialogClose as-child>
                            <Button
                                variant="secondary"
                                @click="
                                    () => {
                                        clearErrors();
                                        reset();
                                    }
                                "
                            >
                                Cancel
                            </Button>
                        </DialogClose>

                        <Button type="submit" variant="destructive" :disabled="processing" data-test="confirm-delete-vehicle-button">
                            Delete vehicle
                        </Button>
                    </DialogFooter>
                </Form>
            </DialogContent>
        </Dialog>
    </div>
</template>

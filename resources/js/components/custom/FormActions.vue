<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';
import { Field } from '@/components/ui/field';
import { Link } from '@inertiajs/vue3';
import { can } from '@/lib/can';
import { computed } from 'vue';

interface Props {
    processing?: boolean;
    backHref?: string;
    canEditPermission?: string;
    disabled?: boolean;
    showBackButton?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    processing: false,
    backHref: '',
    canEditPermission: '',
    disabled: false,
    showBackButton: true
});

const isSubmitDisabled = computed(() => {
    return !can(props.canEditPermission) || props.disabled;
});
</script>

<template>
    <Field orientation="horizontal">
        <Button type="submit"  :disabled="isSubmitDisabled">
            <Spinner class="animate-spin" v-if="processing" />
            <slot name="submit-content">
                Save
            </slot>
        </Button>
        <Link :href="backHref" v-if="showBackButton">
            <Button variant="outline" type="button">
                <slot name="back-content">
                    Back
                </slot>
            </Button>
        </Link>
        <slot name="additional-actions" />
    </Field>
</template>
<script lang="ts" setup>
import { NModal, NCard } from "naive-ui";

const props = defineProps<{
    modelValue: boolean;
    title: string;
}>();

defineEmits<{
    (event: "update:modelValue", value: boolean): void;
}>();
</script>
<template>
        <n-modal v-model:show="props.modelValue" :on-update:show=" (value) => $emit('update:modelValue', value)">
        <n-card
            class="dialog-card"
            :title="title"
            :bordered="false"
            role="dialog"
            closable
            :on-close="() => $emit('update:modelValue', false)"
            aria-modal="true"
        >
            <slot />
        </n-card>
    </n-modal>
</template>
<style scoped>
.dialog-card {
    min-width: 600px;
    max-width: 800px;
}
</style>
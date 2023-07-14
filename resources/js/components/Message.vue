<script setup lang="ts">
import { defineProps } from "vue";
import { NAlert, NSpace } from "naive-ui";

const props = defineProps<{
    messages: {
        error?: string;
        success?: string;
    };
}>();
</script>
<template>
    <n-space vertical>
        <n-alert v-if="props.messages.success" title="Onnistui" type="success">
            {{ props.messages.success }}
        </n-alert>
        <n-alert v-if="props.messages.error" title="Virhe" type="error">
            {{ messages.error }}
        </n-alert>
    </n-space>
</template>

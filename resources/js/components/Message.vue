<script setup lang="ts">
import { defineProps } from "vue";
import { NAlert } from "naive-ui";

const props = defineProps<{
    messages: {
        error?: string;
        success?: string;
    };
}>();
</script>
<template>
    <n-alert v-if="props.messages.success" title="Onnistui" type="success">
        {{ props.messages.success }}
    </n-alert>
    <n-alert v-if="props.messages.error" title="Virhe" type="error">
        {{ props.messages.error }}
    </n-alert>
</template>

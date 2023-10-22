<script setup lang="ts">
import { defineProps } from "vue";
import { NAlert, NSpace } from "naive-ui";
import { computed } from "vue";

const props = defineProps<{
    messages: {
        error?: string;
        success?: string;
    };
}>();
const success = computed(() => {
    if (props.messages.success?.includes(",")) {
        return props.messages.success.split(",");
    }
    return props.messages.success;
});
</script>
<template>
    <n-space vertical>
        <n-alert v-if="props.messages.success" title="Onnistui" type="success">
            <template v-if="Array.isArray(success)">
                <n-space vertical>
                    <n-alert v-for="msg in success" :key="msg" type="success">
                        {{ msg }}
                    </n-alert>
                </n-space>
            </template>
            <template v-else>
                {{ success }}
            </template>
        </n-alert>
        <n-alert v-if="props.messages.error" title="Virhe" type="error">
            {{ messages.error }}
        </n-alert>
    </n-space>
</template>

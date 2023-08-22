<script lang="ts" setup>
import { GlobalThemeOverrides } from "naive-ui";
import { NConfigProvider, NMessageProvider, NDialogProvider } from "naive-ui";

const themeOverrides: GlobalThemeOverrides = {
    common: {
        primaryColor: "#253765",
        primaryColorHover: "#28a9e1",
    },
};
</script>
<template>
    <n-config-provider :theme-overrides="themeOverrides">
        <n-dialog-provider>
            <n-message-provider>
                <slot></slot>
            </n-message-provider>
        </n-dialog-provider>
    </n-config-provider>
</template>

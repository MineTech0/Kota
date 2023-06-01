<script lang="ts" setup>
import { GlobalThemeOverrides } from "naive-ui";
import { NConfigProvider } from "naive-ui";

const themeOverrides: GlobalThemeOverrides = {
    common: {
        primaryColor: "#253765",
    },
};
</script>
<template>
    <n-config-provider :theme-overrides="themeOverrides">
        <slot></slot>
    </n-config-provider>
</template>

<script setup lang="ts">
const props = defineProps(["header"]);
</script>
<template>
    <div class="card" style="margin-top: 1rem">
        <div class="card-header">{{ props.header }}</div>
        <div class="card-body">
            <div class="card-text">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

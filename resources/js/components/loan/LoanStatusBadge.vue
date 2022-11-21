<script setup lang="ts">
import { parse } from "date-fns";
import { computed } from "vue";

const props = defineProps<{
    state: number;
    returnDate: string;
}>();

const isLate = computed(
    () => parse(props.returnDate, "d/m/y", new Date()) > new Date()
);
</script>
<template>
    <span v-if="isLate" class="badge badge-danger">Myöhässä</span>

    <span v-else-if="props.state === 0" class="badge badge-primary"
        >Hyväksytty</span
    >

    <span v-else-if="props.state === 1" class="badge badge-info"
        >Odottaa hyväksyntää</span
    >

    <span v-else-if="props.state === 2" class="badge badge-success"
        >Hyväksytty</span
    >

    <span v-else class="badge badge-warning">Ei hyväksytty</span>
</template>

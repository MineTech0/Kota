<script lang="ts" setup>
import { ParentAgeGroup } from "@/types";
import { NTag } from "naive-ui";
import { computed } from "vue";
import { ParentAgeGroupColor } from "@/colors";
import { getTextColor } from "@/utils/commontUtils";

const props = defineProps<{
    parentAgeGroup: ParentAgeGroup;
}>();

const color = computed(() => ParentAgeGroupColor[props.parentAgeGroup]);
const textColor = computed(() => getTextColor(color.value));
</script>
<template>
    <NTag type="info" :color="{ color, textColor, borderColor: color }">
        {{ parentAgeGroup }}
    </NTag>
</template>

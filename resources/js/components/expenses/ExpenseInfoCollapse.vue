<script lang="ts" setup>
import { NCollapse, NCollapseItem, NUl, NLi } from "naive-ui";

const props = defineProps<{
    infos: string[]
}>();

</script>
<template>
    <n-collapse>
        <n-collapse-item title="Lisätiedot" name="info">
            <n-ul :style="{
                listStyle: 'disc'
            }">
                <n-li v-for="info in props.infos">{{ info }}</n-li>
            </n-ul>
        </n-collapse-item>
    </n-collapse>
</template>

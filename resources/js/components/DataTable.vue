<script lang="ts" setup>
import {
    DataTableColumns,
    NDataTable,
    NSpace,
    NInput,
    NInputGroupLabel,
    NInputGroup,
DataTableProps,
} from "naive-ui";
import { watch, ref } from "vue";

interface Props extends DataTableProps {
    data: any;
    columns: DataTableColumns<any>;
    search?: boolean;
}

const props = defineProps<Props>();
const filteredData = ref<any>(props.data);

watch(
    () => props.data,
    (data) => {
        filteredData.value = data;
    }
);

const handleSearch = (value: string) => {
    filteredData.value = props.data.filter((user: any) => {
        return user.name.toLowerCase().includes(value.toLowerCase());
    });
};
</script>
<template>
    <n-space justify="end" v-if="search">
        <n-input-group class="mb-3">
            <n-input-group-label>Etsi: </n-input-group-label>
            <n-input :placeholder="''" @input="handleSearch" />
        </n-input-group>
    </n-space>
    <n-data-table
        v-bind="$attrs"
        class="data-table"
        :columns="columns"
        :data="filteredData"
        :row-key="(row) => row.id"
        :paginate-single-page="false"
        :pagination="{
            pageSize: 10,
        }"
        scroll-x="100%"
    />
</template>
<style scoped>
.data-table {
    overflow-x: auto;
    word-break: normal;
    white-space: nowrap;
}
@media (max-width: 600px) {
    .data-table {
        font-size: 12px;
    }
}
</style>

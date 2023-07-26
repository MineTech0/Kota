<script lang="ts" setup>
import { h, computed, ref, reactive } from "vue";
import { NButton, DataTableColumns,NSpace } from "naive-ui";
import DataTable from "@/components/DataTable.vue";
import { FileI } from "../../types";

const props = defineProps<{
    files: FileI[];
    token: string;
    categories: string[]
}>();

const rows = ref(props.files);

const columns = computed((): DataTableColumns<FileI> => {
    return [
        {
            title: "Nimi",
            key: "name",
        },
        {
            title: "Kategoria",
            key: "category",
            defaultFilterOptionValues: props.categories,
            filterOptions: props.categories.map(category => ({
                label: category,
                value: category
            }))
            ,
            filter(value, row) {
                return !!~row.category.indexOf(String(value));
            },
        },
        {
            title: "Tiedosto",
            key: "actions",
            render(row) {
                return h(
                    NButton,
                    {
                        strong: true,
                        tertiary: true,
                        size: "small",
                        onClick: () => download(row),
                        download,
                    },
                    { default: () => getLabel(row) }
                );
            },
        },
    ];
});

const pagination = reactive({ pageSize: 8 });

const download = (row: FileI) => {
    //Avataan tiedosto selaimessa
    if (row.isUrl) {
        window.open(row.path, "_blank")?.focus();
    }
    //ladataan tiedosto
    const url = `files/${row.id}/token/${props.token}`;
    window.open(url, "_blank")?.focus();
};

const getLabel = (row: FileI) => {
    return row.isUrl ? "Avaa" : "Lataa";
};
</script>

<template>
            <DataTable
                :columns="columns"
                :data="rows"
                :pagination="pagination"
            />
</template>

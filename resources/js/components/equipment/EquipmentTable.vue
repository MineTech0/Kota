<script lang="ts" setup>
import DataTable from "@/components/DataTable.vue";
import { Equipment } from "@/types";
import { DataTableColumns, NButton, NTag } from "naive-ui";
import { h } from "vue";

const props = defineProps<{
    equipment: Equipment[];
    formOptions: string[];
}>();



const columns: DataTableColumns<Equipment> = [
    {
        title: "Nimi",
        key: "name",
        minWidth: 120,
        sorter: 'default'
    },
    {
        title: "Sarjanumero",
        key: "serial",
        minWidth: 120,
        sorter: 'default'
    },
    {
        title: "Kunto",
        key: "form",
        minWidth: 120,
        sorter: (a, b) => props.formOptions.indexOf(a.form) - props.formOptions.indexOf(b.form),
    },
    {
        title: "Paikka",
        key: "location",
        minWidth: 120,
        sorter: 'default'
    },
    {
        title: "Määrä",
        key: "quantity",
        minWidth: 120,
        sorter: 'default'
    },
    {
        title: "Lisätiedot",
        key: "info",
        minWidth: 220,
        sorter: 'default'
    },
    {
        title: "Kuva",
        minWidth: 120,
        key: "picture",
        render: (row) => {
            if (row.picture) {
                return h(
                    "a",
                    {
                        href: `storage/${row.picture}`,
                        target: "_blank",
                    },
                    {
                        default: () => "Avaa kuva",
                    }
                );
            }
            return "";
        },
    },
    {
        title: "",
        key: "actions",
        render(row) {
            return h(
                NButton,
                {
                    strong: true,
                    tertiary: true,
                    size: "small",
                    onClick: () => {
                        window.location.href = `/equipment/${row.id}/edit`;
                    },
                },
                { default: () => "Muokkaa" }
            );
        },
    },
];
</script>
<template>
    <DataTable
        :single-line="false"
        :columns="columns"
        :data="equipment"
        :row-key="(row) => row.id"
        search
    />
</template>
<style scoped></style>

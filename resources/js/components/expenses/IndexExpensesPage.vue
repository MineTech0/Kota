<script lang="ts" setup>
import { DataTableColumns } from "naive-ui";
import { AgeGroupExpenses, Group, GroupExpense, GroupWithExpenses } from "../../types";
import Panel from "../Panel.vue";
import {NDataTable } from "naive-ui";
import { computed } from "vue";

const props = defineProps<{
    expensesByAgeGroup: AgeGroupExpenses[];
}>();

console.log(props.expensesByAgeGroup);

const rowData = computed(() => props.expensesByAgeGroup.map((age, index) => ({
    ...age,
    name: age.age,
    id: index,
    children: age.expenses.map((group) => ({
        ...group,
        children: group.expenses,
    })),
})));

const columns: DataTableColumns<GroupExpense> = [
    {
        title: "Nimi",
        key: "name",
    },
    {
        title: "Kulut",
        key: "amount",
        render: (row) => {
            return row.amount + " €";
        }
    },
    {
        title: "Kulupäivä",
        key: "expense_date",
        render: (row) => {
            if(row.expense_date)
            {
                return new Date(row.expense_date).toLocaleDateString();
            }
        }
    },
    {
        title: "Kuvaus",
        key: "description",
    },
];
</script>
<template>
    <Panel header="Ryhmien kulut">
        <n-data-table
            :columns="columns"
            :data="rowData"
            :row-key="(row: GroupExpense ) => row.id"
        />
    </Panel>
</template>

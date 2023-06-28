<script lang="ts" setup>
import { DataTableColumns } from "naive-ui";
import { AgeGroupExpenses, Group, GroupExpense, GroupWithExpenses } from "../../types";
import {NDataTable } from "naive-ui";
import { computed } from "vue";

const props = defineProps<{
    groups: GroupWithExpenses[];
}>();

const rowData = computed(() => props.groups.map((group, index) => ({
    ...group,
    amount: group.expenses.reduce((acc, expense) => acc + expense.amount, 0),
    children: group.expenses,
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
        <n-data-table
            class="table"
            :columns="columns"
            :data="rowData"
            :row-key="(row) => row.id"
        />
</template>
<style scoped>

@media (max-width: 600px) {
  .table {
    font-size: 12px;
  }
}
</style>

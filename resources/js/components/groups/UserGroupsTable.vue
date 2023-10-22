<script lang="ts" setup>
import { DataTableColumns, NDataTable } from "naive-ui";
import { computed } from "vue";
import { GroupExpense, GroupWithExpenses } from "../../types";

const props = defineProps<{
    groups: GroupWithExpenses[];
    modelValue: GroupWithExpenses;
}>();

const rowData = computed(() =>
    props.groups.map((group, index) => ({
        ...group,
        amount: group.expenses.reduce(
            (acc, expense) => acc + Number(expense.amount),
            0
        ),
        header: true,
        children: group.expenses.map((expense, i) => ({
            ...expense,
            header: false,
        })),
    }))
);

const emit = defineEmits<{
    (event: "update:modelValue", group: GroupWithExpenses): void;
}>();

const selectGroup = computed({
    get() {
        return [props.modelValue.id];
    },
    set(group: number[]) {
        emit("update:modelValue", props.groups.find((g) => g.id === group[0])!);
    },
});

const columns: DataTableColumns<{
    id: number;
    name: string;
    amount: number;
    expense_date: string;
    description: string;
    header: boolean;
    children: GroupExpense[];
}> = [
    {
        type: "selection",
        multiple: false,
        disabled: (row) => !row.header,
        cellProps: (row) => {
            if (!row.header) {
                return {
                    style: {
                        visibility: "hidden",
                    },
                };
            }
            return {}
        },
    },
    {
        title: "Nimi",
        key: "name",
        minWidth: 120,
    },
    {
        title: "Kulut",
        key: "amount",
        render: (row) => {
            return row.amount + " €";
        },
        minWidth: 100,
    },
    {
        title: "Kulupäivä",
        key: "expense_date",
        render: (row) => {
            if (row.expense_date) {
                return new Date(row.expense_date).toLocaleDateString("fi-FI");
            }
        },
        minWidth: 100,
    },
    {
        title: "Kuvaus",
        key: "description",
        minWidth: 190,
    },
    
];
</script>
<template>
    <n-data-table
        class="table"
        :columns="columns"
        :data="rowData"
        :row-key="(row) => row.id"
        v-model:checked-row-keys="selectGroup"
    />
</template>
<style scoped>
@media (max-width: 600px) {
    .table {
        font-size: 12px;
    }
}
:deep(td) {
    vertical-align: baseline;
}
</style>

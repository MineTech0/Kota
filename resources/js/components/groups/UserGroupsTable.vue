<script lang="ts" setup>
import { DataTableColumns, NDataTable, NProgress } from "naive-ui";
import { computed } from "vue";
import { ClubMoney, GroupExpense, GroupWithExpenses } from "../../types";
import { h } from "vue";

const props = defineProps<{
    groups: GroupWithExpenses[];
    modelValue: GroupWithExpenses;
    clubMoney: ClubMoney[];
}>();

const rowData = computed(() =>
    props.groups.map((group, index) => ({
        ...group,
        amount: group.expenses.reduce(
            (acc, expense) => acc + Number(expense.amount),
            0
        ),
        budget:
            Number(props.clubMoney.find((clubMoney) => {
                return clubMoney.age_group === group.parentAgeGroup;
            })?.amount ?? 0) * group.member_count,
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
    budget: number | null;
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
            return {};
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
        title: "Käytetty",
        key: "budget",
        render: (row) => {
            if (row.budget) {
                const precentage = (row.amount / row.budget * 100).toFixed(0);
                return h(NProgress, {
                    showInfo: true,
                    percentage: Number(precentage),
                    status: "success",
                    railColor:"#253765",
                    color: "#c6c6c6",
                    style: {
                        width: "100px",
                    },
                }, {
                    default: () => `${precentage}%`
                }
                );
            }
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

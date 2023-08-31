<script lang="ts" setup>
import {
    DataTableColumns,
    NButton,
    NRadio,
    NRadioGroup,
    NSpace,
    useDialog,
    useMessage,
} from "naive-ui";
import { AgeGroupExpenses, GroupExpense } from "../../types";
import Panel from "../Panel.vue";
import { computed, h, ref } from "vue";
import ExpenseService from "@/services/ExpenseService";
import useService from "@/composables/useService";
import DataTable from "../DataTable.vue";

const props = defineProps<{
    currentSeasonExpenses: AgeGroupExpenses[];
    previousSeasonExpenses: AgeGroupExpenses[];
    seasons: string[];
    canDelete: boolean;
}>();

const expenses = ref<AgeGroupExpenses[]>(props.currentSeasonExpenses);

const seasonSelect = ref(props.seasons[1]);

const dialog = useDialog();

const message = useMessage();

const { fetch, messages, loading } = useService({ reload: true });

const rowData = computed(() =>
    expenses.value.map((age, index) => ({
        name: age.age,
        id: age.age,
        amount: age.amount,
        children: age.expenses.map((group) => ({
            id: group.name,
            amount: group.amount,
            name: group.name,
            children: group.expenses.map((expense) => ({
                amount: expense.amount,
                expense_date: expense.expense_date,
                name: expense.description,
                id: expense.id,
            })),
        })),
    }))
);

const columns: DataTableColumns<GroupExpense> = [
    {
        title: "Nimi",
        key: "name",
        minWidth: 120,
    },
    {
        title: "Kulut",
        key: "amount",
        minWidth: 100,
        render: (row) => {
            return row.amount + " €";
        },
    },
    {
        title: "Kulupäivä",
        key: "expense_date",
        minWidth: 120,
        render: (row) => {
            if (row.expense_date) {
                return new Date(row.expense_date).toLocaleDateString("fi-FI");
            }
        },
    },
    {
        title: "",
        key: "delete",
        render: (row) => {
            if (!row.expense_date) return "";
            if (!props.canDelete) return "";
            return h(
                NButton,
                {
                    strong: true,
                    secondary: true,
                    circle: true,
                    type: "error",
                    title: "Poista",
                    onClick: () => {
                        deleteExpense(row.id);
                    },
                },
                {
                    default: () => h("i", { class: "fas fa-trash" }),
                }
            );
        },
    },
];

/**
 * Update expenses when season changes
 */
const updateExpenses = () => {
    if (seasonSelect.value === props.seasons[1]) {
        expenses.value = props.currentSeasonExpenses;
    } else {
        expenses.value = props.previousSeasonExpenses;
    }
};

/**
 * Delete expense by id
 * @param id
 */
const deleteExpense = (id: number) => {
    if (!props.canDelete) return;
    dialog.warning({
        title: "Poista kulu",
        content: "Haluatko varmasti poistaa kulun?",
        positiveText: "Poista",
        negativeText: "Peruuta",
        onPositiveClick: () => {
            fetch(ExpenseService.deleteExpense(id))
                .then(() => {
                    message.success(messages.success);
                    updateExpenses();
                })
                .catch(() => {
                    dialog.error({
                        title: "Virhe",
                        content: messages.error,
                    });
                });
        },
    });
};
</script>
<template>
    <Panel header="Ryhmien kulut">
        <n-space vertical>
            <n-radio-group v-model:value="seasonSelect">
                <n-radio
                    v-for="season in seasons"
                    :key="season"
                    :value="season"
                    :label="season"
                    @change="updateExpenses"
                />
            </n-radio-group>
            <DataTable
                :loading="loading"
                :columns="columns"
                :data="rowData"
            />
        </n-space>
    </Panel>
</template>

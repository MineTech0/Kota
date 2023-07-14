<script lang="ts" setup>
import { DataTableColumns, NRadio, NRadioGroup, NSpace } from "naive-ui";
import {
    AgeGroupExpenses,
    GroupExpense,
} from "../../types";
import Panel from "../Panel.vue";
import { NDataTable } from "naive-ui";
import { computed, ref } from "vue";

const props = defineProps<{
    currentSeasonExpenses: AgeGroupExpenses[];
    previousSeasonExpenses: AgeGroupExpenses[];
    seasons: string[];
}>();

const expenses = ref<AgeGroupExpenses[]>(props.currentSeasonExpenses);

const seasonSelect = ref(props.seasons[1]);
// also filter by season
const rowData = computed(() =>
    expenses.value.map((age, index) => ({
        ...age,
        name: age.age,
        id: index,
        children: age.expenses.map((group) => ({
            ...group,
            children: group.expenses.map((expense) => ({
                ...expense,
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
    },
    {
        title: "Kulut",
        key: "amount",
        render: (row) => {
            return row.amount + " €";
        },
    },
    {
        title: "Kulupäivä",
        key: "expense_date",
        render: (row) => {
            if (row.expense_date) {
                return new Date(row.expense_date).toLocaleDateString("fi-FI");
            }
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
}

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
            <n-data-table
                :columns="columns"
                :data="rowData"
                :row-key="(row) => row.id + row.name"
            />
        </n-space>
    </Panel>
</template>

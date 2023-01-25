<script lang="ts" setup>
import { NTabs, NTabPane } from "naive-ui";
import { ExpenseInfos, Group } from "../../types";
import CreateGroupExpensesForm from "./CreateGroupExpensesForm.vue";
import Panel from "../Panel.vue";
import ExpenseInfoCollapse from "./ExpenseInfoCollapse.vue";

const props = defineProps<{
    groups: Group[];
    infos: ExpenseInfos
}>();

</script>

<template>
    <Panel header="Lisää kuluja">
        <n-tabs type="line" animated>
            <n-tab-pane tab="Ryhmän kulu" name="groupExpenses">
                <create-group-expenses-form :groups="props.groups" />
                <expense-info-collapse :infos="props.infos.group"/>
            </n-tab-pane>
            <n-tab-pane tab="Budjetti kulu" name="budgetExpenses">
                Budjetti
            </n-tab-pane>
        </n-tabs>
    </Panel>
</template>

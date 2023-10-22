<script lang="ts" setup>
import Panel from "@/components/Panel.vue";
import { ClubMoney, GroupWithExpenses } from "@/types";
import {
    NCard,
    NCol,
    NGrid,
    NGridItem,
    NIcon,
    NPopover,
    NRow,
    NStatistic,
    NTag,
} from "naive-ui";
import UsageChart from "./UsageChart.vue";
import { computed } from "vue";
import AgeGroupTag from "@/components/AgeGroupTag.vue";

const props = defineProps<{
    group: GroupWithExpenses;
    clubMoney: ClubMoney;
}>();

const sum = computed(() =>
    props.group.expenses.reduce(
        (acc, expense) => acc + Number(expense.amount),
        0
    )
);
const budget = computed(
    () => props.clubMoney.amount * props.group.member_count
);

const used = computed(() => {
    if (budget.value > 0) {
        return (sum.value / budget.value) * 100;
    }
    return 100;
});
</script>
<template>
    <NGrid cols="1 400:2" x-gap="12" y-gap="12">
        <NGridItem class="grid-i">
            <NCard :title="group.name" class="chart">
                <template #header-extra>
                    <AgeGroupTag :parentAgeGroup="group.parentAgeGroup" />
                </template>
                <NRow>
                    <NCol :span="12">
                        <NStatistic label="Käytetty" :value="sum">
                            <template #suffix>€</template>
                        </NStatistic>
                    </NCol>
                    <NCol :span="12">
                        <n-statistic label="Käytetty %">
                            {{ used.toFixed(0) }} %
                        </n-statistic>
                    </NCol>
                </NRow>
                <NRow>
                    <NCol :span="12">
                        <n-statistic>
                            <template #label>
                               Kerhoraha
                                <NPopover
                                    placement="bottom-end"
                                    style="width: 200px"
                                    trigger="hover"
                                >
                                    <template #trigger>
                                        <i class="fas fa-info-circle"></i>
                                    </template>
                                    <span
                                        >Kerhorahan määrä on kirjattu lippukunnan budjettiin.</span
                                    >
                                </NPopover>
                            </template>
                            {{ clubMoney.amount }} € / Jäsen
                        </n-statistic>
                    </NCol>
                    <NCol :span="12">
                        <n-statistic label="Ryhmän jäseniä">
                            {{ group.member_count || 0 }}
                        </n-statistic>
                    </NCol>
                </NRow>
            </NCard>
        </NGridItem>
        <NGridItem class="grid-i">
            <NCard class="chart" title="Budjetista käytetty">
                <UsageChart
                    :amount="
                        group.expenses.reduce(
                            (acc, expense) => acc + Number(expense.amount),
                            0
                        )
                    "
                    :maxAmount="budget"
                />
            </NCard>
        </NGridItem>
    </NGrid>
</template>
<style scoped>
.grid-i {
    height: 250px;
}
.chart {
    height: 100%;
}
</style>

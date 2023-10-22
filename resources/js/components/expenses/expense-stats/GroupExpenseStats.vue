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
const budget = computed(() => props.clubMoney.amount * props.group.member_count);

const used = computed(() => (sum.value  == 0 ? 0 : sum.value / budget.value) * 100);

</script>
<template>
    <NGrid cols="1 400:2" x-gap="12" y-gap="12">
        <NGridItem class="grid-i">
            <NCard :title="group.name" class="chart">
                <template #header-extra>
                    <NTag type="info">
                        {{ group.parentAgeGroup }}
                    </NTag></template
                >
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
                                € / Jäsen
                                <NPopover placement="bottom-end" style="width: 200px" trigger="hover">
                                    <template #trigger>
                                        <i class="fas fa-info-circle"></i>
                                    </template>
                                    <span
                                        >Kerhorahan määrä riippu ryhmän jäsenten määrästä</span
                                    >
                                </NPopover>
                            </template>
                            {{ clubMoney.amount }} €
                        </n-statistic>
                    </NCol>
                    <NCol :span="12">
                        <n-statistic label="Jäseniä">
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

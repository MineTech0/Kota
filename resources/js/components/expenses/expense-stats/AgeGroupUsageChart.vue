<script lang="ts" setup>
import { AgeGroupBudget, AgeGroupExpenses, ClubMoney } from "@/types";
import { computed } from "vue";
import {
    ArcElement,
    Chart as ChartJS,
    Legend,
    LinearScale,
    Tooltip,
} from "chart.js";
import { Bar } from "vue-chartjs";
import { BarElement } from "chart.js";
import { CategoryScale } from "chart.js";
import { Title } from "chart.js";

const props = defineProps<{
    ageGroupExpenses: AgeGroupExpenses[];
    ageGroupBudgets: AgeGroupBudget[];
}>();

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
);

const chartData = computed(() => {
    return props.ageGroupExpenses.map((age) => {
        const budget = props.ageGroupBudgets.find(
            (budget) => budget.parentAgeGroup === age.age
        )?.clubMoneyBudget ?? 0;
        return {
            age: age.age,
            amount: age.amount,
            left: Math.max(budget - age.amount, 0),
        };
    });
});

const data = computed(() => ({
    labels: chartData.value.map((age) => age.age),
    datasets: [
        {
            label: "Käytetty",
            data: chartData.value.map((age) => age.amount),
            backgroundColor: "#253765",
            hoverBackgroundColor: "#28a9e1",
        },
        {
            label: "Jäljellä",
            data: chartData.value.map((money) => money.left),
            backgroundColor: "#c6c6c6",
            hoverBackgroundColor: "#28a9e1",
        },
    ],
}));

const options = computed(() => ({
    responsive: true,
    maintainAspectRatio: false,
    scales: {
        x: {
            stacked: true,
        },
        y: {
            stacked: true,
        },
    },
    plugins: {
        legend: {
            display: true,
            reverse: true,
        },
        tooltip: {
            enabled: true,
        },
        datalabels: {
            color: "#fff",
            display: (context) => {
                return context.dataset.data[context.dataIndex] > 0;
            },
            formatter: (value: number) => (value ? `${value} €` : "0 €"),
            font: {
                size: 20,
                weight: "bold",
            },
            backgroundColor: "#28a9e1",
            borderRadius: 10,
            padding: 5,
        },
    },
}));
</script>
<template>
    <Bar :data="data" :options="options" />
</template>

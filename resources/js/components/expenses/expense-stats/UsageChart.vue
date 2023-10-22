<script lang="ts" setup>
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js";
import ChartDataLabels from "chartjs-plugin-datalabels";
import { computed } from "vue";
import { reactive } from "vue";
import { Doughnut } from "vue-chartjs";
const props = defineProps<{
    amount: number;
    maxAmount: number;
}>();

ChartJS.register(ArcElement, Tooltip, Legend, ChartDataLabels);

const data = computed(() => ({
    labels: ["Käytetty", "Jäljellä"],
    datasets: [
        {
            data: [ props.maxAmount - props.amount, props.amount],
            backgroundColor: ["#c6c6c6", "#253765"],
            hoverBackgroundColor: ["#28a9e1", "#253765"],
        },
    ],
}));

const options = reactive({
    responsive: true,
    maintainAspectRatio: false,
    cutout: "40%",
    plugins: {
        legend: {
            display: false,
        },
        tooltip: {
            enabled: false,
        },
        datalabels: {
            color: "#fff",
            formatter: (value: number) => value ? `${value} €` : '',
            font: {
                size: 18,
                weight: "bold",
            },
        },
        doughnutInteriorText: {
            beforeDraw: function (chart) {
                var width = chart.chartArea.width,
                    height = chart.chartArea.height,
                    ctx = chart.ctx;

                ctx.restore();
                var fontSize = (height / 114).toFixed(2);
                ctx.font = fontSize + "em sans-serif";
                ctx.textBaseline = "middle";

                var text = chart.data.datasets[0].data.reduce(
                        (partialSum, a) => partialSum + a,
                        0
                    ),
                    textX = Math.round(
                        (width - ctx.measureText(text).width) / 2
                    ),
                    textY =
                        height / 2 +
                        chart.legend.height +
                        chart.titleBlock.height;

                ctx.fillText(text, textX, textY);
                ctx.save();
            },
        },
    },
});
</script>
<template>
    <div class="chart-container" style="position: relative; height:160px;">
        <Doughnut :data="data" :options="options" />
    </div>
</template>

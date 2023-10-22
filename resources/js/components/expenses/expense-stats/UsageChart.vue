<script lang="ts" setup>
import { ArcElement, Chart as ChartJS, Legend, LinearScale, Tooltip } from "chart.js";
import ChartDataLabels from "chartjs-plugin-datalabels";
import { computed, reactive } from "vue";
import { Doughnut } from "vue-chartjs";
const props = defineProps<{
    amount: number;
    maxAmount: number;
}>();

ChartJS.register(ArcElement, Tooltip, Legend, ChartDataLabels, LinearScale);

const data = computed(() => ({
    labels: ["Käytetty", "Jäljellä"],
    datasets: [
        {
            data: [ props.amount, props.maxAmount - props.amount],
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
            display: true,
            reverse: true,
        },
        tooltip: {
            enabled: false,
        },
        datalabels: {
            color: "#fff",
            formatter: (value: number) => value ? `${value} €` : '',
            font: {
                size: 20,
                weight: "bold",
            },
            backgroundColor: "#28a9e1",
            borderRadius: 10,
        },
        doughnutInteriorText: {
            beforeDraw: function (chart) {
                const width = chart.chartArea.width,
                    height = chart.chartArea.height,
                    ctx = chart.ctx;

                ctx.restore();
                const fontSize = (height / 250).toFixed(2);
                ctx.font = fontSize + "em sans-serif";
                ctx.textBaseline = "middle";

                const text = chart.data.datasets[0].data.reduce(
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
    <div class="chart-container" style="position: relative; height:180px;">
        <Doughnut :data="data" :options="options" />
    </div>
</template>

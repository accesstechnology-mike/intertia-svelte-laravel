<script>
    import { onMount } from "svelte";
    import { Line } from "svelte-chartjs";
    import Chart from "chart.js/auto";

    export let data = [];

    let chart;

    Chart.defaults.font.family = "'Inter', sans-serif";

    // $: labels = data.map((item) => `Week ${item.week}`);

    $: labels = data.map((item) => {
        const startDate = new Date(item.start_date);
        const formattedDate = startDate.toLocaleDateString("en-US", {
            // year: "numeric",
            month: "short",
            day: "numeric",
        });
        return `wc ${formattedDate}`;
    });
    $: chartData = data.map((item) => item.average);
    $: chartConfig = {
        labels,
        datasets: [
            {
                data: chartData,
                backgroundColor: "rgba(75, 192, 192, 0.2)",
                borderColor: "rgba(75, 192, 192, 1)",
                borderWidth: 1,
            },
        ],
    };
</script>

<Line
    bind:this={chart}
    options={{
        responsive: true,
        tension: 0.3,
        pointStyle: false,
        maintainAspectRatio: false,
        aspectRatio: 1,
        borderWidth: 10,
        plugins: {
            legend: { display: false },
            tooltip: { enabled: false },
        },
        scales: {
            x: {
                display: true,
            },
            y: {
                display: true,
                min: 0,
            },
        },
    }}
    data={chartConfig}
/>

<style>
    canvas {
        height: 360px !important;
    }
</style>

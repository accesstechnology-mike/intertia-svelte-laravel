<script>
    export let user;

    export let viewAsRole;

    let displayedRole = viewAsRole ? viewAsRole : user.roles[0].name;

    export let milesThisMonth;
    export let milesLastMonth;
    // export let totalMiles
    export let percentEquivHoursThisQuarter;
    export let percentOfQuarter;
    export let userTarget;
    export let equivHoursThisQuarter;
    export let clientCount;
    export let rollingAverages;

    console.log("last12Weeks", rollingAverages);

    import Chart from "../../Components/Profile/Chart.svelte";

    let mileageThisMonth = (milesThisMonth * 0.45).toLocaleString("en-GB", {
        style: "currency",
        currency: "GBP",
    });
    let mileageLastMonth = (milesLastMonth * 0.45).toLocaleString("en-GB", {
        style: "currency",
        currency: "GBP",
    });

    //equivHoursThisQuarter to zero decimal places
    equivHoursThisQuarter = equivHoursThisQuarter;

    //currentTarget as percertofQuarter of userTarget
    let currentTarget = (userTarget * percentOfQuarter) / 100;

    //onTarget equivHoursThisQuarter/currentTarget to 1 decimal place
    let onTarget = (equivHoursThisQuarter / currentTarget).toFixed(1);

    let pageName = user.name;

    import { Avatar } from "@skeletonlabs/skeleton";
    import { ProgressBar } from "@skeletonlabs/skeleton";

    // user.avatar = user.avatar.replace("?sz=50", "?sz=200");

    function getMonthFormat(date, format) {
        return date.toLocaleDateString("default", { month: format });
    }

    function updateMonthFormats() {
        const currentDate = new Date();
        const lastMonth = new Date(
            currentDate.getFullYear(),
            currentDate.getMonth() - 1
        );
        const isLargeScreen = window.matchMedia("(min-width: 1024px)").matches;
        const format = isLargeScreen ? "long" : "short";

        return {
            currentMonth: getMonthFormat(currentDate, format),
            lastMonth: getMonthFormat(lastMonth, format),
        };
    }

    let { currentMonth, lastMonth } = updateMonthFormats();

    window.addEventListener("resize", () => {
        ({ currentMonth, lastMonth } = updateMonthFormats());
    });

    // const lastMonth = new Date(
    //     currentDate.getFullYear(),
    //     currentDate.getMonth() - 1
    // ).toLocaleDateString("default", { month: "short" });

    let face;
    //if ontarget is greater than 1, let emotion be

    if (onTarget >= 1) {
        face = "🥳";
    } else {
        face = null;
    }
</script>

<!-- svelte-ignore missing-declaration -->
<svelte:head>
    <title>{pageName}</title>
</svelte:head>

<div class="flex">
    <div class="flex-1">
        <h1 class="pb-2">{pageName}</h1>
        <h3 class="pb-2">{displayedRole}</h3>
        <p>🏠 {user.postcode}</p>
    </div>

    <div class="flex-initial w-28">
        <Avatar src={user.avatar} alt={user.name} width="100%" />
    </div>
</div>
<hr class="mb-4" />

<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
    <div class="">
        <!-- hide section if role is Technician or Assistant or Admin -->
        {#if displayedRole != "AT Technician" && displayedRole != "AT Assistant" && displayedRole != "AT Admin"}
            <div class="card p-4 w-full h-60 mb-3">
                <h3 class="pb-1 mb-4">
                    🥰<strong> {clientCount} clients</strong>
                </h3>
                //breakdown of weighting / statuses etc.
            </div>
        {/if}

        <!-- hide section if role is  Admin -->
        {#if displayedRole != "Admin"}
            <div class="card p-4 h-32">
                <span class="text-lg"
                    >Client Intervention: <strong
                        >{equivHoursThisQuarter}</strong
                    >
                </span>hrs
                <!-- <span class="text-sm"> - <i> {onTarget}:1</i> </span> -->
                {face}
                <ProgressBar
                    label="Progress Bar"
                    value={percentEquivHoursThisQuarter}
                    max={100}
                    class="mb-6"
                    height="h-3"
                    meter="bg-green-500"
                />
                <i
                    ><span class="text-sm"
                        >Reference milestone: <strong>{currentTarget}</strong>
                    </span><span class="text-xs"> / {userTarget} hrs</span></i
                >
                <ProgressBar
                    label="Minimum"
                    value={percentOfQuarter}
                    max={100}
                    class="mb-3"
                    height="h-0.5"
                    meter="bg-yellow-600"
                />
                <!-- total mileage
                      <p><strong>Total</strong>: {totalMiles} miles</p>
                      -->
            </div>
        {/if}
    </div>

    <div class="">
        <div class="card p-4 ">
            <h3 class="text-2xl font-semibold mb-4 pb-0">
                📈 Last 12 Weeks Intervention
                <span class="text-xs hidden xl:inline-flex"
                    ><i>rolling average</i></span
                >
            </h3>
            <div style="width: 100%;">
                <Chart data={rollingAverages} />
            </div>
        </div>
    </div>
</div>
<hr class="my-4" />

<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
    <div class="card p-4 gap-4 space-x-4">
        <span class="text-xl">🚗 {currentMonth} </span>
        <span class="text-xl"><strong> {mileageThisMonth} </strong></span>
        <span class="text-sm"> <i>{milesThisMonth} miles</i></span>
    </div>
    <!-- mileage last month -->
    <div class="card p-4 gap-4 space-x-4">
        <span class="text-xl">🚘 {lastMonth} </span>
        <span class="text-xl"><strong> {mileageLastMonth} </strong></span>
        <span class="text-sm"> <i>{milesLastMonth} miles</i></span>
    </div>
</div>

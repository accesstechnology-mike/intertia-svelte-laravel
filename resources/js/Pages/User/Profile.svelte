<script>
    export let user;
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

    //this month title
    let thisMonth = new Date().toLocaleString("default", { month: "long" });
    //previous month title
    let lastMonth = new Date(
        new Date().setMonth(new Date().getMonth() - 1)
    ).toLocaleString("default", { month: "long" });

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
    <div class="flex-auto">
        <h1 class="pb-2">{pageName}</h1>
        <h3 class="pb-2">{user.roles[0].name}</h3>
        <p>🏠 {user.postcode}</p>
    </div>

    <div class="flex-initial w-28">
        <Avatar src={user.avatar} alt={user.name} width="100%" />
    </div>
</div>

<div class="flex flex-wrap">
    <div class="w-full sm:w-1/2">
        <hr class="mb-4" />
        <!-- hide section if role is Technician or Assistant or Admin -->
        {#if user.roles[0].name != "AT Technician" && user.roles[0].name != "AT Assistant" && user.roles[0].name != "AT Admin"}
            <h3 class="pb-1">🥰<strong> {clientCount} clients</strong></h3>

            //breakdown of weighting / statuses etc.

            <hr class="mt-8 mb-0 pb-0" />

            <br />
        {/if}

        <!-- hide section if role is  Admin -->
        {#if user.role != "Admin"}
            <span class="text-lg"
                >Client Intervention: <strong>{equivHoursThisQuarter}</strong>
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
        {/if}
    </div>
    <div class="w-full sm:w-1/2">
        <hr class="mb-4" />
        <h3 class="text-2xl font-semibold mb-4 pb-0">
            📈 Last 12 Weeks Intervention <span class="text-xs"
                ><i>rolling average</i></span
            >
        </h3>
        <div style="width: 100%; height: 200px;">
            <Chart data={rollingAverages} />
        </div>
    </div>
</div>

<div class="flex-1 flex-row">
    <div>
        <hr class="my-4" />
        <span class="text-xl"
            >🚗 {thisMonth}: <strong> {mileageThisMonth} </strong></span
        ><span class="text-sm"> <i>{milesThisMonth} miles</i></span>
        <!-- mileage last month -->
        <p class="mt-4">
            {lastMonth}: {mileageLastMonth}
            <span class="text-sm"> <i>{milesLastMonth} miles</i></span>
        </p>
    </div>
</div>

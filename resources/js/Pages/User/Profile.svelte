<script>
    export let user;

    export let viewAsRole;

    let displayedRole = viewAsRole ? viewAsRole : user.roles[0].name;

    export let milesThisMonth;
    export let milesLastMonth;
    export let timeWithCompany;
    export let percentEquivHoursThisQuarter;
    export let percentOfQuarter;
    export let userTarget;
    export let equivHoursThisQuarter;
    export let clientCount;
    export let totalClientCount;
    export let rollingAverages;
    export let clients;

    import { sortAndGroupClients } from "../../utils.js";
    import { statusMapping } from "../../statusMapping.js";

    import Chart from "../../Components/Profile/Chart.svelte";

    let mileageThisMonth = (milesThisMonth * 0.45).toLocaleString("en-GB", {
        style: "currency",
        currency: "GBP",
    });
    let mileageLastMonth = (milesLastMonth * 0.45).toLocaleString("en-GB", {
        style: "currency",
        currency: "GBP",
    });

    const groupedClients = sortAndGroupClients(clients);

    //equivHoursThisQuarter to zero decimal places
    equivHoursThisQuarter = equivHoursThisQuarter;

    //currentTarget as percertofQuarter of userTarget
    let currentTarget = ((userTarget * percentOfQuarter) / 100).toFixed(1);

    //onTarget equivHoursThisQuarter/currentTarget to 1 decimal place
    let onTarget = (equivHoursThisQuarter / currentTarget).toFixed(1);

    let pageName = user.name;

    import { Avatar } from "@skeletonlabs/skeleton";
    import { ProgressBar } from "@skeletonlabs/skeleton";

    user.avatar = user.avatar.replace("?sz=50", "?sz=200");

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

    let face;
    //if ontarget is greater than 1, let emotion be

    if (onTarget >= 1) {
        face = "🥳";
    } else {
        face = "";
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
        <p>🏠 {user.postcode} | 📅 {timeWithCompany}</p>
    </div>

    <div class="flex-initial w-28">
        <Avatar src={user.avatar} alt={user.name} width="100%" />
    </div>
</div>
<hr class="mb-4" />

<div class="grid grid-cols-1 gap-4 lg:grid-cols-2 flex flex-col">
    <div class="flex-1 flex flex-col">
        <!-- hide section if role is Technician or Assistant or Admin -->
        {#if displayedRole != "AT Technician" && displayedRole != "AT Assistant" && displayedRole != "AT Admin"}
            <div class="card p-4 w-full mb-3 flex-grow flex-shrink">
                <h3 class="pb-1 mb-1">
                    🥰<strong> {clientCount} clients</strong>
                    <span class="text-xs"> / {totalClientCount}</span>
                </h3>
                <table>
                    <tbody class="text-sm">
                        {#each Object.keys(groupedClients) as status}
                            <tr>
                                <td class="pl-1 pr-4"
                                    >{groupedClients[status].length}</td
                                >
                                <td>{statusMapping[status]}</td>
                            </tr>
                        {/each}
                    </tbody>
                </table>
            </div>
        {/if}

        <!-- hide section if role is Admin -->
        {#if displayedRole != "Admin"}
            <div class="card px-4 pt-3 pb-1 flex-grow flex-shrink">
                <span class="text-lg mt-12"
                    >Client Intervention: <strong
                        >{equivHoursThisQuarter}</strong
                    >
                </span>hrs
                {face}
                <ProgressBar
                    label="Progress Bar"
                    value={percentEquivHoursThisQuarter}
                    max={100}
                    class="mb-2"
                    height="h-2.5"
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
                    height="h-2.5"
                    meter="bg-yellow-600"
                />
                <!-- total mileage
                      <p><strong>Total</strong>: {totalMiles} miles</p>
                      -->
            </div>
        {/if}
    </div>

    <div class="flex-1 flex flex-col">
        <div class="card p-4 h-full">
            <h3 class="text-2xl font-semibold mb-4 pb-0">
                📈 Last 12 Weeks Intervention
                <span class="text-xs hidden xl:inline-flex"
                    ><i>rolling average</i></span
                >
            </h3>
            <div class="">
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

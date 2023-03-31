<script>
    import { onMount } from "svelte";
    import axios from "axios";
    import { statusMapping } from "../statusMapping"; // Import the shared mapping

    let isLoading = true;
    let groupedClients = {};

    async function loadClients() {
        try {
            isLoading = true;
            const response = await axios.get("/api/clients");
            let clients = response.data;
            groupedClients = sortAndGroupClients(clients);
            isLoading = false;
        } catch (error) {
            console.error(error);
        }
    }

    function sortAndGroupClients(clientsArray) {
        const customOrder = [
            "newClient",
            "assessmentScheduled",
            "initialAssessment",
            "awaiting",
            "setup",
            "ongoing",
            "review",
            "yearly",
        ];

        let sortedClients = clientsArray.sort((a, b) => {
            const statusOrderDiff =
                customOrder.indexOf(a.client_status) -
                customOrder.indexOf(b.client_status);

            return statusOrderDiff !== 0
                ? statusOrderDiff
                : a.name.localeCompare(b.name);
        });

        return customOrder.reduce((acc, status) => {
            acc[status] = sortedClients.filter(
                (client) => client.client_status === status
            );
            return acc;
        }, {});
    }

    onMount(loadClients);

    async function updateClientStatus(client, event) {
        const newStatus = event.target.value;
        try {
            await axios.patch(`/api/clients/${client.id}`, {
                client_status: newStatus,
            });
            client.client_status = newStatus;
            groupedClients = sortAndGroupClients(
                Object.values(groupedClients).flat()
            );
        } catch (error) {
            console.error(error);
        }
    }
</script>

{#if isLoading}
    <p>Loading...</p>
{:else}
    <div class="">
        {#each Object.keys(groupedClients) as status}
            {#if groupedClients[status].length > 0}
                <h2>{statusMapping[status]}</h2>
                {#each groupedClients[status] as client}
                    <div class="card p-3">
                        <h3>{client.name}</h3>
                        <select
                            class="select"
                            value={client.client_status}
                            on:change={(event) =>
                                updateClientStatus(client, event)}
                        >
                            {#each Object.keys(statusMapping) as key}
                                <option value={key}>{statusMapping[key]}</option
                                >
                            {/each}
                        </select>
                    </div>
                    <hr />
                {/each}
            {/if}
        {/each}
    </div>
{/if}

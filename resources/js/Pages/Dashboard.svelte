<script lang="ts">
    import { onMount } from "svelte";
    import { statusMapping } from "../statusMapping"; // Import the shared mapping
    import { sortAndGroupClients } from "../utils.js";
    import axios from "axios";

    import { modalStore } from "@skeletonlabs/skeleton";
    import ClientStatusModal from "../Components/Dashboard/ClientStatusModal.svelte";

    export let clients = [];

    let isLoading = true;
    let groupedClients = {};

    onMount(() => {
        groupedClients = sortAndGroupClients(clients);
        isLoading = false;
    });

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
    function openModal(clientToEdit) {
        const modalComponent = {
            ref: ClientStatusModal,
            props: {
                client: clientToEdit,
                onUpdateClientStatus: updateClientStatus,
            },
        };

        modalStore.trigger({
            type: "component",
            component: modalComponent,
            title: "Update Client Status",
            body: "Select a new status for the client:",
        });
    }
</script>

{#if isLoading}
    <p>Loading...</p>
{:else}
    <div class="">
        {#each Object.keys(groupedClients) as status}
            {#if groupedClients[status].length > 0}
                <h3 class="pt-3 pb-2">{statusMapping[status]}</h3>
                <hr class="pb-4" />
                <!-- insert tailwind grid -->
                <div class="grid grid-cols-1 gap-4">
                    {#each groupedClients[status] as client}
                        <div class="card p-3 card-hover">
                            <h3>{client.name}</h3>
                            <button
                                class="btn"
                                on:click={() => openModal(client)}
                            >
                                Change Status
                            </button>
                        </div>
                    {/each}
                </div>
            {/if}
        {/each}
    </div>
{/if}

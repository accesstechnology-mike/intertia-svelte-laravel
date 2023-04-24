<script lang="ts">
    import { onMount } from "svelte";
    import axios from "axios";
    import { statusMapping } from "../statusMapping"; // Import the shared mapping

    import { Modal, modalStore } from "@skeletonlabs/skeleton";
    import type { ModalSettings, ModalComponent } from "@skeletonlabs/skeleton";
    import ClientStatusModal from "../Components/Dashboard/ClientStatusModal.svelte";

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

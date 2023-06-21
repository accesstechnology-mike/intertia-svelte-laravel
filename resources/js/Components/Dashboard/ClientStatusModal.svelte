<script>
    import { ListBox, ListBoxItem, modalStore } from "@skeletonlabs/skeleton";
    import { statusMapping } from "../../statusMapping"; // Import the shared mapping
    import Fa from "svelte-fa";

    import { faXmark } from "@fortawesome/free-solid-svg-icons";

    export let client;
    export let onUpdateClientStatus;

    function onFormSubmit(newStatus) {
        onUpdateClientStatus(client, { target: { value: newStatus } });
        modalStore.close();
    }
</script>

<div class="card p-4 w-modal shadow-xl relative ">
    <button
        class="btn-icon variant-soft absolute top-8 right-8"
        on:click={modalStore.close}
    >
        <Fa icon={faXmark} />
    </button>
    <!-- <button class="btn" on:click={modalStore.close}>Cancel</button> -->

    <ListBox class="border border-surface-500 p-4 rounded-container-token">
        {#each Object.keys(statusMapping) as key}
            <ListBoxItem
                name={key}
                value={key}
                on:click={() => onFormSubmit(key)}
            >
                {statusMapping[key]}
            </ListBoxItem>
        {/each}
    </ListBox>
    <!-- prettier-ignore -->
</div>

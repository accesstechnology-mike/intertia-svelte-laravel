<script>
    // Props
    /** Exposes parent props to this component. */
    // export let parent: any;

    export let client;
    export let onUpdateClientStatus;

    // Stores
    import { modalStore } from "@skeletonlabs/skeleton";
    import { statusMapping } from "../../statusMapping"; // Import the shared mapping

    // We've created a custom submit function to pass the response and close the modal.
    function onFormSubmit(newStatus) {
        onUpdateClientStatus(client, newStatus);
        modalStore.close();
    }

    // Base Classes
    const cBase = "card p-4 w-modal shadow-xl space-y-4";
    const cHeader = "text-2xl font-bold";
    const cForm =
        "border border-surface-500 p-4 space-y-4 rounded-container-token";
</script>

<div>
    <!-- Enable for debugging: -->
    <!-- <pre>{JSON.stringify(formData, null, 2)}</pre> -->
    <form class="modal-form {cForm}">
        {#each Object.keys(statusMapping) as key}
            <button
                class="btn"
                type="button"
                on:click={() => onFormSubmit(key)}
            >
                {statusMapping[key]}
            </button>
        {/each}
    </form>
    <!-- prettier-ignore -->
    <footer class="modal-footer {parent.regionFooter}">
        <button class="btn {parent.buttonNeutral}" on:click={parent.onClose}>{parent.buttonTextCancel}</button>
        <button class="btn {parent.buttonPositive}" on:click={onFormSubmit}>Submit Form</button>
    </footer>
</div>

<script>
    export let success;
</script>

{#if success}
    <div class="bg-green-500 text-white px-4 py-2 mb-4">
        {success}
        <button
            class="ml-4 text-white focus:outline-none"
            on:click={() => Inertia.reload({ only: ["success"] })}
        >
            ×
        </button>
    </div>
{/if}

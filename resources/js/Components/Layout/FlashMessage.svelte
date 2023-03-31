<script>
    import { onDestroy, afterUpdate } from "svelte";

    export let message;
    export let type;

    let show = false;

    if (message) {
        show = true;
        setTimeout(() => (show = false), 5000);
    }

    onDestroy(() => {
        show = false;
    });
</script>

{#if show}
    <div class="fixed top-0 z-50">
        <div
            class={`flash-message bg-${
                type === "success" ? "green" : "red"
            }-500 text-white px-4 py-2 rounded`}
        >
            {message}
        </div>
    </div>
{/if}

<style>
    .flash-message {
        animation: flash-message-animation 5s;
        opacity: 0;
    }

    @keyframes flash-message-animation {
        0% {
            opacity: 0;
        }
        10% {
            opacity: 1;
        }
        90% {
            opacity: 1;
        }
        100% {
            opacity: 0;
        }
    }
</style>

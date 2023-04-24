<script>
    import { Inertia } from "@inertiajs/inertia";
    import axios from "axios";

    export let clients;

    let formData = {
        client_id: "",
        amount: "",
        type: "",
        start_date: "",
    };

    function handleSubmit() {
        axios.post("/asp", formData).then(() => {
            Inertia.visit("/asp");
        });
    }
</script>

<h1>Create Client</h1>
<form on:submit|preventDefault={handleSubmit}>
    <label class="label">
        Client
        <select class="select" bind:value={formData.client_id} required>
            {#each clients as client (client.id)}
                <option value={client.id}>{client.name}</option>
            {/each}
        </select>
    </label>

    <label class="label">
        Amount
        <input
            class="input"
            type="number"
            step="0.01"
            bind:value={formData.amount}
            required
        />
    </label>
    <label class="label">
        Type
        <select class="select" bind:value={formData.type} required>
            <option value="Standard">Standard</option>
            <option value="DWB">DWB</option>
        </select>
    </label>
    <label class="label">
        Start Date
        <input
            class="input"
            type="date"
            bind:value={formData.start_date}
            required
        />
    </label>
    
    <button class="btn variant-filled mt-3" type="submit">Create</button>
</form>

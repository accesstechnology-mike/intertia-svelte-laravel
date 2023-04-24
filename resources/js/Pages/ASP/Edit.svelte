<script>
    import { Inertia } from "@inertiajs/inertia";
    import { page } from "@inertiajs/svelte";
    import axios from "axios";

    let entry = $page.entry;
    let formData = {
        client_id: entry.client_id,
        user_id: entry.user_id,
        amount: entry.amount,
        type: entry.type,
        start_date: entry.start_date,
        end_date: entry.end_date,
    };

    function handleSubmit() {
        axios.put(`/asp/${entry.id}`, formData).then(() => {
            Inertia.visit("/asp");
        });
    }
</script>

<h1>Edit Client</h1>
<form on:submit|preventDefault={handleSubmit}>
    <label>
        Client ID
        <input type="number" bind:value={formData.client_id} required />
    </label>
    <label>
        Amount
        <input
            type="number"
            step="0.01"
            bind:value={formData.amount}
            required
        />
    </label>
    <label>
        Type
        <select bind:value={formData.type} required>
            <option value="Standard">Standard</option>
            <option value="DWB">DWB</option>
        </select>
    </label>
    <label>
        Start Date
        <input type="date" bind:value={formData.start_date} required />
    </label>
    <label>
        End Date
        <input type="date" bind:value={formData.end_date} required />
    </label>
    <button type="submit">Update</button>
</form>

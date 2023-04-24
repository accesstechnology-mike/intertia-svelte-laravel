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
    <!-- Add form inputs for each field -->
    <button type="submit">Update</button>
</form>

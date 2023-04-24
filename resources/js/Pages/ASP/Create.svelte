<script>
    import { Inertia } from "@inertiajs/inertia";
    import axios from "axios";

    let formData = {
        client_id: "",
        user_id: "",
        amount: "",
        type: "",
        start_date: "",
        end_date: "",
    };

    function handleSubmit() {
        axios.post("/asp", formData).then(() => {
            Inertia.visit("/asp");
        });
    }
</script>

<h1>Create Client</h1>
<form on:submit|preventDefault={handleSubmit}>
    <!-- Add form inputs for each field -->
    <button type="submit">Create</button>
</form>
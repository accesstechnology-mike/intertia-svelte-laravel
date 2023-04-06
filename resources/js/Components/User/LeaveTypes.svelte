<script>
    import axios from "axios";

    let leaveTypes = [];
    let form = { name: "", description: "", color: "" };

    async function fetchLeaveTypes() {
        const response = await axios.get("/api/leave-types");
        leaveTypes = response.data;
    }

    async function handleSubmit() {
        await axios.post("/api/leave-types", form);
        fetchLeaveTypes();
    }

    async function handleUpdate(id) {
        await axios.put(`/api/leave-types/${id}`, form);
        fetchLeaveTypes();
    }

    async function handleDelete(id) {
        await axios.delete(`/api/leave-types/${id}`);
        fetchLeaveTypes();
    }

    onMount(() => {
        fetchLeaveTypes();
    });
</script>

<!-- Display fetched leave types in a table -->
<!-- Add form for creating and updating leave types -->
<!-- Add delete button to delete a leave type -->

<!-- Add corresponding logic for the Holidays.svelte component -->

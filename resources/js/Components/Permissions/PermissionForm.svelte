<script>
    let permissionName = "";

    function handleSubmit() {
        if (permissionName.trim()) {
            Inertia.post("/permissions", { name: permissionName });
            permissionName = "";
        }
    }
</script>

<div>
    <h2 class="text-2xl mb-4">Add Permission</h2>
    <form on:submit|preventDefault={handleSubmit}>
        <div class="mb-4">
            <label for="permissionName" class="block mb-2"
                >Permission Name</label
            >
            <input
                type="text"
                id="permissionName"
                bind:value={permissionName}
                class="border px-2 py-1 w-full"
            />
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2"
            >Add Permission</button
        >
    </form>
</div>

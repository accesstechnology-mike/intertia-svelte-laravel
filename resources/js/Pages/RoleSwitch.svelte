<!-- resources/js/Pages/RoleSwitch.svelte -->
<script>
    import axios from "axios";
    import { onMount } from "svelte";
    
    let roles = [];
    let selectedRole;

    onMount(async () => {
        const response = await axios.get("/api/roles");
        roles = response.data;
        selectedRole = roles[0].name;
    });

    const switchRole = async (event) => {
        event.preventDefault();
        const response = await axios.post("/api/role-switch", {
            role: selectedRole,
        });

        // Redirect to the specified URL
        window.location.href = response.data.redirect;
    };
</script>

<div class="container mx-auto py-4">
    <div class="card p-4 w-full sm:w-1/2 mx-auto">
        <h1 class="text-xl mb-4">Switch Role</h1>
        <form on:submit={switchRole}>
            <div class="mb-4">
                <label for="role" class="label">Role</label>
                <select id="role" class="select" bind:value={selectedRole}>
                    {#each roles as role}
                        <option value={role.name}>{role.name}</option>
                    {/each}
                </select>
            </div>
            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded"
            >
                Switch Role
            </button>
        </form>
    </div>
</div>

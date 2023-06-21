<script>
    import axios from "axios";
    export let user;
    export let roles;
    export let userRoles;

    function handleRoleChange(role, e) {
        const route = e.target.checked
            ? `/users/${user.id}/assign-role/${role.id}`
            : `/users/${user.id}/remove-role/${role.id}`;

        axios.post(route);
    }
</script>

<div>
    <h2 class="text-2xl mb-4">Roles</h2>
    <ul>
        {#each roles as role}
            <li class="mb-2">
                <label class="inline-flex items-center">
                    <input
                        type="checkbox"
                        class="form-checkbox"
                        checked={userRoles.includes(role.name)}
                        on:change={(e) => handleRoleChange(role, e)}
                    />
                    <span class="ml-2">{role.name}</span>
                </label>
            </li>
        {/each}
    </ul>
</div>

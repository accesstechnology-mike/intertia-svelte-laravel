<script>
    import axios from "axios";

    export let user;
    export let permissions;
    export let userPermissions;

    function handlePermissionChange(permission, e) {
        const route = e.target.checked
            ? `/users/${user.id}/give-permission/${permission.id}`
            : `/users/${user.id}/revoke-permission/${permission.id}`;

        axios.post(route);
    }
</script>

<div>
    <h2 class="text-2xl mb-4">Permissions</h2>
    <ul>
        {#each permissions as permission}
            <li class="mb-2">
                <label class="inline-flex items-center">
                    <input
                        type="checkbox"
                        class="form-checkbox"
                        checked={userPermissions.includes(permission.name)}
                        on:change={(e) => handlePermissionChange(permission, e)}
                    />
                    <span class="ml-2">{permission.name}</span>
                </label>
            </li>
        {/each}
    </ul>
</div>

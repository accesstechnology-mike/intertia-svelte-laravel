<script>
    
    import UserRoles from "../../Components/User/UserRoles.svelte";
    import UserPermissions from "../../Components/User/UserPermissions.svelte";

    export let user;
    export let roles;
    export let permissions;
    export let userRoles;
    export let userPermissions;
</script>

<div class="container mx-auto p-4">
    <h1 class="text-4xl mb-4">Manage Roles and Permissions for {user.name}</h1>

    <UserRoles {user} {roles} {userRoles} />
    <!-- <UserPermissions {user} {permissions} {userPermissions} /> -->
</div>

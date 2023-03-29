<script>
    import PermissionList from "../../Components/Permissions/PermissionList.svelte";
    import PermissionForm from "../../Components/Permissions/PermissionForm.svelte";
    import FlashMessage from "../../Components/FlashMessage.svelte";

    export let permissions;
</script>

<div class="container mx-auto p-4">
    <h1 class="text-4xl mb-4">Spatie Permissions Manager</h1>

    <FlashMessage {success} />

    <PermissionList {permissions} />
    <PermissionForm />
</div>

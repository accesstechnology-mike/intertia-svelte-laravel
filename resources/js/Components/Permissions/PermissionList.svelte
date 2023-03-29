<script>
    export let permissions;
</script>

<div>
    <h2 class="text-2xl mb-4">Permissions</h2>
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Name</th>
            </tr>
        </thead>
        <tbody>
            {#each permissions as permission (permission.id)}
                <tr>
                    <td class="border px-4 py-2">{permission.id}</td>
                    <td class="border px-4 py-2">{permission.name}</td>
                </tr>
            {/each}
        </tbody>
    </table>
</div>

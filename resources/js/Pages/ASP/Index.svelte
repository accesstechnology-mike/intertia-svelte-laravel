<script>
    import { InertiaLink } from "@inertiajs/svelte";
    import { page } from "@inertiajs/svelte";

    const clients = $page.clients;
</script>

<h1>Clients</h1>
<InertiaLink href="/asp/create" class="button">Create New Client</InertiaLink>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Client ID</th>
            <th>User ID</th>
            <th>Amount</th>
            <th>Type</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        {#each clients as client (client.id)}
            <tr>
                <td>{client.id}</td>
                <td>{client.client_id}</td>
                <td>{client.user_id}</td>
                <td>{client.amount}</td>
                <td>{client.type}</td>
                <td>{client.start_date}</td>
                <td>{client.end_date}</td>
                <td>
                    <InertiaLink href={`/asp/${client.id}/edit`} class="button"
                        >Edit</InertiaLink
                    >
                </td>
            </tr>
        {/each}
    </tbody>
</table>

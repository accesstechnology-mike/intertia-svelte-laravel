<script>
    import axios from "axios";
    import { onMount } from "svelte";

    let holidays = [];
    let form = { date: "", name: "", type: "" };

    async function fetchHolidays() {
        const response = await axios.get("/api/holidays");
        holidays = response.data;
    }

    async function handleSubmit() {
        await axios.post("/api/holidays", form);
        fetchHolidays();
    }

    async function handleUpdate(id) {
        await axios.put(`/api/holidays/${id}`, form);
        fetchHolidays();
    }

    async function handleDelete(id) {
        await axios.delete(`/api/holidays/${id}`);
        fetchHolidays();
    }

    onMount(() => {
        fetchHolidays();
    });
</script>

<!-- Display fetched holidays in a table -->
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Name</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        {#each holidays as holiday}
            <tr>
                <td>{holiday.date}</td>
                <td>{holiday.name}</td>
                <td>{holiday.type}</td>
                <td>
                    <button on:click={() => handleUpdate(holiday.id)}
                        >Update</button
                    >
                    <button on:click={() => handleDelete(holiday.id)}
                        >Delete</button
                    >
                </td>
            </tr>
        {/each}
    </tbody>
</table>
<!-- Add form for creating and updating holidays -->
<form on:submit|preventDefault={handleSubmit}>
    <label for="date">Date</label>
    <input type="date" id="date" bind:value={form.date} required />
    <label for="name">Name</label>
    <input type="text" id="name" bind:value={form.name} required />

    <label for="type">Type</label>
    <select id="type" bind:value={form.type}>
        <option value="public">Public Holiday</option>
        <option value="company">Company Holiday</option>
    </select>

    <button type="submit">Submit</button>
</form>

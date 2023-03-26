<script>
    import { onMount } from 'svelte';
    import axios from 'axios';

    let clients = [];
  
    onMount(async () => {

    try {
        const response = await axios.get('/api/clients');
        clients = response.data;
      } catch (error) {
        console.error(error);
      }
    });

    async function updateClientStatus(client, event) {
    const newStatus = event.target.value;
    try {
      await axios.patch(`/api/clients/${client.id}`, { client_status: newStatus });
      client.client_status = newStatus;
    } catch (error) {
      console.error(error);
    }
  }
</script>

<div>
    {#each clients as client}
      <div class="client-card">
        <h3>{client.name}</h3>
        <select value={client.client_status} on:change={(event) => updateClientStatus(client, event)}>
            <option value="newClient">New Client</option>
            <option value="assessmentScheduled">Assessment Scheduled</option>
            <option value="initialAssessment">Initial Assessment</option>
            <option value="awaiting">Awaiting approval</option>
            <option value="setup">Setup following initial recommendations</option>
            <option value="ongoing">Ongoing intervention</option>
            <option value="review">4 monthly observation and review only</option>
            <option value="yearly">Yearly observation and review only</option>
        </select>
      </div>
      <hr>
    {/each}
</div>
    
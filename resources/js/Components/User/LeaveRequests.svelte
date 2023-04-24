<script>
  import axios from 'axios';
  import { Inertia } from '@inertiajs/inertia';

  let leaveRequests = [];
  let form = { user_id: '', leave_type_id: '', start_date: '', end_date: '', status: '' };

  async function fetchLeaveRequests() {
    const response = await axios.get('/api/leave-requests');
    leaveRequests = response.data;
  }

  async function handleSubmit() {
    await axios.post('/api/leave-requests', form);
    fetchLeaveRequests();
  }

  async function handleUpdate(id) {
    await axios.put(`/api/leave-requests/${id}`, form);
    fetchLeaveRequests();
  }

  async function handleDelete(id) {
    await axios.delete(`/api/leave-requests/${id}`);
    fetchLeaveRequests();
  }

  onMount(() => {
    fetchLeaveRequests();
  });
</script>

<div>
    
<!-- Display fetched leave requests in a table -->


<!-- Add form for creating and updating leave requests -->

<!-- Add delete button to delete a leave request -->

<!-- Add corresponding logic for the LeaveTypes.svelte and Holidays.svelte components -->

</div>
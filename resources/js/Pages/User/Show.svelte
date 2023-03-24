<!-- svelte-ignore missing-declaration -->
<svelte:head>
    <title> {pageName} </title>
</svelte:head>


<script>
  
    export let user
    export let milesThisMonth
    export let milesLastMonth
    export let totalMiles
    export let percentEquivHoursThisQuarter
    export let percentOfQuarter
    export let userTarget
    export let equivHoursThisQuarter
    export let clientCount

    let mileageThisMonth = (milesThisMonth*0.45).toLocaleString('en-GB', {style: 'currency', currency: 'GBP'})
    let mileageLastMonth = (milesLastMonth*0.45).toLocaleString('en-GB', {style: 'currency', currency: 'GBP'})

    //equivHoursThisQuarter to zero decimal places
    equivHoursThisQuarter = Math.round(equivHoursThisQuarter)

    //currentTarget as percertofQuarter of userTarget
    let currentTarget = (userTarget*percentOfQuarter/100)

    //onTarget equivHoursThisQuarter/currentTarget to 1 decimal place
    let onTarget = (equivHoursThisQuarter/currentTarget).toFixed(1)
    
    
    
    let pageName=user.name;

    import { Avatar } from '@skeletonlabs/skeleton';
    import { ProgressBar } from '@skeletonlabs/skeleton';
    user.avatar = user.avatar.replace('?sz=50', '?sz=400')

    //this month title
    let thisMonth = new Date().toLocaleString('default', { month: 'long' });
    //previous month title
    let lastMonth = new Date(new Date().setMonth(new Date().getMonth() - 1)).toLocaleString('default', { month: 'long' });


    // import { onMount } from 'svelte';

    // onMount(() => {
    //   // Pass the title for this page to the Layout component
    //   $page.props.pageTitle = 'Home';
    // });

  </script>

  <!-- MOBILE LAYOUT IS SCREWED NEEDS FIXING -->

  <div class="flex">
    <div class="grow">
      <h1>{pageName}</h1>
      <h3>{user.role}</h3>
      <p><strong>Postcode</strong>: {user.postcode}</p>
      <hr class="mb-4">
      <!-- hide section if role is Technician or Assistant or Admin -->
      {#if user.role != 'Technician' && user.role != 'Assistant' && user.role != 'Admin'}
      <h3><strong> {clientCount} clients</h3>
      {/if}

      <!-- hide section if role is  Admin -->
      {#if user.role != 'Admin'}
     
        Expected {currentTarget} hrs - <i>of {userTarget} total </i>
        <ProgressBar label="Minimum" value={percentOfQuarter} max={100} class="mb-1"/>
          Currently {equivHoursThisQuarter} hrs - <i>{onTarget} of expected </i>
        <ProgressBar label="Progress Bar" value={percentEquivHoursThisQuarter} max={100} class="mb-6"/>
        <hr class="mb-4">
        
      <p><strong>{thisMonth} mileage to date</strong>: {mileageThisMonth} ({milesThisMonth} miles)</p>
      <!-- mileage last month -->
      <p><strong>{lastMonth} mileage</strong>: {mileageLastMonth} ({milesLastMonth} miles)</p>

      
      <!-- total mileage -->
      <p><strong>Total miles driven</strong>: {totalMiles} miles</p>
      <hr class="mb-4">
      {/if}

    
    </div>

    
    <div class="mr-4 pl-8"><Avatar src="{user.avatar}" alt={user.name} width="w-48"/></div>

  </div>





  
  
    





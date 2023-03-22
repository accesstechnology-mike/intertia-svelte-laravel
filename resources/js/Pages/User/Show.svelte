<!-- svelte-ignore missing-declaration -->
<svelte:head>
    <title> {pageName} </title>
</svelte:head>


<script>
  
    export let user

    let pageName=user.name;

    import { Avatar } from '@skeletonlabs/skeleton';
    user.avatar = user.avatar.replace('?sz=50', '?sz=400')

    // import { onMount } from 'svelte';

    // onMount(() => {
    //   // Pass the title for this page to the Layout component
    //   $page.props.pageTitle = 'Home';
    // });

  </script>

    <p>Hello {user.name}</p>

    <Avatar src="{user.avatar}" alt={user.name} width="w-32" />





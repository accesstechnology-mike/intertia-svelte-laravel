

<script>
// Your selected Skeleton theme:
import '@skeletonlabs/skeleton/themes/theme-skeleton.css';

// This contains the bulk of Skeletons required styles:
import '@skeletonlabs/skeleton/styles/all.css';

// Finally, your application's global stylesheet (sometimes labeled 'app.css')
import '../../css/app.css';

import { AppShell } from '@skeletonlabs/skeleton';
import { Drawer, drawerStore } from '@skeletonlabs/skeleton';

import Appbar from './Appbar.svelte';
import Sidebar from '../Components/Sidebar.svelte';

export let pageTitle = 'access: log';

</script>

<Drawer>
	<Sidebar />
</Drawer>

<AppShell slotSidebarLeft="bg-surface-500/5 w-0 lg:w-56" slotPageHeader="page-padding">

	<svelte:fragment slot="header"><Appbar/></svelte:fragment>
	<svelte:fragment slot="sidebarLeft"><Sidebar/></svelte:fragment> 

    <div class="page-padding">
    <slot />

    

    
  </div>


</AppShell>



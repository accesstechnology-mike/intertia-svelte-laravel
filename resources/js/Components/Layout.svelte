<script>
// Your selected Skeleton theme:
import '@skeletonlabs/skeleton/themes/theme-hamlindigo.css';

// This contains the bulk of Skeletons required styles:
import '@skeletonlabs/skeleton/styles/all.css';

// Finally, your application's global stylesheet (sometimes labeled 'app.css')
import '../../css/app.css';

import Navbar from '../Components/Navbar.svelte';
import { LightSwitch } from '@skeletonlabs/skeleton';

</script>

<main>
    <header>


      <Navbar/>
      <LightSwitch />
    
    </header>
 
      <slot />
   
  </main>


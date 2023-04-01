<script lang="ts">
    // Your selected Skeleton theme:
    import "@skeletonlabs/skeleton/themes/theme-skeleton.css";

    // This contains the bulk of Skeletons required styles:
    import "@skeletonlabs/skeleton/styles/all.css";

    // Finally, your application's global stylesheet (sometimes labeled 'app.css')
    import "../../../css/app.css";

    import { AppShell } from "@skeletonlabs/skeleton";
    import { Drawer, drawerStore } from "@skeletonlabs/skeleton";
    import { Modal, modalStore } from "@skeletonlabs/skeleton";
    import type { ModalSettings, ModalComponent } from "@skeletonlabs/skeleton";

    import Appbar from "./Appbar.svelte";
    import Sidebar from "./Sidebar.svelte";
    export let pageTitle = "access: log";

    import { page } from "@inertiajs/svelte";

    //console log page
    console.log($page);

    let user = $page.props.auth.user;
    let viewAsRole = $page.props.auth.viewAsRole;
    let role = user ? (viewAsRole ? viewAsRole : user.roles[0].name) : "";
    let currentPage = $page.url;

    //import flashmessage component
    import FlashMessage from "./FlashMessage.svelte";

    let message;
    let type;

    $: if ($page.props.flash.success) {
        message = $page.props.flash.success;
        type = "success";
    } else if ($page.props.flash.error) {
        message = $page.props.flash.error;
        type = "error";
    }
</script>

<Drawer>
    <Sidebar {role} {currentPage} />
</Drawer>
<Modal />
<AppShell
    slotSidebarLeft="bg-surface-500/5 w-0 lg:w-56"
    slotPageHeader="page-padding"
>
    <svelte:fragment slot="header"><Appbar {currentPage} /></svelte:fragment>
    <svelte:fragment slot="sidebarLeft"
        ><Sidebar {role} {currentPage} /></svelte:fragment
    >

    <div class="page-padding">
        <!-- pass message and type to flashmessage component -->
        <FlashMessage {message} {type} />
        <slot />
    </div></AppShell
>

<script lang="ts">
    import { drawerStore } from "@skeletonlabs/skeleton";

    export let role;
    export let currentPage;

    import Fa from "svelte-fa";
    import { faHouseUser } from "@fortawesome/free-solid-svg-icons";
    import { faUpRightFromSquare } from "@fortawesome/free-solid-svg-icons";
    import { faBook } from "@fortawesome/free-solid-svg-icons";
    import { faUserAltSlash } from "@fortawesome/free-solid-svg-icons";
    function drawerClose() {
        drawerStore.close();
    }

    $: classesActive = (href: string) => {
        if (href === currentPage) {
            return {
                color: "limegreen",
            };
        } else {
            return {};
        }
    };
</script>

<section class="p-4 pb-20 space-y-4 overflow-y-auto">
    <nav class="list-nav p-4 space-y-1">
        <a href="/dashboard">
            <span>
                <Fa
                    icon={faHouseUser}
                    fw
                    {...classesActive("/dashboard")}
                /></span
            >
            <span>Dashboard</span>
        </a>

        <hr />

        <a href="https://handbook.accesstechnology.co.uk" target="_blank">
            <span> <Fa icon={faBook} fw /></span>
            <span>Handbook</span>
            <Fa icon={faUpRightFromSquare} size="xs" class="mt-0.5" />
        </a>
        <!-- 
        <a href="/leave-requests">Leave Requests</a>
        <a href="/leave-types">Leave Types</a>
        <a href="/holidays">Holidays</a> -->

        {#if role === "Super Admin"}
            <hr />

            <a href="/role-switch">
                <span>
                    <Fa
                        icon={faUserAltSlash}
                        fw
                        {...classesActive("/role-switch")}
                    /></span
                >
                <span>Role Switch</span>
            </a>
        {/if}
    </nav>
</section>

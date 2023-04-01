<script lang="ts">
    import { AppBar } from "@skeletonlabs/skeleton";
    import { LightSwitch } from "@skeletonlabs/skeleton";

    import { drawerStore } from "@skeletonlabs/skeleton";

    import Fa from "svelte-fa";
    import { faUser } from "@fortawesome/free-regular-svg-icons";
    import { faXmark } from "@fortawesome/free-solid-svg-icons";

    let src = "/android-chrome-192x192.png";

    export let currentPage;

    function drawerOpen() {
        drawerStore.open({});
    }

    $: classesActive = (href: string) =>
        href === currentPage ? "limegreen" : "";
</script>

<AppBar>
    <svelte:fragment slot="lead">
        <div class="flex items-center">
            <button class="lg:hidden btn btn-sm mr-4" on:click={drawerOpen}>
                <span>
                    <svg viewBox="0 0 100 80" class="fill-token w-4 h-4">
                        <rect width="100" height="20" />
                        <rect y="30" width="100" height="20" />
                        <rect y="60" width="100" height="20" />
                    </svg>
                </span>
            </button>
            <a href="/">
                <button class="btn-icon-sm relative top-1 mr-2">
                    <img {src} alt="" />
                </button>
                <strong class="text-3xl relative bottom-1 hidden md:inline"
                    >access: log</strong
                >
            </a>
        </div>
    </svelte:fragment>
    <svelte:fragment slot="trail">
        <a class="btn-icon variant-soft " href="/profile">
            <Fa icon={faUser} color={classesActive("/profile")} />
        </a>
        <a class="btn-icon variant-soft" href="/logout">
            <Fa icon={faXmark} />
        </a>
        <LightSwitch />
    </svelte:fragment>
</AppBar>

<script>
    import { drawerStore } from "@skeletonlabs/skeleton";

    import Fa from "svelte-fa";
    import { faHouseUser } from "@fortawesome/free-solid-svg-icons";
    import { faUpRightFromSquare } from "@fortawesome/free-solid-svg-icons";
    import { faBook } from "@fortawesome/free-solid-svg-icons";
    function drawerClose() {
        drawerStore.close();
    }
</script>

<section class="p-4 pb-20 space-y-4 overflow-y-auto">
    <nav class="list-nav p-4">
        <ul>
            <li>
                <a href="/dashboard">
                    <span class=""> <Fa icon={faHouseUser} /></span>
                    <span class="flex-auto">Dashboard</span>
                </a>
            </li>

            <hr />
            <li>
                <a href="https://handbook.accesstechnology.co.uk">
                    <span class=""> <Fa icon={faBook} /></span>
                    <span class="flex-auto">Handbook</span>
                    <Fa icon={faUpRightFromSquare} size="xs" class="mt-0.5" />
                </a>
            </li>
        </ul>
    </nav>
</section>

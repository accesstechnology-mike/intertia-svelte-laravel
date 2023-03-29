<script>
    export let users;
</script>

<div
    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4"
>
    {#each users as user}
        <div
            class="w-full pt-5 max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
        >
            <div class="flex flex-col items-center pb-7">
                <img
                    class="w-24 h-24 mb-3 rounded-full shadow-lg"
                    src={user.avatar || "/path/to/default/avatar.jpg"}
                    alt="{user.name} image"
                />
                <h5
                    class="mb-1 pb-1 text-xl font-medium text-gray-900 dark:text-white"
                >
                    {user.name}
                </h5>
                <span class="text-sm text-gray-500 dark:text-gray-400"
                    >{user.roles && user.roles.length > 0
                        ? user.roles[0].name
                        : "N/A"}</span
                >
                <div class="flex mt-4 space-x-1 md:mt-4">
                    <!-- Add links or buttons for specific actions -->
                    <a
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        href={`/users/${user.id}/edit`}>Edit</a
                    >
                </div>
            </div>
        </div>
    {/each}
</div>

<style>
    /* Add custom CSS styles if needed */
</style>

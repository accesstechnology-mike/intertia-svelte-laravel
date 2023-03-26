<script>
    function loginWithGoogle() {
        window.location.href = "/login";
    }
</script>

<button
    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full"
    on:click={loginWithGoogle}
>
    Login with Google
</button>

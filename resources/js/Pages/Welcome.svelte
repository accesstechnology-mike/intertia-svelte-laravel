<script>

let src = './android-chrome-192x192.png'


    import GoogleLoginButton from '../Components/GoogleLoginButton.svelte';

</script>

<div class="grid h-screen place-items-center">


<!--  image with hr -->

    <div class="flex flex-col items-center">
        
            <img src={src} alt="" class="w-32 h-32 rounded-full mr-4"/>
            <h1 class="text-3xl font-bold">access: log</h1>
            <hr class="w-2/3 border-2 border-gray-300 mb-6">
        <GoogleLoginButton />

    </div>

</div>

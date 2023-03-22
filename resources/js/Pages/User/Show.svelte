
<script>
    export let user



    user.avatar = user.avatar.replace('?sz=50', '?sz=400')



  </script>
  
    <p>Hello {user.name}</p>


    <img src={user.avatar} alt={user.name}/>





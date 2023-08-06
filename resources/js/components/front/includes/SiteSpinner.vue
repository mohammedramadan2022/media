<script setup>
    var loader = document.getElementById("preloader");
    window.addEventListener("load", vanish);
    function vanish(){
        loader.classList.add("disappear");
    }
</script>
<template>
    <div id="preloader">
        <div id="loader"></div>
    </div>
</template>

<style>

#preloader{
    display: flex;
    justify-content: center;
    height: 100vh;
    align-items: center;
    width: 100%;
    position: fixed;
    background-color: #fff;
    z-index: 9999999;
}
#loader {
  border: 5px solid #f3f3f3;
  border-radius: 50%;
  border-top: 5px solid #000;
  width: 60px;
  height: 60px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
  }

  @-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

    @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.disappear {
  -webkit-animation: vanish 3s forwards;
          animation: vanish 3s forwards;
          
}

@-webkit-keyframes vanish {
  100% {
    opacity: 0;
    visibility: hidden;
  }
}

@keyframes vanish {
  100% {
    opacity: 0;
    visibility: hidden;
  }
}
</style>

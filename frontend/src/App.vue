<template>
    <transition name="flip" mode="out-in">
        <router-view :key="$route.fullPath"/>
    </transition>
</template>

<script>
export default {
    name: 'app',
}
</script>



<style>
    .flip-enter-active,
    .flip-leave-active
    {
        transition: transform 0.3s ease-out;
    }
    .flip-enter {
        transform: rotateY(90deg);
    }
    .flip-leave-to {
        transform: rotateY(90deg);
    }
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>

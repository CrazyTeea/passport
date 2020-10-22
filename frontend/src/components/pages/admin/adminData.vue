<template>
  <div v-if="ready">
    <nav-bar/>
  </div>

  <loading v-else/>
</template>

<script>
import Loading from "../../organisms/loading";
import NavBar from "../../organisms/NavBar";

export default {
  name: "adminData",
  data() {
    return {
      ready: false
    }
  },
  async mounted() {
    setTimeout(() => {
      this.ready = true
    }, 500)
  },
  components: {NavBar, Loading}
}
</script>

<style scoped>

</style>
<template>
  <div class="spinner-middle">
    <b-spinner class="" variant="success" type="grow"
               label="Spinning"></b-spinner>
  </div>
</template>

<script>
import {BSpinner} from 'bootstrap-vue'
export default {
  name: "loading",
  components:{
    BSpinner
  }
}
</script>

<style scoped>
.spinner-middle {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>
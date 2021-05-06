<template>
  <img class="mb-2" alt="money" :src="warning" width="70px">
</template>

<script>
import warning from "../../assets/images/free-icon-warning-sign-2431845.svg";

export default {
  props: {
    type: {
      default: () => false
    }
  },
  data() {
    return {warning}
  }
}
</script>

<style scoped>

</style>
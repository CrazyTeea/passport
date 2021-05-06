<template>
  <img class="mb-4" alt="money" :src="type ? domikiImg :moneyImg" width="70px">
</template>

<script>
import moneyImg from "../../assets/images/moneyimg.svg";
import domikiImg from "../../assets/images/domiki.svg";

export default {
  props: {
    type: {
      default: () => false
    }
  },
  data() {
    return {moneyImg, domikiImg}
  }
}
</script>

<style scoped>

</style>
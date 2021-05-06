<template>
  <img class="mb-2 ml-2 mt-2" alt="money" :src="icon" width="55px">
</template>

<script>

import icon from '../../assets/images/free-icon-exclamation-mark-3248142.svg'

export default {
  name: "infoIcon",
  data(){
    return {
      icon
    }
  }
}
</script>

<style scoped>

</style>
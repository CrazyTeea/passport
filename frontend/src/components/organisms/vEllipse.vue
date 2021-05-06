<template>
  <div>
    <vue-ellipse-progress
        :id="id"
        font-size="10px"
        animation="loop 700 1000"
        :size="size"
        :progress="progress"
        :legend-value="value"
    >
      <span slot="legend-value"> / {{ maxValue }}</span>
    </vue-ellipse-progress>
    <b-tooltip :target="id">
      Заполнено {{value}} / {{maxValue}}
    </b-tooltip>
  </div>

</template>

<script>

import {BTooltip} from 'bootstrap-vue'

export default {
  name: "vEllipse",
  components: {
    BTooltip
  },
  props: {
    value: {
      required: true
    },
    maxValue: {
      required: true
    },
    size: {
      default: () => 55
    }
  },
  computed: {
    id(){
      return Math.random().toString(36).substring(7);
    },
    progress() {
      return this.value * 100 / this.maxValue;
    }
  }
}
</script>

<style scoped>

</style>
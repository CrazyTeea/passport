<template>
  <div class="row">
    <div class="text-right col-2 mt-4">
      <button class=" btn btn-outline-secondary" type="button" @click="doRequestBack">Назад</button>
    </div>
    <div style="padding-top: 11px" class="col-8 mt-4">
      <div class="progress">
        <div aria-valuemax="100" aria-valuemin="0" :aria-valuenow="percent" class="progress-bar" role="progressbar"
             :style="`width: ${percent}%`"/>
      </div>
    </div>
    <div class="col-2 mt-4">
      <button class="btn btn-outline-primary" type="button" @click="doRequestTo">{{ endButtonLabel }}</button>
    </div>
  </div>
</template>

<script>

export default {
  name: "stepper",
  props: {
    endButtonLabel: {
      required: true
    },
    percent: {
      required: true,
    },
    backUrl: {
      required: true,
    },
    toUrl: {
      required: true,
    },
  },
  methods: {
    doRequestBack() {
      const result = new Promise(resolve => {
        this.$emit('save-page',false ,resolve);
      })
      result.then(res => res ? window.location.href = this.backUrl : '');
    },
    doRequestTo() {
      const result = new Promise(resolve => {
        this.$emit('save-page',true ,resolve);
      })
      result.then(res => res ? window.location.href = this.toUrl : '');


    }
  }
}
</script>

<style scoped>

</style>
<template>
  <div>
    <b-button @click="showModal('export-data')" class="mb-2 float-left">Выгрузка данных</b-button>
    <b-button @click="export_stat" class="mb-2 float-right">Выгрузка статистики</b-button>
    <b-modal size="xl" centered ref="export-data">

    </b-modal>

  </div>
</template>

<script>
import {BButton, BModal} from 'bootstrap-vue'

export default {
  name: "exportModal",
  props: ['filter'],
  components: {
    BButton,
    BModal
  },
  methods: {
    showModal(id) {
      this.$refs[id].show();
    },
    export_stat() {

      let url = new URL( window.location.host);
      url.protocol = window.location.protocol;
      url.host = window.location.host;
      url.pathname = '/app/export/export-stat'

      Object.keys(this.filter).forEach(item => {
        if (this.filter[item])
          url.searchParams.set(item, this.filter[item]);
      })

      console.log(url)

      let win = window.open(url.href);
      win.focus()

    }
  }
}
</script>

<style scoped>

</style>
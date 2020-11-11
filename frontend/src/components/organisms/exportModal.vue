<template>
  <div>
    <b-button @click="showModal('export-data')" class="mb-2 float-left">Выгрузка данных</b-button>
    <b-button @click="export_stat" class="mb-2 float-right">Выгрузка статистики</b-button>
    <b-modal size="xl" centered ref="export-data">
      <template v-slot:modal-header>
        Выгрузить данные
      </template>
      <template v-slot:modal-footer>
        <div></div>
      </template>
      <div class="container">

        <b-form-group label="Выберите страницу">
          <b-form-checkbox
              v-model="exportFilter"
              v-for="(item) in options"
              :inline="false"
              :key="item.value"
              :value="item.value"
          >{{ item.text }}
          </b-form-checkbox>
        </b-form-group>

        <b-button v-if="exportFilter.length === 8" @click="exportFilter = []" variant="outline-warning">Снять все
        </b-button>
        <b-button v-else @click="exportFilter = options.map(item=>item.value)" variant="outline-success">Выделить все
        </b-button>
        <b-button @click="export_data">Сформировать</b-button>
      </div>
    </b-modal>

  </div>
</template>

<script>
import {BButton, BFormCheckbox, BFormGroup, BModal} from 'bootstrap-vue'

export default {
  name: "exportModal",
  props: ['filter','id_org'],
  data() {
    return {
      exportFilter: [],
      stacked: true,
      options: [
        {text: 'Сведения об организации', value: 1},
        {text: 'Сведения о количестве мест и площади жилищного фонда, используемого в уставной деятельности', value: 2},
        {text: 'Сведения о проживающих в жилищном фонде, используемом в уставной деятельности', value: 3},
        {
          text: 'Сведения о проживающих лицах с ограниченными возможностями в жилищном фонде, используемом в уставной деятельности',
          value: 4
        },
        {text: 'Сведения о жилом объекте', value: 5},
        {text: 'Сведения о площади, проживающих и количестве мест в жилом объекте', value: 6},
        {text: 'Сведения о поступлениях и расходах на объект', value: 7},
        {text: 'Сведения о тарифах установленных для проживания в жилом объекте', value: 8}
      ]
    }
  },
  components: {
    BButton, BModal,
    BFormGroup, BFormCheckbox
  },
  methods: {
    showModal(id) {
      this.$refs[id].show();
    },
    closeModal(id) {
      this.$refs[id].hide();
    },
    export_stat() {

      let url = new URL('http://127.0.0.1');
      url.protocol = window.location.protocol;
      url.host = window.location.host;
      url.pathname = '/app/export/export-stat'

      Object.keys(this.filter).forEach(item => {
        if (this.filter[item])
          url.searchParams.set(item, this.filter[item]);
      })

      let win = window.open(url.href);
      win.focus()

    },
    export_data() {
      let url = new URL('http://127.0.0.1');
      url.protocol = window.location.protocol;
      url.host = window.location.host;
      url.pathname = this.id_org ? `/app/export/export-data?id_org=${this.id_org}` : '/app/export/export-data'

      Object.keys(this.filter).forEach(item => {
        if (this.filter[item])
          url.searchParams.set(item, this.filter[item]);
      })
      url.searchParams.set('pages',this.exportFilter.toString())

      let win = window.open(url.href);
      win.focus()
    }
  }
}
</script>

<style scoped>
.flip-list-move {
  transition: transform 1s;
}
</style>
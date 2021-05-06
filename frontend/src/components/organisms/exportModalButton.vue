<template>
  <div>
    <b-button block variant="outline-secondary" @click="showModal('export-data')">
      <slot/>
    </b-button>
    <b-button v-if="!isNav" @click="showModal('export-stat')" class="mb-2 float-right">Выгрузка статистики</b-button>
    <b-modal size="xl" centered ref="export-data">
      <template v-slot:modal-header>
        Выгрузить данные
        <b-button @click="closeModal('export-data')" size="sm" variant="outline-danger">
          <i class="fas fa-times"/>
        </b-button>
      </template>
      <template v-slot:modal-footer>
        <div/>
      </template>
      <div class="container">
        <b-form-group v-if="checkUser(['admin','root'])" label="Выберите страницу">
          <b-form-checkbox v-for="(item) in options" v-model="exportFilter" :inline="false" :key="item.value"
                           :value="item.value">
            {{ item.text }}
          </b-form-checkbox>
        </b-form-group>
        <b-alert show>
          Отчет формируется некоторое время. Чтобы вы не теряли время на ожидание, отчёт придет вам на почту.
        </b-alert>

        <label for="email">Электронная почта</label>
        <b-form-input placeholder="email@ya.ru" id="email" class="mb-2" type="email" v-model="mail" label="label"/>

        <b-button v-if="exportFilter.length === 8 && checkUser(['admin','root'])" variant="outline-warning"
                  @click="exportFilter = []">
          Снять выделение
        </b-button>
        <b-button v-if="exportFilter.length < 8 && checkUser(['admin','root'])" variant="outline-success"
                  @click="exportFilter = options.map(item=>item.value)">
          Выделить все
        </b-button>
        <b-button variant="outline-primary" @click="export_data">Сформировать</b-button>
      </div>
    </b-modal>
    <b-modal size="xl" centered ref="export-stat">
      <template v-slot:modal-header>
        Выгрузить данные
        <b-button size="sm" variant="outline-danger" @click="closeModal('export-stat')">
          <i class="fas fa-times"/>
        </b-button>
      </template>
      <template v-slot:modal-footer>
        <div/>
      </template>
      <div class="container">
        <b-form-input class="mb-2" type="email" v-model="mail" label="label"/>
        <b-button variant="outline-primary" @click="export_stat">Сформировать</b-button>
      </div>
    </b-modal>
  </div>
</template>

<script>
import Axios from "axios";
import {BAlert, BButton, BFormCheckbox, BFormGroup, BFormInput, BModal} from 'bootstrap-vue'

export default {
  name: "exportModal",
  props: ['filter', 'id_org', 'isNav'],
  data() {
    return {
      exportFilter: [],
      stacked: true,
      mail: null,
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
  components: {BAlert, BButton, BFormCheckbox, BFormGroup, BFormInput, BModal},
  methods: {
    checkUser(role) {
      if (typeof role === 'string') return window.Permission === role;
      if (Array.isArray(role)) return role.includes(window.Permission)
      return false;
    },
    showModal(id) {
      this.$refs[id].show();
    },
    closeModal(id) {
      this.$refs[id].hide();
    },
    async export_stat() {
      await Axios.get('/app/export/export-stat', {
        params: {
          ...this.filter,
          mail: this.mail,
          id: this.filter.id.join(','),
        }
      }).then(() => {
        this.$bvModal.msgBoxOk(`Выгрузка будет отправлена на ${this.mail}`)
      }).catch(() => {
        this.$bvModal.msgBoxOk('Проверьте почту')
      })
      /*
      let url = new URL('http://127.0.0.1');
      url.protocol = window.location.protocol;
      url.host = window.location.host;
      url.pathname = '/app/export/export-stat'

      Object.keys(this.filter).forEach(item => {
        if (this.filter[item])
          url.searchParams.set(item, this.filter[item]);
      })

      let win = window.open(url.href);
      win.focus()*/
    },
    async export_data() {
      await Axios.get('/app/export/export-data', {
        params: {
          ...this.filter,
          id: this.id_org || this.filter.id.join(','),
          id_org: this.id_org,
          pages: this.exportFilter.toString(),
          mail: this.mail
        }
      }).then(() => {
        this.$bvModal.msgBoxOk(`Выгрузка будет отправлена на ${this.mail}`)
      }).catch(() => {
        this.$bvModal.msgBoxOk('Проверьте почту')
      })
      /*let url = new URL('http://127.0.0.1');
      url.protocol = window.location.protocol;
      url.host = window.location.host;
      url.pathname = '/app/export/export-data'

      if (this.filter)
        Object.keys(this.filter).forEach(item => {
          if (this.filter[item])
            url.searchParams.set(item, this.filter[item]);
        })
      if (this.id_org)
        url.searchParams.set('id', this.id_org)
      url.searchParams.set('pages', this.exportFilter.toString())

      let win = window.open(url.href);
      win.focus()*/
    }
  }
}
</script>

<style scoped>
.flip-list-move {
  transition: transform 1s;
}
</style>
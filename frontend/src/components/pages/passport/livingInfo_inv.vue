<template>

  <div>
    <nav-bar v-on:save-page="savePage" v-on:block-save="blockPage = !blockPage"/>
    <transition enter-active-class="animated fadeInUp">
      <div v-if="componentReady" class="container">
        <div class="row">
          <div class="col-8">
            <h3>
              Сведения о проживающих лицах с ограниченными возможностями в жилищном фонде, используемом в уставной
              деятельности
            </h3>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-6"><label for="living_cnt_inv">Проживающие из числа обучающихся с ограниченными возможностями
            здоровья</label></div>
          <div class="col-6">
            <b-input-group append="Человек">
              <b-form-input id="living_cnt_inv" v-model="living.cnt_inv" disabled/>
            </b-input-group>
          </div>
        </div>
        <hr>

        <b-tabs content-class="mt-3" nav-class="font-weigh-bold" small justified>
          <b-tab no-body>
            <template v-slot:title>
                        <span class="text-secondary">
                        За счёт федерального бюджета
                        </span>
            </template>
            <living-table :items="items_b.items"
                          title="Проживающие из числа обучающихся с ограниченными возможностями здоровья за счёт федерального бюджета"
                          :is-invalid="true" :block-save="blockPage" v-bind:can-save="items_b.canSave"/>

          </b-tab>
          <b-tab no-body>
            <template v-slot:title>
                        <span class="text-secondary">
                        За счёт бюджета субъекта
                        </span>
            </template>
            <living-table :items="items_s.items"
                          title="Проживающие из числа обучающихся с ограниченными возможностями здоровья за счёт федерального бюджета"
                          :is-invalid="true" :block-save="blockPage" v-bind:can-save="items_s.canSave"/>

          </b-tab>
          <b-tab no-body>
            <template v-slot:title>
                        <span class="text-secondary">
                        За счёт местного бюджета
                        </span>
            </template>
            <living-table :items="items_m.items"
                          title="Проживающие из числа обучающихся с ограниченными возможностями здоровья за счёт федерального бюджета"
                          :is-invalid="true" :block-save="blockPage" v-bind:can-save="items_m.canSave"/>

          </b-tab>
          <b-tab no-body>
            <template v-slot:title>
                        <span class="text-secondary">
                              По договорам об оказании
                        платных образовательных услуг
                        </span>
            </template>
            <living-table :items="items_p.items"
                          title="Проживающие из числа обучающихся с ограниченными возможностями здоровья за счёт федерального бюджета"
                          :is-invalid="true" :block-save="blockPage" v-bind:can-save="items_p.canSave"/>

          </b-tab>
        </b-tabs>


      </div>
    </transition>
    <scroll-button/>
  </div>

</template>

<script>
import NavBar from "../../organisms/NavBar";
import livingTable from "../../organisms/livingTable";
import {BFormInput, BInputGroup, BTab, BTabs} from 'bootstrap-vue'
import Axios from "axios";
import ScrollButton from "../../organisms/scrollButton";

export default {
  name: "livingInfo_inv",
  data() {
    return {
      csrf: document.getElementsByName("csrf-token")[0].content,
      componentReady: false,
      blockPage: false,
      user: {},
      organization: {},
      id_org: null,
      living: {
        cnt_inv: 0
      },
      items_b: {
        items: [
          {
            label: 'Граждане РФ, обучающиеся по очной форме',
            editableLabel: false,
            visible: true,
            button: false,
            name: null,
            budjet_type: 0,
            spo: 0,
            bak: 0,
            spec: 0,
            mag: 0,
            asp: 0,
            ord: 0,
            ipo: 0,
            all: 0,
            type: 'rf_och',
            disabled: false,
          },

          {
            label: 'Иностранцы, обучающиеся по очной форме',
            editableLabel: false,
            visible: true,
            button: true,
            spo: 0,
            bak: 0,
            spec: 0,
            mag: 0,
            asp: 0,
            ord: 0,
            budjet_type: 0,
            type: 'in_och',
            ipo: 0,
            all: 0,
            disabled: false,
          },
          {
            label: 'Граждане РФ, обучающиеся по заочной форме',
            editableLabel: false,
            visible: true,
            button: false,
            spo: 0,
            type: 'rf_zaoch',
            bak: 0,
            spec: 0,
            mag: 0,
            asp: 0,
            ord: 0,
            ipo: 0,
            budjet_type: 0,
            all: 0,
            disabled: false,
          },
          {
            label: 'Иностранцы, обучающиеся по заочной форме',
            editableLabel: false,
            visible: true,
            button: true,
            spo: 0,
            bak: 0,
            spec: 0,
            type: 'in_zaoch',
            mag: 0,
            asp: 0,
            ord: 0,
            ipo: 0,
            all: 0,
            budjet_type: 0,
            disabled: false,
          },
          {
            label: 'Граждане РФ, обучающиеся по очно-заочной форме',
            editableLabel: false,
            visible: true,
            button: false,
            spo: 0,
            bak: 0,
            type: 'rf_ochzaoch',
            spec: 0,
            mag: 0,
            asp: 0,
            budjet_type: 0,
            ord: 0,
            ipo: 0,
            all: 0,
            disabled: false,
          },
          {
            label: 'Иностранцы, обучающиеся по очно-заочной форме',
            editableLabel: false,
            visible: true,
            button: true,
            spo: 0,
            bak: 0,
            spec: 0,
            budjet_type: 0,
            mag: 0,
            asp: 0,
            type: 'in_ochzaoch',
            ord: 0,
            ipo: 0,
            all: 0,
            disabled: false,
          },
          {
            label: 'Всего',
            editableLabel: false,
            visible: true,
            button: false,
            spo: 0,
            bak: 0,
            budjet_type: 0,
            spec: 0,
            mag: 0,
            asp: 0,
            ord: 0,
            ipo: 0,
            all: 0,
            disabled: true,
          }
        ],
        canSave: []
      },
      items_s: {
        items: [
          {
            label: 'Граждане РФ, обучающиеся по очной форме',
            editableLabel: false,
            visible: true,
            button: false,
            name: null,
            budjet_type: 1,
            spo: 0,
            bak: 0,
            spec: 0,
            mag: 0,
            asp: 0,
            ord: 0,
            ipo: 0,
            all: 0,
            type: 'rf_och',
            disabled: false,
          },

          {
            label: 'Иностранцы, обучающиеся по очной форме',
            editableLabel: false,
            visible: true,
            button: true,
            spo: 0,
            bak: 0,
            spec: 0,
            mag: 0,
            asp: 0,
            ord: 0,
            budjet_type: 1,
            type: 'in_och',
            ipo: 0,
            all: 0,
            disabled: false,
          },
          {
            label: 'Граждане РФ, обучающиеся по заочной форме',
            editableLabel: false,
            visible: true,
            button: false,
            spo: 0,
            type: 'rf_zaoch',
            bak: 0,
            spec: 0,
            mag: 0,
            asp: 0,
            ord: 0,
            ipo: 0,
            budjet_type: 1,
            all: 0,
            disabled: false,
          },
          {
            label: 'Иностранцы, обучающиеся по заочной форме',
            editableLabel: false,
            visible: true,
            button: true,
            spo: 0,
            bak: 0,
            spec: 0,
            type: 'in_zaoch',
            mag: 0,
            asp: 0,
            ord: 0,
            ipo: 0,
            all: 0,
            budjet_type: 0,
            disabled: false,
          },
          {
            label: 'Граждане РФ, обучающиеся по очно-заочной форме',
            editableLabel: false,
            visible: true,
            button: false,
            spo: 0,
            bak: 0,
            type: 'rf_ochzaoch',
            spec: 0,
            mag: 0,
            asp: 0,
            budjet_type: 1,
            ord: 0,
            ipo: 0,
            all: 0,
            disabled: false,
          },
          {
            label: 'Иностранцы, обучающиеся по очно-заочной форме',
            editableLabel: false,
            visible: true,
            button: true,
            spo: 0,
            bak: 0,
            spec: 0,
            budjet_type: 1,
            mag: 0,
            asp: 0,
            type: 'in_ochzaoch',
            ord: 0,
            ipo: 0,
            all: 0,
            disabled: false,
          },
          {
            label: 'Всего',
            editableLabel: false,
            visible: true,
            button: false,
            spo: 0,
            bak: 0,
            budjet_type: 1,
            spec: 0,
            mag: 0,
            asp: 0,
            ord: 0,
            ipo: 0,
            all: 0,
            disabled: true,
          }
        ],
        canSave: []
      },
      items_m: {
        items: [
          {
            label: 'Граждане РФ, обучающиеся по очной форме',
            editableLabel: false,
            visible: true,
            button: false,
            name: null,
            budjet_type: 2,
            spo: 0,
            bak: 0,
            spec: 0,
            mag: 0,
            asp: 0,
            ord: 0,
            ipo: 0,
            all: 0,
            type: 'rf_och',
            disabled: false,
          },

          {
            label: 'Иностранцы, обучающиеся по очной форме',
            editableLabel: false,
            visible: true,
            button: true,
            spo: 0,
            bak: 0,
            spec: 0,
            mag: 0,
            asp: 0,
            ord: 0,
            budjet_type: 2,
            type: 'in_och',
            ipo: 0,
            all: 0,
            disabled: false,
          },
          {
            label: 'Граждане РФ, обучающиеся по заочной форме',
            editableLabel: false,
            visible: true,
            button: false,
            spo: 0,
            type: 'rf_zaoch',
            bak: 0,
            spec: 0,
            mag: 0,
            asp: 0,
            ord: 0,
            ipo: 0,
            budjet_type: 2,
            all: 0,
            disabled: false,
          },
          {
            label: 'Иностранцы, обучающиеся по заочной форме',
            editableLabel: false,
            visible: true,
            button: true,
            spo: 0,
            bak: 0,
            spec: 0,
            type: 'in_zaoch',
            mag: 0,
            asp: 0,
            ord: 0,
            ipo: 0,
            all: 0,
            budjet_type: 2,
            disabled: false,
          },
          {
            label: 'Граждане РФ, обучающиеся по очно-заочной форме',
            editableLabel: false,
            visible: true,
            button: false,
            spo: 0,
            bak: 0,
            type: 'rf_ochzaoch',
            spec: 0,
            mag: 0,
            asp: 0,
            budjet_type: 2,
            ord: 0,
            ipo: 0,
            all: 0,
            disabled: false,
          },
          {
            label: 'Иностранцы, обучающиеся по очно-заочной форме',
            editableLabel: false,
            visible: true,
            button: true,
            spo: 0,
            bak: 0,
            spec: 0,
            budjet_type: 2,
            mag: 0,
            asp: 0,
            type: 'in_ochzaoch',
            ord: 0,
            ipo: 0,
            all: 0,
            disabled: false,
          },
          {
            label: 'Всего',
            editableLabel: false,
            visible: true,
            button: false,
            spo: 0,
            bak: 0,
            budjet_type: 2,
            spec: 0,
            mag: 0,
            asp: 0,
            ord: 0,
            ipo: 0,
            all: 0,
            disabled: true,
          }
        ],
        canSave: []
      },
      items_p: {
        items: [
          {
            label: 'Граждане РФ, обучающиеся по очной форме',
            editableLabel: false,
            visible: true,
            button: false,
            name: null,
            budjet_type: 3,
            spo: 0,
            bak: 0,
            spec: 0,
            mag: 0,
            asp: 0,
            ord: 0,
            ipo: 0,
            all: 0,
            type: 'rf_och',
            disabled: false,
          },

          {
            label: 'Иностранцы, обучающиеся по очной форме',
            editableLabel: false,
            visible: true,
            button: true,
            spo: 0,
            bak: 0,
            spec: 0,
            mag: 0,
            asp: 0,
            ord: 0,
            budjet_type: 3,
            type: 'in_och',
            ipo: 0,
            all: 0,
            disabled: false,
          },
          {
            label: 'Граждане РФ, обучающиеся по заочной форме',
            editableLabel: false,
            visible: true,
            button: false,
            spo: 0,
            type: 'rf_zaoch',
            bak: 0,
            spec: 0,
            mag: 0,
            asp: 0,
            ord: 0,
            ipo: 0,
            budjet_type: 3,
            all: 0,
            disabled: false,
          },
          {
            label: 'Иностранцы, обучающиеся по заочной форме',
            editableLabel: false,
            visible: true,
            button: true,
            spo: 0,
            bak: 0,
            spec: 0,
            type: 'in_zaoch',
            mag: 0,
            asp: 0,
            ord: 0,
            ipo: 0,
            all: 0,
            budjet_type: 3,
            disabled: false,
          },
          {
            label: 'Граждане РФ, обучающиеся по очно-заочной форме',
            editableLabel: false,
            visible: true,
            button: false,
            spo: 0,
            bak: 0,
            type: 'rf_ochzaoch',
            spec: 0,
            mag: 0,
            asp: 0,
            budjet_type: 3,
            ord: 0,
            ipo: 0,
            all: 0,
            disabled: false,
          },
          {
            label: 'Иностранцы, обучающиеся по очно-заочной форме',
            editableLabel: false,
            visible: true,
            button: true,
            spo: 0,
            bak: 0,
            spec: 0,
            budjet_type: 3,
            mag: 0,
            asp: 0,
            type: 'in_ochzaoch',
            ord: 0,
            ipo: 0,
            all: 0,
            disabled: false,
          },
          {
            label: 'Всего',
            editableLabel: false,
            visible: true,
            button: false,
            spo: 0,
            bak: 0,
            budjet_type: 3,
            spec: 0,
            mag: 0,
            asp: 0,
            ord: 0,
            ipo: 0,
            all: 0,
            disabled: true,
          }
        ],
        canSave: []
      },
    }
  },
  watch: {
    organization: {
      handler() {
        this.cntLiving()
      },
      deep: true
    },
    items_b: {
      handler() {
        console.log('ke')
        this.cntLiving()
      },
      deep: true
    },
    items_s: {
      handler() {
        this.cntLiving()
      },
      deep: true
    },
    items_m: {
      handler() {
        this.cntLiving()
      },
      deep: true
    },
    items_p: {
      handler() {
        this.cntLiving()
      },
      deep: true
    }
  },
  methods: {
    cntLiving() {


      this.living.cnt_inv =
          ~~parseInt(this.items_b.items[this.items_b.items.length - 1].all) +
          ~~parseInt(this.items_m.items[this.items_m.items.length - 1].all) +
          ~~parseInt(this.items_s.items[this.items_s.items.length - 1].all) +
          ~~parseInt(this.items_p.items[this.items_p.items.length - 1].all);


    },
    async getUser() {
      await Axios.get('/api/user/current').then(res => {
        this.user = res.data;
      });
    },
    async getOrg() {
      await Axios.get(`/api/organization/by-id/${this.id_org}`, {
        params: {
          living_st_inv: 1
        }
      }).then(res => {
        this.organization = res.data
        if (this.organization) {

          this.items_b = {
            items: [
              {
                label: 'Граждане РФ, обучающиеся по очной форме',
                editableLabel: false,
                visible: true,
                button: false,
                name: null,
                budjet_type: 0,
                spo: 0,
                bak: 0,
                spec: 0,
                mag: 0,
                asp: 0,
                ord: 0,
                ipo: 0,
                all: 0,
                type: 'rf_och',
                disabled: false,
              },

              {
                label: 'Иностранцы, обучающиеся по очной форме',
                editableLabel: false,
                visible: true,
                button: true,
                spo: 0,
                bak: 0,
                spec: 0,
                mag: 0,
                asp: 0,
                ord: 0,
                budjet_type: 0,
                type: 'in_och',
                ipo: 0,
                all: 0,
                disabled: false,
              },
              {
                label: 'Граждане РФ, обучающиеся по заочной форме',
                editableLabel: false,
                visible: true,
                button: false,
                spo: 0,
                type: 'rf_zaoch',
                bak: 0,
                spec: 0,
                mag: 0,
                asp: 0,
                ord: 0,
                ipo: 0,
                budjet_type: 0,
                all: 0,
                disabled: false,
              },
              {
                label: 'Иностранцы, обучающиеся по заочной форме',
                editableLabel: false,
                visible: true,
                button: true,
                spo: 0,
                bak: 0,
                spec: 0,
                type: 'in_zaoch',
                mag: 0,
                asp: 0,
                ord: 0,
                ipo: 0,
                all: 0,
                budjet_type: 0,
                disabled: false,
              },
              {
                label: 'Граждане РФ, обучающиеся по очно-заочной форме',
                editableLabel: false,
                visible: true,
                button: false,
                spo: 0,
                bak: 0,
                type: 'rf_ochzaoch',
                spec: 0,
                mag: 0,
                asp: 0,
                budjet_type: 0,
                ord: 0,
                ipo: 0,
                all: 0,
                disabled: false,
              },
              {
                label: 'Иностранцы, обучающиеся по очно-заочной форме',
                editableLabel: false,
                visible: true,
                button: true,
                spo: 0,
                bak: 0,
                spec: 0,
                budjet_type: 0,
                mag: 0,
                asp: 0,
                type: 'in_ochzaoch',
                ord: 0,
                ipo: 0,
                all: 0,
                disabled: false,
              },
              {
                label: 'Всего',
                editableLabel: false,
                visible: true,
                button: false,
                spo: 0,
                bak: 0,
                budjet_type: 0,
                spec: 0,
                mag: 0,
                asp: 0,
                ord: 0,
                ipo: 0,
                all: 0,
                disabled: true,
              }
            ],
            canSave: []
          };
          this.items_s = {
            items: [
              {
                label: 'Граждане РФ, обучающиеся по очной форме',
                editableLabel: false,
                visible: true,
                button: false,
                name: null,
                budjet_type: 1,
                spo: 0,
                bak: 0,
                spec: 0,
                mag: 0,
                asp: 0,
                ord: 0,
                ipo: 0,
                all: 0,
                type: 'rf_och',
                disabled: false,
              },

              {
                label: 'Иностранцы, обучающиеся по очной форме',
                editableLabel: false,
                visible: true,
                button: true,
                spo: 0,
                bak: 0,
                spec: 0,
                mag: 0,
                asp: 0,
                ord: 0,
                budjet_type: 1,
                type: 'in_och',
                ipo: 0,
                all: 0,
                disabled: false,
              },
              {
                label: 'Граждане РФ, обучающиеся по заочной форме',
                editableLabel: false,
                visible: true,
                button: false,
                spo: 0,
                type: 'rf_zaoch',
                bak: 0,
                spec: 0,
                mag: 0,
                asp: 0,
                ord: 0,
                ipo: 0,
                budjet_type: 1,
                all: 0,
                disabled: false,
              },
              {
                label: 'Иностранцы, обучающиеся по заочной форме',
                editableLabel: false,
                visible: true,
                button: true,
                spo: 0,
                bak: 0,
                spec: 0,
                type: 'in_zaoch',
                mag: 0,
                asp: 0,
                ord: 0,
                ipo: 0,
                all: 0,
                budjet_type: 0,
                disabled: false,
              },
              {
                label: 'Граждане РФ, обучающиеся по очно-заочной форме',
                editableLabel: false,
                visible: true,
                button: false,
                spo: 0,
                bak: 0,
                type: 'rf_ochzaoch',
                spec: 0,
                mag: 0,
                asp: 0,
                budjet_type: 1,
                ord: 0,
                ipo: 0,
                all: 0,
                disabled: false,
              },
              {
                label: 'Иностранцы, обучающиеся по очно-заочной форме',
                editableLabel: false,
                visible: true,
                button: true,
                spo: 0,
                bak: 0,
                spec: 0,
                budjet_type: 1,
                mag: 0,
                asp: 0,
                type: 'in_ochzaoch',
                ord: 0,
                ipo: 0,
                all: 0,
                disabled: false,
              },
              {
                label: 'Всего',
                editableLabel: false,
                visible: true,
                button: false,
                spo: 0,
                bak: 0,
                budjet_type: 1,
                spec: 0,
                mag: 0,
                asp: 0,
                ord: 0,
                ipo: 0,
                all: 0,
                disabled: true,
              }
            ],
            canSave: []
          };
          this.items_m = {
            items: [
              {
                label: 'Граждане РФ, обучающиеся по очной форме',
                editableLabel: false,
                visible: true,
                button: false,
                name: null,
                budjet_type: 2,
                spo: 0,
                bak: 0,
                spec: 0,
                mag: 0,
                asp: 0,
                ord: 0,
                ipo: 0,
                all: 0,
                type: 'rf_och',
                disabled: false,
              },

              {
                label: 'Иностранцы, обучающиеся по очной форме',
                editableLabel: false,
                visible: true,
                button: true,
                spo: 0,
                bak: 0,
                spec: 0,
                mag: 0,
                asp: 0,
                ord: 0,
                budjet_type: 2,
                type: 'in_och',
                ipo: 0,
                all: 0,
                disabled: false,
              },
              {
                label: 'Граждане РФ, обучающиеся по заочной форме',
                editableLabel: false,
                visible: true,
                button: false,
                spo: 0,
                type: 'rf_zaoch',
                bak: 0,
                spec: 0,
                mag: 0,
                asp: 0,
                ord: 0,
                ipo: 0,
                budjet_type: 2,
                all: 0,
                disabled: false,
              },
              {
                label: 'Иностранцы, обучающиеся по заочной форме',
                editableLabel: false,
                visible: true,
                button: true,
                spo: 0,
                bak: 0,
                spec: 0,
                type: 'in_zaoch',
                mag: 0,
                asp: 0,
                ord: 0,
                ipo: 0,
                all: 0,
                budjet_type: 2,
                disabled: false,
              },
              {
                label: 'Граждане РФ, обучающиеся по очно-заочной форме',
                editableLabel: false,
                visible: true,
                button: false,
                spo: 0,
                bak: 0,
                type: 'rf_ochzaoch',
                spec: 0,
                mag: 0,
                asp: 0,
                budjet_type: 2,
                ord: 0,
                ipo: 0,
                all: 0,
                disabled: false,
              },
              {
                label: 'Иностранцы, обучающиеся по очно-заочной форме',
                editableLabel: false,
                visible: true,
                button: true,
                spo: 0,
                bak: 0,
                spec: 0,
                budjet_type: 2,
                mag: 0,
                asp: 0,
                type: 'in_ochzaoch',
                ord: 0,
                ipo: 0,
                all: 0,
                disabled: false,
              },
              {
                label: 'Всего',
                editableLabel: false,
                visible: true,
                button: false,
                spo: 0,
                bak: 0,
                budjet_type: 2,
                spec: 0,
                mag: 0,
                asp: 0,
                ord: 0,
                ipo: 0,
                all: 0,
                disabled: true,
              }
            ],
            canSave: []
          };
          this.items_p = {
            items: [
              {
                label: 'Граждане РФ, обучающиеся по очной форме',
                editableLabel: false,
                visible: true,
                button: false,
                name: null,
                budjet_type: 3,
                spo: 0,
                bak: 0,
                spec: 0,
                mag: 0,
                asp: 0,
                ord: 0,
                ipo: 0,
                all: 0,
                type: 'rf_och',
                disabled: false,
              },

              {
                label: 'Иностранцы, обучающиеся по очной форме',
                editableLabel: false,
                visible: true,
                button: true,
                spo: 0,
                bak: 0,
                spec: 0,
                mag: 0,
                asp: 0,
                ord: 0,
                budjet_type: 3,
                type: 'in_och',
                ipo: 0,
                all: 0,
                disabled: false,
              },
              {
                label: 'Граждане РФ, обучающиеся по заочной форме',
                editableLabel: false,
                visible: true,
                button: false,
                spo: 0,
                type: 'rf_zaoch',
                bak: 0,
                spec: 0,
                mag: 0,
                asp: 0,
                ord: 0,
                ipo: 0,
                budjet_type: 3,
                all: 0,
                disabled: false,
              },
              {
                label: 'Иностранцы, обучающиеся по заочной форме',
                editableLabel: false,
                visible: true,
                button: true,
                spo: 0,
                bak: 0,
                spec: 0,
                type: 'in_zaoch',
                mag: 0,
                asp: 0,
                ord: 0,
                ipo: 0,
                all: 0,
                budjet_type: 3,
                disabled: false,
              },
              {
                label: 'Граждане РФ, обучающиеся по очно-заочной форме',
                editableLabel: false,
                visible: true,
                button: false,
                spo: 0,
                bak: 0,
                type: 'rf_ochzaoch',
                spec: 0,
                mag: 0,
                asp: 0,
                budjet_type: 3,
                ord: 0,
                ipo: 0,
                all: 0,
                disabled: false,
              },
              {
                label: 'Иностранцы, обучающиеся по очно-заочной форме',
                editableLabel: false,
                visible: true,
                button: true,
                spo: 0,
                bak: 0,
                spec: 0,
                budjet_type: 3,
                mag: 0,
                asp: 0,
                type: 'in_ochzaoch',
                ord: 0,
                ipo: 0,
                all: 0,
                disabled: false,
              },
              {
                label: 'Всего',
                editableLabel: false,
                visible: true,
                button: false,
                spo: 0,
                bak: 0,
                budjet_type: 3,
                spec: 0,
                mag: 0,
                asp: 0,
                ord: 0,
                ipo: 0,
                all: 0,
                disabled: true,
              }
            ],
            canSave: []
          };


          this.organization.living = res.data.living ?? {}
          let numbers = [
            {
              'rf_och': 0,
              'in_och': 0,
              'rf_zaoch': 0,
              'in_zaoch': 0,
              'rf_ochzaoch': 0,
              'in_ochzaoch': 0,
              'inv': 0
            },
            {
              'rf_och': 0,
              'in_och': 0,
              'rf_zaoch': 0,
              'in_zaoch': 0,
              'rf_ochzaoch': 0,
              'in_ochzaoch': 0,
              'inv': 0
            },
            {
              'rf_och': 0,
              'in_och': 0,
              'rf_zaoch': 0,
              'in_zaoch': 0,
              'rf_ochzaoch': 0,
              'in_ochzaoch': 0,
              'inv': 0
            },
            {
              'rf_och': 0,
              'in_och': 0,
              'rf_zaoch': 0,
              'in_zaoch': 0,
              'rf_ochzaoch': 0,
              'in_ochzaoch': 0,
              'inv': 0
            }
          ];
          res.data.livingStudents.forEach(item => {
            let type = 'items_b'

            switch (item.budjet_type) {
              case 0: {

                type = 'items_b';
                break;
              }
              case 1: {
                console.log(item.budjet_type)
                type = 'items_s';
                break;
              }
              case 2: {
                type = 'items_m';
                break;
              }
              case 3: {
                type = 'items_p';
                break;
              }

            }
            switch (item.type) {
              case 'rf_och': {
                if (!numbers[item.budjet_type]['rf_och']) {
                  this[type].items[0] = {
                    id: item.id,
                    label: 'Граждане РФ, обучающиеся по очной форме',
                    editableLabel: false,
                    visible: true,
                    budjet_type: item.budjet_type,
                    type: item.type,
                    button: false,
                    name: null,
                    spo: item.spo,
                    bak: item.bak,
                    spec: item.spec,
                    mag: item.mag,
                    asp: item.asp,
                    ord: item.ord,
                    ipo: item.ipo,
                    all: item.all,
                    disabled: false,
                  }
                } else {
                  let index = this[type].items.findIndex(i => i.type === 'rf_och');
                  this[type].items.splice(index + 1, 0, {
                    id: item.id,
                    label: item.name,
                    editableLabel: true,
                    visible: true,
                    budjet_type: item.budjet_type,
                    type: item.type,
                    button: false,
                    name: null,
                    spo: item.spo,
                    bak: item.bak,
                    spec: item.spec,
                    mag: item.mag,
                    asp: item.asp,
                    ord: item.ord,
                    ipo: item.ipo,
                    all: item.all,
                    disabled: false,
                  });
                }
                numbers[item.budjet_type]['rf_och']++;

                break;
              }
              case 'in_och': {
                if (!numbers[item.budjet_type]['in_och']) {
                  let index = this[type].items.findIndex(i => i.label === 'Иностранцы, обучающиеся по очной форме');
                  this[type].items[index] = {
                    id: item.id,
                    budjet_type: item.budjet_type,
                    type: item.type,
                    name: null,
                    spo: item.spo,
                    bak: item.bak,
                    spec: item.spec,
                    mag: item.mag,
                    asp: item.asp,
                    ord: item.ord,
                    ipo: item.ipo,
                    all: item.all,
                    label: 'Иностранцы, обучающиеся по очной форме',
                    editableLabel: false,
                    visible: true,
                    button: true,
                    disabled: false,
                  }
                } else {
                  let index = this[type].items.findIndex(i => i.type === 'in_och');
                  this[type].items.splice(index + 1, 0, {
                    id: item.id,
                    label: item.name,
                    editableLabel: true,
                    visible: true,
                    budjet_type: item.budjet_type,
                    type: item.type,
                    button: false,
                    name: null,
                    spo: item.spo,
                    bak: item.bak,
                    spec: item.spec,
                    mag: item.mag,
                    asp: item.asp,
                    ord: item.ord,
                    ipo: item.ipo,
                    all: item.all,
                    disabled: false,
                  });
                }
                numbers[item.budjet_type]['in_och']++;
                break;
              }
              case 'rf_zaoch': {
                let index = 0;
                if (!numbers[item.budjet_type]['rf_zaoch']) {
                  index = this[type].items.findIndex(i => i.label === 'Граждане РФ, обучающиеся по заочной форме');
                  this[type].items[index] = {
                    id: item.id,
                    budjet_type: item.budjet_type,
                    type: item.type,
                    name: null,
                    spo: item.spo,
                    bak: item.bak,
                    spec: item.spec,
                    mag: item.mag,
                    asp: item.asp,
                    ord: item.ord,
                    ipo: item.ipo,
                    all: item.all,
                    label: 'Граждане РФ, обучающиеся по заочной форме',
                    editableLabel: false,
                    visible: true,
                    button: true,
                    disabled: false,
                  }
                } else {
                  index = this[type].items.findIndex(i => i.type === 'rf_zaoch');
                  this[type].items.splice(index + 1, 0, {
                    id: item.id,
                    label: item.name,
                    editableLabel: true,
                    visible: true,
                    budjet_type: item.budjet_type,
                    type: item.type,
                    button: false,
                    name: null,
                    spo: item.spo,
                    bak: item.bak,
                    spec: item.spec,
                    mag: item.mag,
                    asp: item.asp,
                    ord: item.ord,
                    ipo: item.ipo,
                    all: item.all,
                    disabled: false,
                  });
                }
                numbers[item.budjet_type]['rf_zaoch']++;
                break;
              }
              case 'in_zaoch': {
                if (!numbers['in_zaoch']) {
                  let index = this[type].items.findIndex(i => i.label === 'Иностранцы, обучающиеся по заочной форме');
                  this[type].items[index] = {
                    id: item.id,
                    budjet_type: item.budjet_type,
                    type: item.type,
                    name: null,
                    spo: item.spo,
                    bak: item.bak,
                    spec: item.spec,
                    mag: item.mag,
                    asp: item.asp,
                    ord: item.ord,
                    ipo: item.ipo,
                    all: item.all,
                    label: 'Иностранцы, обучающиеся по заочной форме',
                    editableLabel: false,
                    visible: true,
                    button: true,
                    disabled: false,
                  }
                } else {
                  let index = this[type].items.findIndex(i => i.type === 'in_zaoch');
                  this[type].items.splice(index + 1, 0, {
                    id: item.id,
                    label: item.name,
                    editableLabel: true,
                    visible: true,
                    budjet_type: item.budjet_type,
                    type: item.type,
                    button: false,
                    name: null,
                    spo: item.spo,
                    bak: item.bak,
                    spec: item.spec,
                    mag: item.mag,
                    asp: item.asp,
                    ord: item.ord,
                    ipo: item.ipo,
                    all: item.all,
                    disabled: false,
                  });
                }
                numbers[item.budjet_type]['in_zaoch']++;
                break;
              }
              case 'rf_ochzaoch': {
                let index = 0;
                if (!numbers[item.budjet_type]['rf_ochzaoch']) {
                  index = this[type].items.findIndex(i => i.label === 'Граждане РФ, обучающиеся по очно-заочной форме');
                  this[type].items[index] = {
                    id: item.id,
                    budjet_type: item.budjet_type,
                    type: item.type,
                    name: null,
                    spo: item.spo,
                    bak: item.bak,
                    spec: item.spec,
                    mag: item.mag,
                    asp: item.asp,
                    ord: item.ord,
                    ipo: item.ipo,
                    all: item.all,
                    label: 'Граждане РФ, обучающиеся по очно-заочной форме',
                    editableLabel: false,
                    visible: true,
                    button: true,
                    disabled: false,
                  }
                } else {
                  index = this[type].items.findIndex(i => i.type === 'rf_ochzaoch');
                  this[type].items.splice(index + 1, 0, {
                    id: item.id,
                    label: item.name,
                    editableLabel: true,
                    visible: true,
                    budjet_type: item.budjet_type,
                    type: item.type,
                    button: false,
                    name: null,
                    spo: item.spo,
                    bak: item.bak,
                    spec: item.spec,
                    mag: item.mag,
                    asp: item.asp,
                    ord: item.ord,
                    ipo: item.ipo,
                    all: item.all,
                    disabled: false,
                  });
                }
                numbers[item.budjet_type]['rf_ochzaoch']++;
                break;
              }
              case 'in_ochzaoch': {
                if (!numbers[item.budjet_type]['in_ochzaoch']) {
                  let index = this[type].items.findIndex(i => i.label === 'Иностранцы, обучающиеся по очно-заочной форме');
                  this[type].items[index] = {
                    id: item.id,
                    budjet_type: item.budjet_type,
                    type: item.type,
                    name: null,
                    spo: item.spo,
                    bak: item.bak,
                    spec: item.spec,
                    mag: item.mag,
                    asp: item.asp,
                    ord: item.ord,
                    ipo: item.ipo,
                    all: item.all,
                    label: 'Иностранцы, обучающиеся по очно-заочной форме',
                    editableLabel: false,
                    visible: true,
                    button: true,
                    disabled: false,
                  }
                } else {
                  let index = this[type].items.findIndex(i => i.type === 'in_ochzaoch');
                  this[type].items.splice(index + 1, 0, {
                    id: item.id,
                    label: item.name,
                    editableLabel: true,
                    visible: true,
                    budjet_type: item.budjet_type,
                    type: item.type,
                    button: false,
                    name: null,
                    spo: item.spo,
                    bak: item.bak,
                    spec: item.spec,
                    mag: item.mag,
                    asp: item.asp,
                    ord: item.ord,
                    ipo: item.ipo,
                    all: item.all,
                    disabled: false,
                  });
                }
                numbers[item.budjet_type]['in_ochzaoch']++;
                break;
              }
            }
          })
        }
      });
      this.items_b.items.forEach((item, index) => {
        this.items_b.canSave.push(index)
      })
      this.items_s.items.forEach((item, index) => {
        this.items_s.canSave.push(index)
      })
      this.items_m.items.forEach((item, index) => {
        this.items_m.canSave.push(index)
      })
      this.items_p.items.forEach((item, index) => {
        this.items_p.canSave.push(index)
      })
      console.log(this.items_b)
    },
    async savePage() {
      let data = new FormData();
      this.organization = this.organization ?? {}
      this.organization.living_studs = [...this.items_b.items, this.items_s.items, ...this.items_m.items, ...this.items_p.items];
      this.organization.invalid = 1;
      data.append('org_living', JSON.stringify(this.organization));
      await Axios.post(`/organization/set-org-living/${this.id_org}`, data, {
        headers: {
          "X-CSRF-Token": this.csrf
        }
      }).then(res => {
        this.getOrg()
      }).finally(() => {
        this.blockPage = true;
      })
    },

  },
  async mounted() {
    await this.getUser();
    this.id_org = this.user.id_org;
    await this.getOrg()
    // document.addEventListener("pagehide", this.unloadEvent(event));
    //  document.addEventListener("pageshow", this.loadEvent());
    this.componentReady = true;
  },
  components: {
    ScrollButton,
    NavBar,
    livingTable,
    BFormInput,
    BInputGroup,
    BTabs, BTab,
  },
}
</script>

<style scoped>

</style>
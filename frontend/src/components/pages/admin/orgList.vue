<template>
  <div v-if="ready">
    <nav-bar/>
    <div class="container">
      <h3>Статистика по организациям</h3>
      <hr class="mt-3">

      <div>
        <b-card no-body>
          <b-card-header class="p-1" role="tab">
            <label v-b-toggle.filter class="d-block ml-2 font-weight-bold">
              <span class="mb-2">Фильтр</span>
              <i class="fas mt-2 fa-filter"></i>
            </label>
          </b-card-header>
          <b-collapse role="tabpanel" id="filter" accordion="filter">
            <div class="container">
              <b-form-group class="mt-2" label-class="font-weight-bold" label="Название организаций">
                <b-form-tags v-model="value" no-outer-focus class=" p-0 border-0">
                  <template v-slot="{ tags, disabled, addTag, removeTag }">
                    <ul v-if="tags.length > 0" class="list-inline d-inline-block mb-2">
                      <li v-for="tag in tags" :key="tag" class="list-inline-item">
                        <b-form-tag
                            @remove="removeT({option:tag,removeTag})"
                            :title="tag"
                            :disabled="disabled"
                            variant="info"
                        >{{ tag }}
                        </b-form-tag>
                      </li>
                    </ul>

                      <b-form-input
                          v-model="search"
                          id="tag-search-input"
                          type="search"
                          autocomplete="off"
                          placeholder="Начинайте вводить название"
                      ></b-form-input>

                    <transition-group name="staggered-fade"
                                      v-bind:css="false"
                                      v-on:before-enter="beforeEnter"
                                      v-on:enter="enter"
                                      v-on:leave="leave"
                    >
                      <div
                          class="item"
                          v-for="(option,index) in availableOptions"
                          :key="option.value"
                          :data-index="index"
                          @click="onOptionClick({ option:option, addTag })"
                      >
                        {{ option.text }}
                      </div>
                    </transition-group>
                   <!-- <div v-if="!availableOptions.length">
                      Для выбора организации введите ее название
                    </div>-->
                  </template>
                </b-form-tags>
              </b-form-group>

              <b-form-group label-class="font-weight-bold" label="ФОИВ" label-for="id_founder">
                <b-form-select id="id_founder" :options="founders" v-model.number="filter.id_founder"/>
              </b-form-group>

              <b-form-group label-class="font-weight-bold" label="Субъект Российской Федерации" label-for="id_region">
                <b-form-select id="id_region" :options="regions" v-model.number="filter.id_region"/>
              </b-form-group>

              <b-form-group label-class="font-weight-bold" label="Организации приступили к заполнению" label-for="zap">
                <b-form-select id="zap" :options="[
                  {value:1,text:'Приступили'},
                  {value:1,text:'Не приступили'}
              ]" v-model.number="filter.zap"/>
              </b-form-group>

              <b-form-group label-class="font-weight-bold" label="Организации добавили контактные данные"
                            label-for="kont">
                <b-form-select id="kont" :options="[
                  {value:1,text:'Добавили'},
                  {value:1,text:'Не добавили'}
              ]" v-model.number="filter.kont"/>
              </b-form-group>

              <b-form-group label-class="font-weight-bold" label="Организации добавили документы" label-for="docs">
                <b-form-select id="docs" :options="[
                  {value:1,text:'Добавили'},
                  {value:1,text:'Не добавили'}
              ]" v-model.number="filter.docs"/>
              </b-form-group>

            </div>
          </b-collapse>
        </b-card>


        <b-table-simple class="mt-2" >
          <b-thead>
            <b-tr class="border-bottom">
              <b-td>Id</b-td>
              <b-td>Название организации</b-td>
              <b-td>Регион</b-td>
              <b-td>ФОИВ</b-td>
              <b-td>Кол-во объектов</b-td>
              <b-td>Загрузка док-ов</b-td>
            </b-tr>
          </b-thead>
          <b-tbody>
            <b-tr v-for="(item,index) in orgList" :key="`tr-${index}`">
              <b-td>{{ item.id }}</b-td>
              <b-td>{{ item.name }}</b-td>
              <b-td>{{ item.region }}</b-td>
              <b-td>{{ item.foiv }}</b-td>
              <b-td>{{ item.obj_cnt }}</b-td>
              <b-td>{{ item.docs }}</b-td>
            </b-tr>
          </b-tbody>
        </b-table-simple>
        <b-pagination :per-page="filter.limit" :total-rows="cnt" v-model.number="filter.offset"/>
      </div>


    </div>
  </div>
  <div v-else class="spinner-middle">
    <b-spinner class="" variant="success" type="grow"
               label="Spinning"></b-spinner>
  </div>

</template>

<script>
import NavBar from "../../organisms/NavBar";
import Axios from 'axios';
import {
  BCard,
  BCardHeader,
  BCollapse,
  BFormGroup,
  BFormInput,
  BFormSelect,
  BFormTag,
  BFormTags,
  BIcon,
  BPagination,
  BSpinner,
  BTableSimple,
  BTbody,
  BTd,
  BTh,
  BThead,
  BTr,
  VBToggle
} from 'bootstrap-vue'

export default {
  name: "orgList",
  directives: {
    BToggle: VBToggle
  },
  components: {
    NavBar, BTableSimple,
    BCard, BFormTag,
    BCardHeader, BPagination,
    BCollapse, BThead, BTbody,
    BTh, BTd, BTr,
    BFormGroup, BIcon,
    BFormSelect, BSpinner,
    BFormInput, BFormTags,
  },
  asyncComputed: {
    availableOptions: {
      lazy: true,
      get() {
        if (this.criteria.length >= 3) {
          return Axios.get('/api/organizations/all', {
            params: {
              name: this.criteria
            }
          }).then(response => response.data.map(item => {
            return {
              value: item.id,
              text: item.name
            }
          }));
        }
        return []
      },
      default: []
    }

  },
  computed: {
    criteria() {
      // Compute the search criteria
      return this.search.trim().toLowerCase()
    },
    searchDesc() {
      if (this.criteria && this.availableOptions.length === 0) {
        return 'нет доступных организаций по заданным критериаям'
      }
      return ''
    }
  }
  ,
  data() {
    return {
      //options: ['Apple', 'Orange', 'Banana', 'Lime', 'Peach', 'Chocolate', 'Strawberry'],
      search: '',
      value: [],
      filter: {
        id: [],
        id_founder: null,
        id_region: null,
        zap: null,
        kont: null,
        docs: null,
        limit: 5,
        offset: 1
      },
      cnt: 0,
      orgList: [],
      temp: {
        orgs: []
      },
      founders: [],
      regions: [],
      ready: false
    }
  },
  watch: {
    filter: {
      async handler() {
        await this.getOrgList();
      },
      deep: true
    }
  },
  async mounted() {
    await this.getFounders();
    await this.getRegions()
    await this.getOrgList()
    setTimeout(() => {
      this.ready = true;
    }, 500)

  },
  methods: {
    async getOrgList() {
      await Axios.get('/api/organizations/org-filter', {
        params: this.filter
      }).then(response => {
        this.orgList = response.data;
        this.cnt = response.data.cnt;
      });
    },
    removeT({option, removeTag}) {
      let index = this.temp.orgs.findIndex(item => item.text === option);
      this.filter.id.splice(index, 1);
      this.temp.orgs.splice(index, 1)
      removeTag(option)
    },
    async getFounders() {
      await Axios.get('/api/organizations/founders').then(resp => this.founders = resp.data.map(item => {
        return {value: item.id, text: item.founder}
      }));
    },
    async getRegions() {
      await Axios.get('/api/organizations/regions').then(resp => this.regions = resp.data.map(item => {
        return {value: item.id, text: item.region}
      }));
    },
    beforeEnter: function (el) {
      el.style.opacity = 0
    },
    enter: function (el, done) {
      let delay = el.dataset.index * 5
      setTimeout(function () {
        Velocity(
            el,
            {opacity: 1},
            {complete: done}
        )
      }, delay)
    },
    leave: function (el, done) {
      let delay = el.dataset.index * 2;
      setTimeout(function () {
        Velocity(
            el,
            {opacity: 0,},
            {complete: done}
        )
      }, delay)
    },
    clear() {
      this.search = '';
    },
    onOptionClick({option, addTag}) {
      addTag(option.text);
      this.temp.orgs.push(option);
      this.filter.id.push(option.value)
      this.clear();
    },
  }
}
</script>

<style scoped>
.spinner-middle{
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.item {
  cursor: pointer;
}

.item:hover {
  background: rgba(23, 0, 154, 0.2);
  cursor: pointer;
}

</style>
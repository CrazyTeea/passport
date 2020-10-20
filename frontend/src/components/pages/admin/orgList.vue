<template>
  <div>
    <nav-bar/>
    <div class="container">
      <h3>Статистика по организациям</h3>
      <hr class="mt-3">

      <b-card no-body>
        <b-card-header class="p-1" role="tab">
          <label v-b-toggle.filter class="d-block ml-2 font-weight-bold">
            <span class="mb-2">Фильтр</span>
            <i class="fas mt-2 fa-filter"></i>
          </label>
        </b-card-header>
        <b-collapse role="tabpanel" id="filter" accordion="filter">
          <div class="container">
            <b-form-group label-class="font-weight-bold" label="Выбранные организации">
              <b-form-tags v-model="value" no-outer-focus class="mb-2 border-0">
                <template v-slot="{ tags, disabled, addTag, removeTag }">
                  <ul v-if="tags.length > 0" class="list-inline d-inline-block mb-2">
                    <li v-for="tag in tags" :key="tag" class="list-inline-item">
                      <b-form-tag
                          @remove="removeTag(tag)"
                          :title="tag"
                          :disabled="disabled"
                          variant="info"
                      >{{ tag }}
                      </b-form-tag>
                    </li>
                  </ul>


                  <b-form-group
                      label-for="tag-search-input"
                      label="Поиск организации"
                      label-cols-md="auto"
                      class="mb-0"
                      label-size="sm"
                      :description="searchDesc"
                      :disabled="disabled"
                  >
                    <b-form-input
                        v-model="search"
                        id="tag-search-input"
                        type="search"
                        size="sm"
                        autocomplete="off"
                    ></b-form-input>
                  </b-form-group>


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
                        @click="onOptionClick({ option:option.text, addTag })"
                    >
                      {{ option.text }}
                    </div>
                  </transition-group>

                  <div v-if="availableOptions.length === 0">
                    Для выбора организации введите ее название
                  </div>

                </template>
              </b-form-tags>
            </b-form-group>

          </div>
        </b-collapse>
      </b-card>

    </div>
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
  VBToggle
} from 'bootstrap-vue'

export default {
  name: "orgList",
  directives: {
    BToggle: VBToggle
  },
  components: {
    NavBar,
    BCard, BFormTag,
    BCardHeader,
    BCollapse,
    BFormGroup, BIcon,
    BFormSelect,
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
    }
    ,
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
        id: null,
        name: null
      },
      orgList: []
    }
  }
  ,
  async mounted() {

  }
  ,
  methods: {
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
      this.orgList = [];
    }
    ,
    onOptionClick({option, addTag}) {
      addTag(option)
      this.clear();
    }
    ,
  }
}
</script>

<style scoped>
.item{
  cursor: pointer;
}
.item:hover{
  background: rgba(23,0,154,0.2);
  cursor: pointer;
}

</style>
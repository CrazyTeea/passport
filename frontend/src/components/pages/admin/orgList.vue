
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
            <b-form-group label="Выбранные организации">
              <b-form-tags v-model="value" no-outer-focus class="mb-2">
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

                  <b-dropdown @hidden="clear" size="sm" variant="outline-secondary" block menu-class="w-100">
                    <template #button-content>
                      <b-icon icon="tag-fill"></b-icon>
                      Выберите
                    </template>
                    <b-dropdown-form @submit.stop.prevent="() => {}">
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
                    </b-dropdown-form>
                    <b-dropdown-divider></b-dropdown-divider>
                    <transition-group name="staggered-fade"
                                      v-bind:css="false"
                                      v-on:before-enter="beforeEnter"
                                      v-on:enter="enter"
                                      v-on:leave="leave"
                    >
                      <b-dropdown-item-button
                          v-for="option in availableOptions"
                          :key="option.value"
                          @click="onOptionClick({ option:option.text, addTag })"
                      >
                        {{ option.text }}
                      </b-dropdown-item-button>
                    </transition-group>

                    <b-dropdown-text v-if="availableOptions.length === 0">
                      Для выбора организации введите ее название
                    </b-dropdown-text>
                  </b-dropdown>
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
  BDropdown,
  BDropdownDivider,
  BDropdownForm,
  BDropdownItemButton,
  BDropdownText,
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
    BCollapse, BDropdownForm,
    BFormGroup, BIcon, BDropdownDivider,
    BFormSelect, BDropdown, BDropdownItemButton,
    BFormInput, BFormTags, BDropdownText,
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
      el.style.height = 0
    },
    enter: function (el, done) {
      let delay = el.dataset.index * 150
      setTimeout(function () {
        Velocity(
            el,
            {opacity: 1, height: '1.6em'},
            {complete: done}
        )
      }, delay)
    },
    leave: function (el, done) {
      let delay = el.dataset.index * 150
      setTimeout(function () {
        Velocity(
            el,
            {opacity: 0, height: 0},
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

</style>
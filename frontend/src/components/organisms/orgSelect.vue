<template>
  <div>

    <b-form-group class="mt-2" label-class="font-weight-bold" label="Выбранная организация">

      <b-form-input
          v-if="!org_name"
          v-model="search"
          id="tag-search-input"
          type="search"
          autocomplete="off"
          placeholder="Начинайте вводить название"
      />
      <div v-else class="row">
        <div class="col"><h4 class="text-success">{{ org_name }}</h4></div>
        <div class="col"><i @click="org_name=null" class="pointer mt-2 float-left text-danger fas fa-trash"></i></div>
      </div>

      <transition-group name="staggered-fade"
                        :css="false"
                        @before-enter="beforeEnter"
                        @enter="enter"
                        @leave="leave"
      >
        <div
            class="item"
            v-for="(option,index) in availableOptions"
            :key="option.value"
            :data-index="index"
            @click="onOptionClick(option)"
        >
          {{ option.text }}
        </div>
      </transition-group>

    </b-form-group>

    <hr class="mt-2">

  </div>
</template>

<script>
import Axios from 'axios'
import {BFormGroup, BFormInput} from 'bootstrap-vue'

export default {
  name: "orgSelect",
  props: ['value'],
  data() {
    return {
      search: '',
      org_name: null
    }
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
  },
  components: {
    BFormInput,
    BFormGroup
  },
  async mounted() {
    let orgs = await Axios.get('/api/organizations/all', {
            params: {
              name: this.criteria
            }
          }).then(response => response.data.map(item => {
            return {
              value: item.id,
              text: item.name
            }
          }));
    let arr = [];
    let toNum = num => typeof num === 'string' ? num.toNumber() : (num || 0);
    this.org_name = orgs.find(item=>toNum(item.value) === toNum(this.value)).text;
  },
  methods: {
    beforeEnter: function (el) {
      el.style.opacity = 0
    },
    onOptionClick(item) {

      this.$emit('input', item.value)
      this.org_name = item.text;
      this.clear()
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
  }

}
</script>

<style scoped>

.item {
  cursor: pointer;
}

.item:hover {
  background: rgba(23, 0, 154, 0.2);
  cursor: pointer;
}

.pointer {
  cursor: pointer;
}
</style>
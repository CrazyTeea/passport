<template>
  <div class="dropdown">
    <input :disabled="disabled" @click="clicked = true" v-if="Object.keys(selectedItem).length === 0"
           ref="dropdowninput" v-model.trim="inputValue"
           class="dropdown-input" type="text" placeholder="Страна..."/>
    <div v-else @click="resetSelection" class="dropdown-selected">
      <img :src="selectedItem.flag" class="dropdown-item-flag" alt=""/>
      {{ selectedItem.name }}
    </div>
    <div @mouseleave="clicked=false" v-show="clicked && apiLoaded" class="dropdown-list">
      <div @click="selectItem(item)" v-show="itemVisible(item)" v-for="item in itemList" :key="item.name"
           class="dropdown-item">
        <img :src="item.flag" class="dropdown-item-flag" alt="item.flag"/>
        {{ item.name }}
      </div>
    </div>
  </div>
</template>

<script>
import Axios from 'axios'

export default {
  props: {
    modelVal: String,
    disabled: false
  },
  data() {
    return {
      selectedItem: {},
      inputValue: '',
      clicked: false,
      itemList: [],
      apiLoaded: false,
      apiFlag: 'https://restcountries.eu/rest/v2/all?fields=name;flag;alpha2Code',
    }
  },
  async mounted() {
    await this.getList();

    if (this.modelVal) {
      this.selectedItem = this.itemList.find(item => item.alpha2Code === this.modelVal) || {}
    }

  },
  methods: {
    resetSelection() {
      if (!this.disabled) {
        this.clicked = true;
        this.selectedItem = {};
        this.$nextTick(() => this.$refs.dropdowninput.focus());
        this.$emit('on-item-reset');
      }

    },
    selectItem(theItem) {
      if (!this.disabled) {
        this.clicked = false;
        this.selectedItem = theItem;
        this.inputValue = '';
        this.$emit('on-item-selected', theItem);
      }
    },
    itemVisible(item) {
      let currentName = item.name.toLowerCase();
      let currentInput = this.inputValue.toLowerCase();
      return currentName.includes(currentInput);
    },
    async getList() {


      await Axios.get(this.apiFlag).then(response => {
        this.itemList = response.data;
        this.apiLoaded = true;
        //    console.log(typeof response.data,response.data)
      });


    }
  }
}
</script>

<style scoped>
.dropdown {
  position: relative;
  width: 100%;
  max-width: 400px;
  margin: 0 auto;
}

.dropdown-input, .dropdown-selected {
  width: 100%;
  padding: 10px 16px;
  border: 1px solid transparent;
  background: #edf2f7;
  line-height: 1.5em;
  outline: none;
  border-radius: 8px;
}

.dropdown-input:focus, .dropdown-selected:hover {
  background: #fff;
  border-color: #e2e8f0;
}

.dropdown-input::placeholder {
  opacity: 0.7;
}

.dropdown-selected {
  font-weight: bold;
  cursor: pointer;
}

.dropdown-list {
  position: absolute;
  z-index: 2;
  width: 100%;
  max-height: 500px;
  margin-top: 4px;
  overflow-y: auto;
  background: #ffffff;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
  border-radius: 8px;
}

.dropdown-item {
  display: flex;
  width: 100%;
  padding: 11px 16px;
  cursor: pointer;
}

.dropdown-item:hover {
  background: #edf2f7;
}

.dropdown-item-flag {
  max-width: 24px;
  max-height: 18px;
  margin: auto 12px auto 0;
}
</style>
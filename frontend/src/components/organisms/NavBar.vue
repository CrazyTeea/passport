<template>
  <div>
    <div class="animate-height">
    <div class="custom-navbar">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col m-auto">

            <b-dropdown variant="transparent" menu-class="dropdown-menu" toggle-class=" text-decoration-none" no-caret>
              <template v-slot:button-content>
                <i class="fas fa-align-justify"></i>
              </template>
              <b-dropdown-item :href="isAdmin ? `/admin/data/${id_org}` : '/main'">Главная</b-dropdown-item>
              <b-dropdown-text>
                <i>
                  Данные об организации
                </i>
              </b-dropdown-text>
              <b-dropdown-item :href="isAdmin ? `/admin/org-info/${id_org}` : '/org-info'">Сведения об организации</b-dropdown-item>
              <b-dropdown-item :href="isAdmin ? `/admin/area-info/${id_org}` : '/area-info'">Сведения о колличесве мест и площади</b-dropdown-item>
              <b-dropdown-item :href="isAdmin ? `/admin/living-info/${id_org}` : '/living-info'">Сведения о проживающих</b-dropdown-item>
              <b-dropdown-item :href="isAdmin ? `/admin/living-info-inv/${id_org}` : '/living-info-inv'">Сведения о проживающих лицах <br> с ограниченными возможностями
              </b-dropdown-item>
              <b-dropdown-text>

                <i>
                  Данные о жилом объекте
                </i>
              </b-dropdown-text>
              <b-dropdown-item :href="isAdmin ? `/admin/objects-info/${id_org}` : '/objects-info'">Сведения о жилом объекте</b-dropdown-item>
              <b-dropdown-item :href="isAdmin ? `/admin/objects-area/${id_org}` : '/objects-area'">Сведения о площади, проживающих <br> и колличестве мест
              </b-dropdown-item>
              <b-dropdown-item :href="isAdmin ? `/admin/objects-money/${id_org}` : '/objects-money'">Сведения о поступлениях и расходах</b-dropdown-item>
              <b-dropdown-item :href="isAdmin ? `/admin/objects-tariff/${id_org}` : '/objects-tariff'">Сведения о тарифах</b-dropdown-item>
              <b-dropdown-text v-can:user>
                <i>
                  Документы
                </i>
              </b-dropdown-text>
              <b-dropdown-item :href="isAdmin ? `/admin/documents/${id_org}` : '/documents'">{{ isAdmin ? 'Документы' : 'Загрузить документы' }}</b-dropdown-item>

            </b-dropdown>

          </div>
          <div class=" col m-auto"><span class="font-weight-bold">Количество объектов: {{ objCnt }}</span></div>
          <div class=" col m-auto"><span class="font-weight-bold">Выгрузить в excel
            <i class="fas text-success fa-file-excel"></i>
          </span>
          </div>
          <div v-can:user v-if="saveButton" class=" col mt-2 mb-2">

            <transition
                mode="out-in"
                name="banner-apper">
              <b-button pill :key="blockSave" class="font-weight-bold" size="sm" variant="outline-primary" block
                        @click="click">{{ blockSave ? 'Редактировать' : 'Сохранить' }}
              </b-button>
            </transition>

          </div>
        </div>
      </div>
    </div>

    <b-alert v-can:user v-if="!blockSave" show>
      <div class="text-center">
        "После внесения данных на странице не забудьте нажать кнопку "Сохранить"
      </div>
    </b-alert>

  </div>

  <div style="margin-top: 12vh" v-can:user></div>
  </div>


</template>

<script>
import {BAlert, BButton, BDropdown, BDropdownItem, BDropdownText,} from 'bootstrap-vue';

import Axios from 'axios';

export default {
  components: {
    BDropdown,
    BDropdownItem,
    BDropdownText,
    BButton,
    BAlert,
  },
  props: {
    id_org: null,
    isAdmin:false,
    saveButton: {
      default: true,
    },
  },
  data() {
    return {
      blockSave: false,
      objCnt: 0,
    };
  },
  watch: {
    async id_org() {
     // console.log(this.id_org)
      await this.getObjCnt();
    },
  },
  async mounted() {
  await this.getObjCnt()
    },
  methods: {
    async getObjCnt() {
     // console.log(this.id_org)
      if (this.id_org) {
        await Axios.get(`/api/cnt-objects/org/${this.id_org}`).then((res) => this.objCnt = res.data);
      }
    },
    click() {
      if (this.blockSave) this.change();
      else this.save();
    },
    change() {
      this.blockSave = false;
      this.$emit('block-save');
    },
    save() {
      this.blockSave = true;
      this.$emit('save-page');
    },
  },
  name: 'navBar',
};
</script>

<style lang="scss">
.animate-height {
  //height: 100%;
  transition: all .6s ease;
  z-index: 056576995769567965;
}

.dropdown-menu {
  border: 1px solid #ebeef5;
  box-shadow: 0 5px 25px 0 rgba(0, 0, 0, 0.25);

  // Slide down transtion

  display: block !important;

  &:not(.show) {
    padding: 0;
    border-width: 0;
    //border-color: transparent;
    //box-shadow: none;

    transition: padding 1.3s ease, border-width 1.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
  }

  > li {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
  }

  &.show {
    > li {
      max-height: 100px;
    }
  }

  // Add chevron to top

  &[x-placement^="bottom"] {
    &::before {
      content: "";
      position: absolute;
      right: 11px;
      top: -5px;
      width: 0;
      height: 0;
      border-style: solid;
      border-width: 0 5px 5px 5px;
     // border-color: transparent transparent #fff transparent;
      z-index: 99999999;
    }
  }

  // Add chevron to bottom

  &[x-placement^="top"] {
    &::after {
      content: "";
      position: absolute;
      right: 11px;
      bottom: -5px;
      width: 0;
      height: 0;
      border-style: solid;
      border-width: 5px 5px 0 5px;
      //border-color: #fff transparent transparent transparent;
      z-index: 99999999;
    }
  }
}

.custom-navbar {
  background-color: white;
  //background: rgba(0, 0, 0, .1);

}

.banner-apper-enter-active {
  transition: all .6s ease;
}

.banner-apper-leave-active {
  transition: all .6s ease;
}

.banner-apper-enter, {
  transform: translateX(80px);
  opacity: 0;
}

.banner-apper-leave-to {
  transform: translateX(-80px);
  opacity: 0;
}

a {
  #scroll {
    display: none; /* Hidden by default */
    position: fixed; /* Fixed/sticky position */
    bottom: 20px; /* Place the button at the bottom of the page */
    right: 30px; /* Place the button 30px from the right */
    z-index: 99; /* Make sure it does not overlap */
    border: none; /* Remove borders */
    outline: none; /* Remove outline */
    background-color: red; /* Set a background color */
    color: white; /* Text color */
    cursor: pointer; /* Add a mouse pointer on hover */
    padding: 15px; /* Some padding */
    border-radius: 10px; /* Rounded corners */
    font-size: 18px; /* Increase font size */
  }

  #scroll:hover {
    background-color: #555; /* Add a dark-grey background on hover */
  }

}

</style>

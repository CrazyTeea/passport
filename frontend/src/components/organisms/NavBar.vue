<template>
  <div class="custom-navbar">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
        <div class="col  mb-2">

          <b-dropdown variant="transparent" menu-class="dropdown-menu" toggle-class=" text-decoration-none" no-caret>
            <template v-slot:button-content>
              <i class="fas fa-align-justify"></i>
            </template>
            <b-dropdown-item href="/main">Главная</b-dropdown-item>
            <b-dropdown-text>
              <hr>
              Данные об организации
              <hr>
            </b-dropdown-text>
            <b-dropdown-item href="/org-info">Сведения об организации</b-dropdown-item>
            <b-dropdown-item href="/area-info">Сведения о колличесве мест и площади</b-dropdown-item>
            <b-dropdown-item href="/living-info">Сведения о проживающих</b-dropdown-item>
            <b-dropdown-item href="/living-info-inv">Сведения о проживающих лицах <br> с ограниченными возможностями</b-dropdown-item>
            <b-dropdown-text>
              <hr>
              Данные о жилом объекте
              <hr>
            </b-dropdown-text>
            <b-dropdown-item href="/objects-info">Сведения о жилом объекте</b-dropdown-item>
            <b-dropdown-item href="/objects-area">Сведения о площади, проживающих <br> и колличестве мест</b-dropdown-item>
            <b-dropdown-item href="/objects-money">Сведения о поступлениях и расходах</b-dropdown-item>
            <b-dropdown-item href="/objects-tariff">Сведения о тарифах</b-dropdown-item>
            <b-dropdown-text>
              <hr>
              Документы
              <hr>
            </b-dropdown-text>
            <b-dropdown-item href="/documents">Загрузить документы</b-dropdown-item>

          </b-dropdown>


        </div>
        <div class=" col mt-2 mb-2"><span class="font-weight-bold">Количество объектов: 3</span></div>
        <div class=" col mt-2 mb-2"><span class="font-weight-bold">Выгрузить в excel <i class="fas text-success fa-file-excel"></i></span></div>
        <div v-if="saveButton" class=" col mt-2 mb-2">


          <transition
              mode="out-in"
              name="custom-classes-transition"
              enter-active-class="animated "
              leave-active-class="animated fadeOutLeft">
            <b-button pill :key="blockSave" class="font-weight-bold" size="sm" variant="outline-secondary" block  @click="click">{{blockSave ? 'Редактировать' : 'Сохранить'}}</b-button>
          </transition>

        </div>
      </div>
    </div>
  </div>

</template>

<script>
import {BButton, BDropdown, BDropdownItem, BDropdownText, BFormCheckbox} from 'bootstrap-vue';

export default {
  components:{
    BFormCheckbox,
    BDropdown,
    BDropdownItem,
    BDropdownText,
    BButton
  },
  props: {
    saveButton: {
      default:true
    }
  },
  data(){
    return {
      blockSave:true,
    }
  },
  methods:{
    click(){
      if (this.blockSave) this.change();
      else this.save();
    },
    change(){
      this.blockSave = false;
      this.$emit('block-save');
    },
    save(){
      this.blockSave = true;
      this.$emit('save-page');
    }
  },
  name: "navBar"
}
</script>

<style lang="scss">


.dropdown-menu {
  border: 1px solid #ebeef5;
  box-shadow: 0 5px 25px 0 rgba(0, 0, 0, 0.25);

  // Slide down transtion

  display: block !important;

  &:not(.show) {
    padding: 0;
    border-width: 0;
    border-color: transparent;
    box-shadow: none;

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
      content:"";
      position: absolute;
      right: 11px;
      top: -5px;
      width: 0;
      height: 0;
      border-style: solid;
      border-width: 0 5px 5px 5px;
      border-color: transparent transparent #fff transparent;
      z-index: 99999999;
    }
  }

  // Add chevron to bottom

  &[x-placement^="top"] {
    &::after {
      content:"";
      position: absolute;
      right: 11px;
      bottom: -5px;
      width: 0;
      height: 0;
      border-style: solid;
      border-width: 5px 5px 0 5px;
      border-color: #fff transparent transparent transparent;
      z-index: 99999999;
    }
  }
}


.custom-navbar{
  background: rgba(0,0,0,.1);
}



</style>
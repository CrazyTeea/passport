<template>
    <div class="custom-navbar">
        <div class="row">
            <div class="col-1 offset-3">

                <b-dropdown variant="transparent" toggle-class="dropdown-menu drop text-decoration-none" no-caret>
                    <template v-slot:button-content>
                        <i class="fas fa-align-justify"></i>
                    </template>
                    <b-dropdown-item href="/main">Главная</b-dropdown-item>
                    <b-dropdown-text>
                        Данные об организации
                    </b-dropdown-text>
                    <b-dropdown-item href="/org-info">Сведения об организации</b-dropdown-item>
                    <b-dropdown-item href="/area-info">Сведения о колличесве мест и площади</b-dropdown-item>
                    <b-dropdown-item href="/living-info">Сведения о проживающих</b-dropdown-item>
                    <b-dropdown-item>Сведения о проживающих лицах <br> с ограниченными возможностями</b-dropdown-item>
                    <b-dropdown-text>
                        Данные о жилом объекте
                    </b-dropdown-text>
                    <b-dropdown-item>Сведения о жилом объекте</b-dropdown-item>
                    <b-dropdown-item>Сведения о площади, проживающих <br> и колличестве мест</b-dropdown-item>
                    <b-dropdown-item>Сведения о поступлениях и расходах</b-dropdown-item>
                    <b-dropdown-item>Сведения о тарифах</b-dropdown-item>
                    <b-dropdown-text>
                        Документы
                    </b-dropdown-text>
                    <b-dropdown-item>Загрузить документы</b-dropdown-item>

                </b-dropdown>
            </div>
            <div class="col-sm-2"><span class="font-weight-normal">Колличество объектов: 3</span></div>
            <div class="col-sm-1"><span class="font-weight-normal">Выгрузить в exel</span></div>
            <div class="col-2">
                <div class="row">
                    <div class="col-6"><span class="font-weight-normal">Режим редактирования</span></div>
                    <div class="col-2">
                        <b-form-checkbox size="lg" @change="$emit('block-save')" v-model="blockSave" inline switch/>
                    </div>
                    <div class="col-1">
                        <transition name="slide-fade">
                            <b-button  @click="$emit('save-page')" v-if="blockSave" size="sm" variant="outline-secondary">Сохранить</b-button>
                        </transition>
                    </div>
                </div>


            </div>
        </div>
    </div>
</template>

<script>
    import {BDropdown,BButton,
        BDropdownItem,BFormCheckbox,
        BDropdownText} from 'bootstrap-vue';
    export default {
        components:{
            BFormCheckbox,
            BDropdown,
            BDropdownItem,
            BDropdownText,
            BButton
        },
        data(){
            return {
                blockSave:false,
                savePage:false
            }
        },
        name: "navBar"
    }
</script>

<style lang="scss">


    .slide-fade-enter-active {
        transition: all .4s ease;
    }
    .slide-fade-leave-active {
        transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active до версии 2.1.8 */ {
        transform: translateX(10px);
        opacity: 0;
    }

    .custom-navbar{
        background: rgba(0,0,0,.1);
    }

    .dropdown-enter-active{
        animation: bounce-in .5s;
    }
    .dropdown-leave-active {
        animation: bounce-in .5s reverse;
    }

    .dropdown-menu {
        border: 1px solid #ebeef5;
        box-shadow: 0 5px 25px 0 rgba(0, 0, 0, 0.25);
        display: block !important;

        &:not(.show) {
            background: rgba(0,0,0,.01);
            padding: 0;
            border-width: 0;
            border-color: transparent;
            box-shadow: none;

            min-width: unset !important;

            transition: padding 1s ease, border-width 1.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        > li {
            max-height: 0;
            overflow: hidden;
            transition: max-height 1s ease;
        }

        &.show {
            > li {
                max-height: 100px;
            }
        }


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

</style>
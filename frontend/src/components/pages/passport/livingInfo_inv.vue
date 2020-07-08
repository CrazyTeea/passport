<template>
    <div>
        <nav-bar v-on:block-save="blockSave = !blockSave"/>
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <h3>
                        Сведения о проживающих лицах с ограниченными возможностями в жилищном фонде, используемом в уставной деятельности
                    </h3>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-6"><label for="living_cnt_inv">Проживающие из числа обучающихся с ограниченными возможностями здоровья</label></div>
                <div class="col-6">
                    <b-input-group append="Человек">
                        <b-form-input id="living_cnt_inv" disabled/>
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
                    <living-table title="Проживающие из числа обучающихся с ограниченными возможностями здоровья за счёт федерального бюджета" :is-invalid="true" :block-save="blockSave" v-bind:can-save="[0,1,2,3,4,5,6,7,8]"/>

                </b-tab>
                <b-tab no-body >
                    <template v-slot:title>
                        <span class="text-secondary">
                        За счёт бюджета субъекта
                        </span>
                    </template>
                    <living-table title="Проживающие из числа обучающихся с ограниченными возможностями здоровья за счёт федерального бюджета" :is-invalid="true" :block-save="blockSave" v-bind:can-save="[0,1,2,3,4,5,6,7,8]"/>

                </b-tab>
                <b-tab no-body >
                    <template v-slot:title>
                        <span class="text-secondary">
                        За счёт местного бюджета
                        </span>
                    </template>
                    <living-table title="Проживающие из числа обучающихся с ограниченными возможностями здоровья за счёт федерального бюджета" :is-invalid="true" :block-save="blockSave" v-bind:can-save="[0,1,2,3,4,5,6,7,8]"/>

                </b-tab>
                <b-tab no-body >
                    <template v-slot:title>
                        <span class="text-secondary">
                              По договорам об оказании
                        платных образовательных услуг
                        </span>
                    </template>
                    <living-table title="Проживающие из числа обучающихся с ограниченными возможностями здоровья за счёт федерального бюджета" :is-invalid="true" :block-save="blockSave" v-bind:can-save="[0,1,2,3,4,5,6,7,8]"/>

                </b-tab>
            </b-tabs>


        </div>
    </div>

</template>

<script>
    import NavBar from "../../organisms/NavBar";
    import livingTable from "../../organisms/livingTable";
    import {BFormInput, BInputGroup, BTab, BTabs} from 'bootstrap-vue'

    export default {
        name: "livingInfo_inv",
        data(){
          return {
              blockSave:true
          }
        },
        components:{
            NavBar,
            livingTable,
            BFormInput,
            BInputGroup,
            BTabs,BTab,
        },
    }
</script>

<style scoped>

</style>
<template>
    <div>
        <nav-bar v-on:block-save="blockPage = !blockPage"/>
        <div class="page">
            <div class="row">
                <div class="col-8">
                    <h3>
                        Сведения о проживающих в жилищном фонде, используемом в уставной деятельности
                    </h3>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-6">
                    <label for="living_cnt">Всего проживающих</label>
                </div>
                <div class="col-6">
                    <b-input-group append="Человек">
                        <b-form-input id="living_cnt"/>
                    </b-input-group>
                </div>
            </div>

            <hr>

            <div class="row ">
                <div class="col-6">
                    <label for="living_cnt">Проживающие из числа обучающихся</label>
                </div>
                <div class="col-6">
                    <b-input-group append="Человек">
                        <b-form-input id="living_cnt_students"/>
                    </b-input-group>
                </div>
            </div>

            <b-tabs content-class="mt-3" nav-class="font-weigh-bold" small justified>
                <b-tab no-body>
                    <template v-slot:title>
                        <span class="text-secondary">
                        За счёт федерального бюджета
                        </span>
                    </template>
                    <living-table/>
                </b-tab>
                <b-tab no-body >
                    <template v-slot:title>
                        <span class="text-secondary">
                        За счёт бюджета субъекта
                        </span>
                    </template>
                    <living-table/>
                </b-tab>
                <b-tab no-body >
                    <template v-slot:title>
                        <span class="text-secondary">
                        За счёт местного бюджета
                        </span>
                    </template>
                    <living-table/>
                </b-tab>
                <b-tab no-body >
                    <template v-slot:title>
                        <span class="text-secondary">
                              По договорам об оказании
                        платных образовательных услуг
                        </span>
                    </template>
                    <living-table/>
                </b-tab>
            </b-tabs>
            <div class="row">
                <div class="col-6">
                    <label for="live_proz_poluch_step">Проживающие из числа обучающихся, получающие государственную соц. стипендию</label>
                </div>
                <div class="col-6">
                    <b-input-group append="Человек">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="bitch_tooltip" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="bitch_tooltip">
                                Количество проживающих, указанных в ч.5 ст.36 от 29.12.2012
                                № 273-ФЗ «Об образовании в Российской Федерации»
                            </b-tooltip>
                        </template>
                        <b-form-input id="live_proz_poluch_step"/>
                    </b-input-group>

                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-6">
                    <label for="live_proz_person">Проживающие из числа персонала и их семей</label>
                </div>
                <div class="col-6">
                    <b-input-group append="Человек">
                        <b-form-input id="live_proz_person"/>
                    </b-input-group>
                </div>
            </div>
            <br>

            <b-table-simple borderless small>
                <b-thead>
                    <b-tr>
                        <b-th>Текст</b-th>
                        <b-th>Персонал</b-th>
                        <b-th>Члены семей</b-th>
                    </b-tr>
                </b-thead>
                <b-tbody>
                    <b-tr>
                        <b-td>Работники</b-td>
                        <b-td><b-form-input/></b-td>
                        <b-td><b-form-input/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Научные сотрудники</b-td>
                        <b-td><b-form-input/></b-td>
                        <b-td><b-form-input/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Профессорско-преподавательский состав</b-td>
                        <b-td><b-form-input/></b-td>
                        <b-td><b-form-input/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Иные категории сотрудников организации</b-td>
                        <b-td><b-form-input/></b-td>
                        <b-td><b-form-input/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Всего</b-td>
                        <b-td><b-form-input disabled/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                </b-tbody>
            </b-table-simple>
            <hr>

            <div class="row">
                <div class="col-6">
                    <label for="live_inie_prozh">Иные проживающие</label>
                </div>
                <div class="col-6">
                    <b-input-group append="Человек">
                        <b-form-input id="live_inie_prozh"/>
                    </b-input-group>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import NavBar from "../../organisms/NavBar";
    import livingTable from "../../organisms/livingTable";
    import {BFormInput,BTableSimple,BInputGroupText,
        BThead,BTbody,BTh,BTd,BTr,BTooltip,BButton,
        BInputGroup,BTabs,BTab} from 'bootstrap-vue'
    export default {
        name: "livingInfo",
        components:{
            NavBar,
            livingTable,
            BFormInput,
            BInputGroup,
            BTabs,BTab,
            BTableSimple,
            BThead,BTbody,
            BTh,BTd,BTr,
            BInputGroupText,
            BTooltip,BButton
        },
        data(){
            return {
                blockPage:true,

            }
        }
    }
</script>

<style scoped>
    .page{
        margin-top: 15px;
        margin-right: 25%;
        margin-left: 25%;
    }
    th{
        min-width: 100px;
        max-width: 100px;
    }



</style>
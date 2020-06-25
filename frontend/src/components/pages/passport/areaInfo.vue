<template>
    <div>
        <nav-bar v-on:block-save="blockSave =!blockSave"/>
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <h3>Сведения о количестве мест и площади жилищного фонда, используемого в уставной деятельности</h3>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <h4>Площадь</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><label class="font-weight-bold" for="org_area">Общая площадь, пригодная для проживания</label></div>
                <div class="col-6">
                    <b-input-group>
                        <template v-slot:append>
                            <b-input-group-text>м<sup>2</sup></b-input-group-text>
                        </template>
                        <b-form-input id="org_area" disabled/>
                    </b-input-group>

                </div>
            </div>
            <div class="row">
                <div class="col-6 "><label class="point-1  font-weight-bold" for="org_area_live">1. Жилая площадь, пригодная для проживания</label></div>
                <div class="col-6">
                    <b-input-group>
                        <template v-slot:append>
                            <b-input-group-text>м<sup>2</sup></b-input-group-text>
                        </template>
                        <b-form-input id="org_area_live" disabled/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6 "><label class="point-2 font-weight-bold" for="org_area_students">А. Занятая обучающимися</label></div>
                <div class="col-6">
                    <b-input-group>
                        <template v-slot:append>
                            <b-input-group-text>м<sup>2</sup></b-input-group-text>
                        </template>
                        <b-form-input id="org_area_students" disabled/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><label class=" point-2 font-weight-bold" for="org_area_foreign">Б. Занятая иными категориями нанимателей</label></div>
                <div class="col-6">
                    <b-input-group>
                        <template v-slot:append>
                            <b-input-group-text>м<sup>2</sup></b-input-group-text>
                        </template>
                        <b-form-input id="org_area_foreign" disabled/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6 "><label class="point-2 font-weight-bold" for="org_area_svod">В. Свободная</label></div>
                <div class="col-6 ">
                    <b-input-group>
                        <template v-slot:append>
                            <b-input-group-text>м<sup>2</sup></b-input-group-text>
                        </template>
                        <b-form-input id="org_area_svod" disabled/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><label class="point-2 font-weight-bold" for="org_area_not_used">Г. Неиспользуемая</label></div>
                <div class="col-6 ">
                    <b-input-group>
                        <template v-slot:append>
                            <b-input-group-text>м<sup>2</sup></b-input-group-text>
                        </template>
                        <b-form-input id="org_area_not_used" disabled/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6 "><label class="point-1 font-weight-bold" for="org_area_not_live_prigod">2. Нежилая площадь в пригодных для проживания объектах</label></div>
                <div class="col-6 ">
                    <b-input-group>
                        <template v-slot:append>
                            <b-input-group-text>м<sup>2</sup></b-input-group-text>
                        </template>
                        <b-form-input id="org_area_not_live_prigod" disabled/>
                    </b-input-group>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-6"><label class="font-weight-bold" for="org_area_not_prigod">Общая площадь, непригодная для проживания</label></div>
                <div class="col-6">
                    <b-input-group>
                        <template v-slot:append>
                            <b-input-group-text>м<sup>2</sup></b-input-group-text>
                        </template>
                        <b-form-input id="org_area_not_prigod" disabled/>
                    </b-input-group>
                </div>
            </div>

            <b-table-simple borderless>
                <b-thead>
                    <b-tr>
                        <b-th>Общая площадь, непригодная для проживания</b-th>
                        <b-th>Жилая площадь</b-th>
                        <b-th>Нежилая площадь</b-th>
                        <b-th>Общая площадь</b-th>
                    </b-tr>
                </b-thead>
                <b-tbody>
                    <b-tr>
                        <b-td>Требует капитального ремонта</b-td>
                        <b-td><b-form-input disabled/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Находится в аварийном состоянии</b-td>
                        <b-td><b-form-input disabled/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Непригодна для проживания</b-td>
                        <b-td><b-form-input disabled/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                </b-tbody>
            </b-table-simple>

            <hr>

            <div class="row">
                <div class="col-6"><label class="font-weight-bold" for="org_area_metres">Количество квадратных метров жилой площади на одного проживающего</label></div>
                <div class="col-6">
                    <b-input-group>
                        <template v-slot:append>
                            <b-input-group-text>м<sup>2</sup></b-input-group-text>
                        </template>
                        <b-form-input id="org_area_metres" disabled/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><label class="font-weight-bold" for="org_area_metres_2">Количество квадратных метров общей площади на одного проживающего</label></div>
                <div class="col-6">
                    <b-input-group>
                        <template v-slot:append>
                            <b-input-group-text>м<sup>2</sup></b-input-group-text>
                        </template>
                        <b-form-input id="org_area_metres_2" disabled/>
                    </b-input-group>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-6"><label class="font-weight-bold" for="org_area_not_used_ustav">Площадь объектов, не используемых в уставной деятельности</label></div>
                <div class="col-6">
                    <b-input-group>
                        <template v-slot:append>
                            <b-input-group-text>м<sup>2</sup></b-input-group-text>
                        </template>
                        <b-form-input id="org_area_not_used_ustav" disabled/>
                    </b-input-group>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <h4>Места</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><label class="font-weight-bold" for="org_area_cnt_mest">Количество мест</label></div>
                <div class="col-6">
                    <b-input-group append="мест">
                        <b-form-input id="org_area_cnt_mest" disabled/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6 "><label class="point-1 font-weight-bold" for="org_area_cnt_mest_prig">1. Количество пригодных для проживания мест</label></div>
                <div class="col-6 ">
                    <b-input-group  append="мест">
                        <b-form-input id="org_area_cnt_mest_prig" disabled/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><label class="point-2 font-weight-bold" for="org_area_cnt_mest_zan">А. Количество мест, занятых обучающимися</label></div>
                <div class="col-6 ">
                    <b-input-group  append="мест">
                        <b-form-input id="org_area_cnt_mest_zan" disabled/>
                    </b-input-group>
                </div>
            </div>

            <b-table-simple borderless>
                <b-thead>
                    <b-tr>
                        <b-th>А. Количество мест, занятых обучающимися</b-th>
                        <b-th><6 м2 на одного проживающего</b-th>
                        <b-th>6 м2 и более на одного проживающего</b-th>
                        <b-th>Всего</b-th>
                    </b-tr>
                </b-thead>
                <b-tbody>
                    <b-tr>
                        <b-td>
                            Среднее профессиональное образование
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>
                            Бакалавриат
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>
                            Специалитет
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>
                            Магистратура
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>
                            Аспирантура
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>
                            Ординатрура
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>
                            Иные обучающиеся
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>
                            Всего
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input disabled/>
                        </b-td>
                    </b-tr>
                </b-tbody>
            </b-table-simple>

            <div class="row">
                <div class="col-6 "><label class="point-2 font-weight-bold" for="org_area_cnt_mest_zan_inie">Б. Количество мест, занятых иными категориями проживающих</label></div>
                <div class="col-6">
                    <b-input-group append="мест">
                        <b-form-input id="org_area_cnt_mest_zan_inie" disabled/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6 "><label class="point-2 font-weight-bold" for="org_area_cnt_svod_mest">В. Количество свободных мест</label></div>
                <div class="col-6 ">
                    <b-input-group append="мест">
                        <b-form-input id="org_area_cnt_svod_mest" disabled/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6 "><label class="point-2 font-weight-bold" for="org_area_cnt_neisp_mest">Г. Количество неиспользуемых мест</label></div>
                <div class="col-6 ">
                    <b-input-group append="мест">
                        <b-form-input id="org_area_cnt_neisp_mest" disabled/>
                    </b-input-group>
                </div>
            </div>

            <div class="row">
                <div class="col-6"><label class=" point-1 font-weight-bold" for="org_area_cnt_neprig_mest">2. Количество непригодных к использованию мест</label></div>
                <div class="col-6">
                    <b-input-group append="мест">
                        <b-form-input id="org_area_cnt_neprig_mest" disabled/>
                    </b-input-group>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-6"><label class="font-weight-bold" for="org_area_cnt_mest_invalid">Количество мест оборудованных для лиц с ограниченными возможностями здоровья</label></div>
                <div class="col-6">
                    <b-input-group append="мест">
                        <b-form-input id="org_area_cnt_mest_invalid" disabled/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><label class="font-weight-bold" for="org_area_cnt_mest_nuzd">Количество обучающихся, нуждающихся в жилье</label></div>
                <div class="col-6">
                    <b-input-group append="человек">
                        <b-form-input id="org_area_cnt_mest_nuzd" :disabled="blockSave"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><label class="font-weight-bold" for="org_area_cnt_live_in_other">Количество обучающихся, проживающих в жилом фонде других организаций</label></div>
                <div class="col-6">
                    <b-input-group append="человек">
                        <b-form-input id="org_area_cnt_live_in_other" :disabled="blockSave"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><label class="font-weight-bold" for="org_area_cnt_mest_vost_rab">Количество мест, возможных к вводу в эксплуатацию после проведения восстановительных работ</label></div>
                <div class="col-6">
                    <b-input-group append="мест">
                        <b-form-input id="org_area_cnt_mest_vost_rab" disabled/>
                    </b-input-group>
                </div>
            </div>

            <div class="row">
                <div class="col-6"><label class="point-1 font-weight-bold" for="org_area_cnt_vozmozh_mest_prig">1. Количество мест, возможных к вводу в эксплуатацию из числа неиспользуемых после проведения восстановительных работ</label></div>
                <div class="col-6">
                    <b-input-group append="мест">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="bitch_tooltip" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="bitch_tooltip">
                                Восстановительные работы - проведение капитального ремонта/приведения
                                объекта в соответствие с установленными санитарными и техническими
                                правилами и нормами, иными требованиями законодательства
                            </b-tooltip>
                        </template>
                        <b-form-input id="org_area_cnt_vozmozh_mest_prig" disabled/>
                    </b-input-group>
                </div>
            </div>

            <div class="row">
                <div class="col-6"><label class="point-1 font-weight-bold" for="org_area_cnt_vozmozh_mest_ne_prig">2. Количество мест, возможных к вводу в эксплуатацию из числа непригодных к использованию после проведения восстановительных работ</label></div>
                <div class="col-6">
                    <b-input-group append="мест">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="bitch_tooltip2" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="bitch_tooltip2">
                                Восстановительные работы - проведение капитального ремонта/приведения
                                объекта в соответствие с установленными санитарными и техническими
                                правилами и нормами, иными требованиями законодательства
                            </b-tooltip>
                        </template>
                        <b-form-input id="org_area_cnt_vozmozh_mest_ne_prig" disabled/>
                    </b-input-group>
                </div>
            </div>



        </div>


    </div>
</template>

<script>
    import NavBar from "../../organisms/NavBar";
    import {BFormInput,BTableSimple,BTooltip,
        BInputGroup,BInputGroupText,
        BThead,BTbody,BTh,BTd,BTr} from 'bootstrap-vue'
    export default {
        components:{
            NavBar,
            BTooltip,
            BInputGroupText,
            BInputGroup,
            BFormInput,
            BTableSimple,
            BThead,
            BTbody,
            BTh,
            BTd,
            BTr
        },
        data(){
            return{
                blockSave:true,
            }
        }
    }
</script>

<style scoped>
    .tooltip_width .tooltip-inner{
        min-width: 100% !important;
        margin: 0 !important;
        display: block !important;
    }
    .row{
        margin-top: 5px;
    }
    .point-1{
        margin-left: 20px;
    }
    .point-2{
        margin-left: 30px;
    }
    .point-4{
        margin-left: 5%;
    }
    .point-5{
        margin-left: 6%;
    }
</style>
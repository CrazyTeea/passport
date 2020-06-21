<template>
    <div>
        <nav-bar/>
        <div class="page">
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
                <div class="col-6"><b-form-input id="org_area" disabled/> </div>
            </div>
            <div class="row">
                <div class="col-5 point-1"><label class="font-weight-bold" for="org_area_live">1. Жилая площадь, пригодная для проживания</label></div>
                <div class="col-6 point-5"><b-form-input id="org_area_live" disabled/></div>
            </div>
            <div class="row">
                <div class="col-5 point-2"><label class="font-weight-bold" for="org_area_students">А. Занятая обучающимися</label></div>
                <div class="col-6 point-4"><b-form-input id="org_area_students" disabled/></div>
            </div>
            <div class="row">
                <div class="col-5 point-2"><label class="font-weight-bold" for="org_area_foreign">Б. Занятая иными категориями нанимателей</label></div>
                <div class="col-6 point-4"><b-form-input id="org_area_foreign" disabled/></div>
            </div>
            <div class="row">
                <div class="col-5 point-2"><label class="font-weight-bold" for="org_area_svod">В. Свободная</label></div>
                <div class="col-6 point-4"><b-form-input id="org_area_svod" disabled/></div>
            </div>
            <div class="row">
                <div class="col-5 point-2"><label class="font-weight-bold" for="org_area_not_used">Г. Неиспользуемая</label></div>
                <div class="col-6 point-4"><b-form-input id="org_area_not_used" disabled/></div>
            </div>
            <div class="row">
                <div class="col-5 point-1"><label class="font-weight-bold" for="org_area_not_live_prigod">2. Нежилая площадь в пригодных для проживания объектах</label></div>
                <div class="col-6 point-5"><b-form-input id="org_area_not_live_prigod" disabled/></div>
            </div>
            <hr>

            <div class="row">
                <div class="col-6"><label class="font-weight-bold" for="org_area_not_prigod">Общая площадь, непригодная для проживания</label></div>
                <div class="col-6"><b-form-input id="org_area_not_prigod" disabled/> </div>
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
                <div class="col-6"><b-form-input id="org_area_metres" disabled/> </div>
            </div>
            <div class="row">
                <div class="col-6"><label class="font-weight-bold" for="org_area_metres_2">Количество квадратных метров общей площади на одного проживающего</label></div>
                <div class="col-6"><b-form-input id="org_area_metres_2" disabled/> </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-6"><label class="font-weight-bold" for="org_area_not_used_ustav">Площадь объектов, не используемых в уставной деятельности</label></div>
                <div class="col-6"><b-form-input id="org_area_not_used_ustav" disabled/> </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <h4>Мества</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><label class="font-weight-bold" for="org_area_cnt_mest">Количество мест</label></div>
                <div class="col-6"><b-form-input id="org_area_cnt_mest" disabled/> </div>
            </div>
            <div class="row">
                <div class="col-5 point-1"><label class="font-weight-bold" for="org_area_cnt_mest_prig">1. Количество пригодных для проживания мест</label></div>
                <div class="col-6 point-5"><b-form-input id="org_area_cnt_mest_prig" disabled/> </div>
            </div>
            <div class="row">
                <div class="col-5 point-2"><label class="font-weight-bold" for="org_area_cnt_mest_zan">А. Количество мест, занятых обучающимися</label></div>
                <div class="col-6 point-4"><b-form-input id="org_area_cnt_mest_zan" disabled/> </div>
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
                            <b-form-input></b-form-input>
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>
                            Бакалавриат
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>
                            Специалитет
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>
                            Магистратура
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>
                            Аспирантура
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>
                            Ординатрура
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>
                            Иные обучающиеся
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>
                            Всего
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                        <b-td>
                            <b-form-input></b-form-input>
                        </b-td>
                    </b-tr>
                </b-tbody>
            </b-table-simple>

        </div>


    </div>
</template>

<script>
    import NavBar from "../../organisms/NavBar";
    import {BFormInput,BTableSimple,BThead,BTbody,BTh,BTd,BTr} from 'bootstrap-vue'
    export default {
        components:{
            NavBar,
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

            }
        }
    }
</script>

<style scoped>
    input{
        margin-top: 5px;
    }
    .point-1{
        margin-left: 20px;
    }
    .point-2{
        margin-left: 30px;
    }
    .point-4{
        margin-left: 75px;
    }
    .point-5{
        margin-left: 85px;
    }
    .page{
        margin-top: 15px;
        margin-right: 25%;
        margin-left: 25%;
    }
</style>
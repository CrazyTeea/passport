<template>
    <transition enter-active-class="animated fadeInUp">
      <div v-if="componentReady">
        <nav-bar v-on:save-page="savePage" v-on:block-save="blockSave =!blockSave"/>
        <div v-if="organization.area" class="container">
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
                        <b-form-input id="org_area" v-model="organization.area.area_prig_prozh" disabled/>
                    </b-input-group>

                </div>
            </div>
            <div class="row">
                <div class="col-6 "><label class="ml-2  font-weight-bold" for="org_area_live">1. Жилая площадь, пригодная для проживания</label></div>
                <div class="col-6">
                    <b-input-group>
                        <template v-slot:append>
                            <b-input-group-text>м<sup>2</sup></b-input-group-text>
                        </template>
                        <b-form-input id="org_area_live" v-model="organization.area.area_zhil_prig_prozh" disabled/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6 "><label class="ml-4 font-weight-bold" for="org_area_students">А. Занятая обучающимися</label></div>
                <div class="col-6">
                    <b-input-group>
                        <template v-slot:append>
                            <b-input-group-text>м<sup>2</sup></b-input-group-text>
                        </template>
                        <b-form-input id="org_area_students" v-model="organization.area.area_zan_obuch" disabled/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><label class=" ml-4 font-weight-bold" for="org_area_foreign">Б. Занятая иными категориями нанимателей</label></div>
                <div class="col-6">
                    <b-input-group>
                        <template v-slot:append>
                            <b-input-group-text>м<sup>2</sup></b-input-group-text>
                        </template>
                        <b-form-input id="org_area_foreign" v-model="organization.area.area_in_kat_nan" disabled/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6 "><label class="ml-4 font-weight-bold" for="org_area_svod">В. Свободная</label></div>
                <div class="col-6 ">
                    <b-input-group>
                        <template v-slot:append>
                            <b-input-group-text>м<sup>2</sup></b-input-group-text>
                        </template>
                        <b-form-input id="org_area_svod" v-model="organization.area.svobod" disabled/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><label class="ml-4 font-weight-bold" for="org_area_not_used">Г. Неиспользуемая</label></div>
                <div class="col-6 ">
                    <b-input-group>
                        <template v-slot:append>
                            <b-input-group-text>м<sup>2</sup></b-input-group-text>
                        </template>
                        <b-form-input id="org_area_not_used" v-model="organization.area.ne_isp" disabled/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6 "><label class="ml-2 font-weight-bold" for="org_area_not_live_prigod">2. Нежилая площадь в пригодных для проживания объектах</label></div>
                <div class="col-6 ">
                    <b-input-group>
                        <template v-slot:append>
                            <b-input-group-text>м<sup>2</sup></b-input-group-text>
                        </template>
                        <b-form-input id="org_area_not_live_prigod" v-model="organization.area.ne_zhil_plosh_v_prig_dlya_prozh" disabled/>
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
                        <b-form-input id="org_area_not_prigod" v-model="organization.area.area_obsh_ne_prig_dlya_prozh" disabled/>
                    </b-input-group>
                </div>
            </div>

            <b-table-simple fixed borderless>
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
                        <b-td><b-form-input v-model="organization.area.area_zhil_t_k_r" disabled/></b-td>
                        <b-td><b-form-input v-model="organization.area.area_ne_zhil_n_a_s" disabled/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Находится в аварийном состоянии</b-td>
                        <b-td><b-form-input v-model="organization.area.area_zhil_n_a_s" disabled/></b-td>
                        <b-td><b-form-input v-model="organization.area.area_ne_zhil_n_a_s" disabled/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Непригодна для проживания</b-td>
                        <b-td><b-form-input v-model="organization.area.area_zhil_n_p" disabled/></b-td>
                        <b-td><b-form-input v-model="organization.area.area_ne_zhil_n_p" disabled/></b-td>
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
                        <b-form-input id="org_area_metres" v-model="organization.area.area_kv_metr_zhil"  disabled/>
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
                        <b-form-input id="org_area_metres_2" v-model="organization.area.area_kv_metr_obsh" disabled/>
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
                        <b-form-input id="org_area_not_used_ustav" v-model="organization.area.area_obj_ne_isp_v_ust_dey" disabled/>
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
                        <b-form-input id="org_area_cnt_mest" v-model="organization.area.area_cnt_mest" disabled/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6 "><label class="ml-2 font-weight-bold" for="org_area_cnt_mest_prig">1. Количество пригодных для проживания мест</label></div>
                <div class="col-6 ">
                    <b-input-group  append="мест">
                        <b-form-input id="org_area_cnt_mest_prig" v-model="organization.area.area_cnt_mest_prig_prozh" disabled/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><label class="ml-4 font-weight-bold" for="org_area_cnt_mest_zan">А. Количество мест, занятых обучающимися</label></div>
                <div class="col-6 ">
                    <b-input-group  append="мест">
                        <b-form-input id="org_area_cnt_mest_zan" v-model="organization.area.area_cnt_mest_zan_obuch" disabled/>
                    </b-input-group>
                </div>
            </div>

            <b-table-simple fixed borderless>
                <b-thead>
                    <b-tr>
                        <b-th>А. Количество мест, занятых обучающимися</b-th>
                        <b-th>м2 на одного проживающего</b-th>
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
                            <b-form-input v-model="organization.area.m2_spo" disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input v-model="organization.area.c6m2_spo" disabled/>
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
                            <b-form-input v-model="organization.area.m2_bak" disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input v-model="organization.area.c6m2_bak" disabled/>
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
                            <b-form-input v-model="organization.area.m2_spec" disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input v-model="organization.area.c6m2_spec" disabled/>
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
                            <b-form-input v-model="organization.area.m2_mag" disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input v-model="organization.area.c6m2_mag" disabled/>
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
                            <b-form-input v-model="organization.area.m2_asp" disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input v-model="organization.area.c6m2_asp" disabled/>
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
                            <b-form-input v-model="organization.area.m2_ord" disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input v-model="organization.area.c6m2_ord" disabled/>
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
                            <b-form-input v-model="organization.area.m2_in" disabled/>
                        </b-td>
                        <b-td>
                            <b-form-input v-model="organization.area.c6m2_in" disabled/>
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
                <div class="col-6 "><label class="ml-4 font-weight-bold" for="org_area_cnt_mest_zan_inie">Б. Количество мест, занятых иными категориями проживающих</label></div>
                <div class="col-6">
                    <b-input-group append="мест">
                        <b-form-input v-model="organization.area.area_cnt_mest_zan_in_obuch"  id="org_area_cnt_mest_zan_inie" disabled/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6 "><label class="ml-4 font-weight-bold" for="org_area_cnt_svod_mest">В. Количество свободных мест</label></div>
                <div class="col-6 ">
                    <b-input-group append="мест">
                        <b-form-input v-model="organization.area.area_cnt_svob_mest" id="org_area_cnt_svod_mest" disabled/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6 "><label class="ml-4 font-weight-bold" for="org_area_cnt_neisp_mest">Г. Количество неиспользуемых мест</label></div>
                <div class="col-6 ">
                    <b-input-group append="мест">
                        <b-form-input v-model="organization.area.area_cnt_ne_mest"  id="org_area_cnt_neisp_mest" disabled/>
                    </b-input-group>
                </div>
            </div>

            <div class="row">
                <div class="col-6"><label class=" ml-2 font-weight-bold" for="org_area_cnt_neprig_mest">2. Количество непригодных к использованию мест</label></div>
                <div class="col-6">
                    <b-input-group append="мест">
                        <b-form-input v-model="organization.area.area_cnt_mest_ne_prig_k_prozh"   id="org_area_cnt_neprig_mest" disabled/>
                    </b-input-group>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-6"><label class="font-weight-bold" for="org_area_cnt_mest_invalid">Количество мест оборудованных для лиц с ограниченными возможностями здоровья</label></div>
                <div class="col-6">
                    <b-input-group append="мест">
                        <b-form-input v-model="organization.area.area_cnt_mest_invalid"  id="org_area_cnt_mest_invalid" disabled/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><label class="font-weight-bold" for="org_area_cnt_mest_nuzd">Количество обучающихся, нуждающихся в жилье</label></div>
                <div class="col-6">
                    <b-input-group append="человек">
                        <b-form-input id="org_area_cnt_mest_nuzd" v-model="organization.area.area_cnt_nuzhd_zhil" :disabled="blockSave"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><label class="font-weight-bold" for="org_area_cnt_live_in_other">Количество обучающихся, проживающих в жилом фонде других организаций</label></div>
                <div class="col-6">
                    <b-input-group append="человек">
                        <b-form-input id="org_area_cnt_live_in_other" v-model="organization.area.area_cnt_prozh_u_drugih" :disabled="blockSave"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><label class="font-weight-bold" for="org_area_cnt_mest_vost_rab">Количество мест, возможных к вводу в эксплуатацию после проведения восстановительных работ</label></div>
                <div class="col-6">
                    <b-input-group append="мест">
                        <b-form-input v-model="organization.area.area_cnt_mest_vozm_k_vvodu_v_esk"  id="org_area_cnt_mest_vost_rab" disabled/>
                    </b-input-group>
                </div>
            </div>

            <div class="row">
                <div class="col-6"><label class="ml-2 font-weight-bold" for="org_area_cnt_vozmozh_mest_prig">1. Количество мест, возможных к вводу в эксплуатацию из числа неиспользуемых после проведения восстановительных работ</label></div>
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
                        <b-form-input  v-model="organization.area.area_cnt_mest_vozm_mest_is_neisp"  id="org_area_cnt_vozmozh_mest_prig" disabled/>
                    </b-input-group>
                </div>
            </div>

            <div class="row">
                <div class="col-6"><label class="ml-2 font-weight-bold" for="org_area_cnt_vozmozh_mest_ne_prig">2. Количество мест, возможных к вводу в эксплуатацию из числа непригодных к использованию после проведения восстановительных работ</label></div>
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
                        <b-form-input v-model="organization.area.area_cnt_mest_vozm_mest_is_neprig" id="org_area_cnt_vozmozh_mest_ne_prig" disabled/>
                    </b-input-group>
                </div>
            </div>



        </div>


    </div>
    </transition>
</template>

<script>
    import Axios from 'axios';
    import NavBar from "../../organisms/NavBar";
    import {
        BFormInput,
        BInputGroup,
        BInputGroupText,
        BTableSimple,
        BTbody,
        BTd,
        BTh,
        BThead,
        BTooltip,
        BTr
    } from 'bootstrap-vue'

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
                componentReady:false,
                csrf: document.getElementsByName("csrf-token")[0].content,
                blockSave:true,
                id_org:null,
                organization:{},
                user:{}
            }
        },
        methods:{
            async getUser(){
                await Axios.get('/api/user/current').then(res=>
                {this.user = res.data;});
            },
            async getOrg(){
                await Axios.get(`/api/organization/by-id/${this.id_org}`).then(res=> {
                        this.organization = res.data
                        this.organization.area = res.data.area ?? {}
                        console.log(this.organization)
                    }
                );
            },
            async savePage(){
                let data = new FormData();
                data.append('org_area',JSON.stringify(this.organization.area));
                await Axios.post(`/organization/set-org-area/${this.id_org}`,data,{
                    headers: {
                        "X-CSRF-Token": this.csrf
                    }
                }).then(res=>{
                    this.getOrg();
                }).finally(()=>{
                    this.blockSave = true;
                })
            }
        },
        async mounted(){
            await this.getUser();
            this.id_org = this.user.id_org;
            await this.getOrg();
            this.componentReady=true;
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

</style>
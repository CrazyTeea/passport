<template>
    <div>
        <nav-bar />
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <h3>
                        Сведения о жилом объекте
                    </h3>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-6"><label >Наименование жилого объекта</label></div>
                <div class="col-6">
                    <b-form-select :options="objectsTitle"/>
                </div>
            </div>

            <b-button @click="modalShow = !modalShow">Добавить объект</b-button>

            <b-modal hide-header v-model="modalShow">

                <b-form-group
                        id="fieldset-obj_name"
                        label="Наименование добавляемого жилого объекта"
                        label-for="obj_name"
                >
                    <b-form-input v-model="objName" id="obj_name" />
                </b-form-group>

                <template v-slot:modal-footer>
                    <b-button @click="addObject" variant="outline-success">Сохранить</b-button>
                </template>
            </b-modal>


        </div>
    </div>
</template>

<script>
    import NavBar from "../../organisms/NavBar";
    import {BFormInput,BFormSelect,BFormGroup,
        BButton,BModal,VBModal,} from 'bootstrap-vue'
    export default {
        components:{
            NavBar,
            BFormInput,
            BFormSelect,
            BButton,BModal,
            BFormGroup,
        },
        data(){
            return {
                objName:'',
                modalShow:false,
                objectsTitle:[
                    {
                        value:0,
                        text:'object 0'
                    }
                ],
                objects:[
                    {
                        id:1,
                        name:'object 0',
                        address:'',
                        id_region:1,
                        kad_number:'',
                        osnov_isp:0,
                        reg_zap:'',
                        doc_number:'',
                        plan_zhil_pom:0,
                        razm_type:0,
                        nal_uch_isp_res:0,
                        date_start_stroy:'2019-03-01',
                        date_zdan:'2019-03-01',
                        date_exploat:'2019-03-01'
                    }
                ]
            }
        },
        watch:{
          objects(){
              this.objects.forEach(item=>{
                  this.objectsTitle.push({
                      value:item.id,
                      text:item.name
                  })
              })
          }
        },
        methods:{
            addObject(){
                this.objects.push({
                    id:12,
                    name:this.objName
                });
                this.objName = null;
                this.modalShow = false;
            }
        }
    }
</script>

<style scoped>

</style>
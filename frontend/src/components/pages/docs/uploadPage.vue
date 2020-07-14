<template>
    <div>
        <nav-bar v-on:save-page="savePage" v-on:block-save="blockPage = !blockPage"/>
        <div class="container">


            <b-card v-for="(docType,index) in docTypes" :key="index"
                    border-variant="primary"
                    class="mt-2 shadow rounded"
            >
                <b-card-text>
                    Загрузить документ
                </b-card-text>

                <b-form-group
                        id="fileset-1"
                        :label=docType.descriptor.label
                        label-for="file-1"

                >
                    <b-input-group>
                        <template v-slot:append>
                            <b-button @click="docType.server_file = null" v-if="docType.server_file"  size="sm"  variant="danger"><i class="fas fa-backspace"></i></b-button>
                        </template>
                        <b-form-file browse-text="Прикрепить" placeholder="Файл не выбран" :id="`file-${index}`" v-model="docType.server_file"></b-form-file>
                    </b-input-group>

                </b-form-group>



            </b-card>
            <div v-if="fileName" class="row mt-2">
                <div class="col-4">{{fileName}}</div>
                <div class="col-8"><b-progress :value="progress" max="100" variant="info" show-progress animated></b-progress></div>
            </div>

        </div>
    </div>
</template>

<script>
    import NavBar from "../../organisms/NavBar";
    import Axios from 'axios'
    import {BButton, BCard, BCardText, BFormFile, BProgress,
        BFormGroup, BInputGroup, BInputGroupText} from 'bootstrap-vue'

    export default {
        name: "uploadPage",
        components: {
            NavBar,BCard,BProgress,
            BCardText,BButton,
            BFormFile,BFormGroup,
            BInputGroup,BInputGroupText
        },
        async mounted() {
            await this.getUser();
            await this.getDocTypes()
        },
        watch:{
            docTypes: {
              handler(){
                  //console.log(this.docTypes)
              },
              deep:true
          }
        },
        methods:{
            async getUser(){
                await Axios.get('/api/user/current').then(res=>
                {this.user = res.data;this.id_org = this.user.id_org});
            },
            async getDocTypes(){
                await Axios.get(`/api/get-doc-types/${this.id_org}`).then(res=>{
                    this.docTypes = res.data
                })
            },
            upload(index){


            },
           async savePage(){

               const arr = this.docTypes.map(async (item) => {
                // for(const item of this.docTypes) {
                    if (item.server_file) {
                        let data = new FormData();
                        data.append('desc', item.descriptor.desc)
                        data.append(item.descriptor.desc, item.server_file);
                        this.fileName = item.server_file.name
                        await Axios.post('/test/upload', data, {
                            onUploadProgress: e => {
                                this.progress = Math.round((e.loaded * 100) / e.total);
                            },
                            headers: {
                                "X-CSRF-Token": this.csrf
                            }
                        }).then(res => {
                            this.progress = 0;
                            this.fileName = null
                        })
                    }
                })
                await Promise.all(arr);

            }
        },
        data(){
            return {
                csrf: document.getElementsByName("csrf-token")[0].content,
                blockPage:true,
                progress:0,
                fileName:null,

                docTypes:[],
                files:[],

                user:{},
                id_org:{},
                file:null,
                file2:null
            }
        }
    }
</script>

<style scoped>
    .shadow{
        box-shadow: 0 0 10px; /* Параметры тени */
    }
</style>
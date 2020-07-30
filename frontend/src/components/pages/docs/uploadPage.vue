<template>
  <div>
    <nav-bar :save-button="false" />
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
            <b-form-file @input="saveFile(docType)" v-if="!docType.server_file && !docType.file" browse-text="Прикрепить" placeholder="Файл не выбран" :id="`file-${index}`" v-model="docType.server_file"></b-form-file>
          </b-input-group>
          <div v-if="docType.fileName" class="row mt-2">
            <div class="col-4">{{docType.fileName}}</div>
            <div class="col-8"><b-progress :value="docType.progress" max="100" variant="info" show-progress animated></b-progress></div>
          </div>
          <transition  name="custom-classes-transition"
                       enter-active-class="animated zoomIn"
                       leave-active-class="animated zoomOutDown">

            <div class="d-block" v-if="docType.server_file || docType.file">
              <div class="row">
                <div class="col">
                  <span v-if="docType.server_file" class="float-right font-weight-bold text-center">
                    {{docType.server_file.name}}
                  </span>
                  <span v-if="docType.file" class="float-right font-weight-bold text-center">
                    {{docType.file.name}}
                  </span>
                </div>
                <div class="col">
                  <b-button @click="deleteFile(docType)"  size="sm"  variant="danger"><i class="fas fa-trash-alt"></i></b-button>
                </div>

              </div>

            </div>


          </transition>

        </b-form-group>



      </b-card>


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
    this.id_org = this.user.id_org
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
  methods: {
    async getUser() {
      await Axios.get('/api/user/current').then(res => {
        this.user = res.data;
        this.id_org = this.user.id_org
      });
    },
    async getDocTypes() {
      await Axios.get(`/api/get-doc-types/${this.id_org}`).then(res => {
        this.docTypes = res.data
        this.docTypes = this.docTypes.map(item=>{
          return {...item,...{progress:0,fileName:null}}
        })
      })
    },
    async deleteFile(item) {
      if (item.file) {
        let data = new FormData();
        data.append('desc', item.descriptor.desc)
        await Axios.post(`/organization/del-file/${this.id_org}`, data, {
          headers: {
            "X-CSRF-Token": this.csrf
          }
        }).then(res => {
          item.file = null;
          item.progress = 0;
          item.fileName = null
        })
      }

      item.server_file = null;
    },
    async saveFile(item) {
      if (item.server_file) {
        let data = new FormData();
        data.append('desc', item.descriptor.desc)
        data.append(item.descriptor.desc, item.server_file);
        item.fileName = item.server_file.name
        await Axios.post(`/organization/set-org-files/${this.id_org}`, data, {
          onUploadProgress: e => {
            item.progress = Math.round((e.loaded * 100) / e.total);
          },
          headers: {
            "X-CSRF-Token": this.csrf
          }
        }).then(res=>{
          let i = this.docTypes.findIndex(item2=>item2.descriptor.desc === item.descriptor.desc)
          if (i!==-1){
            this.docTypes[i].file = item.server_file;
            item.server_file = null
          }
        })
      }
    },
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
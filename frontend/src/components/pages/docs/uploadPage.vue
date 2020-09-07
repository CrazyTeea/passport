<template>
  <div>
    <nav-bar :id_org="id_org" :save-button="false" />
    <div class="container">


      <b-modal no-close-on-esc
               no-close-on-backdrop
               centered
               ref="error-modal" hide-footer
      >
        <template v-slot:modal-header>
          <div class="text-center  d-block w-100">
            <span class="font-weight-bold">Ошибка!</span>
          </div>
        </template>
        <div class="justify-content-center d-block text-center text-danger">
          <h3>Размер файла должен быть меньше 20 мб!</h3>
        </div>
        <b-button class="mt-3" variant="outline-danger" block @click="hideModal">Я понял(а)</b-button>
      </b-modal>

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
            <b-form-file :ref="'fileInput' + index" @input="saveFile(docType,index)" v-if="!docType.server_file && !docType.file" browse-text="Прикрепить" placeholder="Файл не выбран" :id="`file-${index}`" v-model="docType.server_file"></b-form-file>
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
                <div class="col d-flex align-items-center justify-content-center">
                  <span v-if="docType.server_file" class="font-weight-bold text-center">
                    {{docType.server_file.name}}
                  </span>
                  <span v-if="docType.file" class="font-weight-bold text-center">
                    {{docType.file.name}}
                  </span>
                  <i v-if="docType.delButton"  @click="deleteFile(docType)" class="ml-2 fas fa-trash-alt trash-icon"></i>
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
import {BButton, BCard, BCardText,
  BFormFile, BProgress,BModal,
  BFormGroup, BInputGroup, BInputGroupText} from 'bootstrap-vue'

export default {
  name: "uploadPage",
  components: {
    NavBar,BCard,BProgress,
    BCardText,BButton,BModal,
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
    showModal() {
      this.$refs['error-modal'].show()
    },
    hideModal() {
      this.$refs['error-modal'].hide()
    },
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
          return {...item,...{progress:0,fileName:null,delButton:true}}
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
          console.log(res.data)
          item.file = null;
          item.progress = 0;
          item.fileName = null
        })
      }

      item.server_file = null;
    },
    async saveFile(item,index) {
      if (item.server_file) {

        let size = (item.server_file.size / 1024) / 1024;

        if (size > 20){
          item.server_file = null;
          this.showModal()
          let n = ('fileInput'+index);
          if (this.$refs[n].length)
            this.$refs[n][0].reset();
          else this.$refs[n].reset();
        }
        if (item.server_file){
          let data = new FormData();
          data.append('desc', item.descriptor.desc);
          data.append(item.descriptor.desc, item.server_file);
          item.fileName = item.server_file.name;
          item.delButton = false;
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
              setTimeout(()=>{
                item.fileName = null
                item.delButton = true
              },2000)

            }
          })
        }

      }
    },
  },
  data(){
    return {
      csrf: document.getElementsByName("csrf-token")[0].content,
      blockPage:true,
      docTypes:[],
      user:{},
      id_org:{},
    }
  }
}
</script>

<style scoped>
.shadow{
  box-shadow: 0 0 10px; /* Параметры тени */
}
.trash-icon {
  color: red;
  transform: scale(1);
  transition: all .3s ease;
}
.trash-icon:hover {
  transform: scale(1.3);
  transition: all .3s ease;
}
</style>
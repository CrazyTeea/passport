<template>
    <div>
        <nav-bar v-on:block-save="blockPage = !blockPage"/>
        <div class="container">
            <b-card
                    border-variant="primary"
                    class="mt-2 shadow rounded"
            >
                <b-card-text>
                    Загрузить документы
                </b-card-text>

                <b-form-group
                        id="fileset-1"
                        label="Подписанный отчёт"
                        label-for="file-1"

                >
                    <b-input-group>
                        <template v-slot:append>
                            <b-button @click="file = null" v-if="file" size="sm"  variant="danger"><i class="fas fa-backspace"></i></b-button>
                        </template>
                        <b-form-file browse-text="Прикрепить" placeholder="Файл не выбран" id="file-1" v-model="file"></b-form-file>
                    </b-input-group>

                </b-form-group>


            </b-card>
            <b-card
                    border-variant="primary"
                    class="mt-2 shadow rounded"
            >
                <b-card-text>
                    Загрузить документы
                </b-card-text>

                <b-form-group
                        id="fileset-2"
                        label="Пояснительная записка"
                        label-for="file-2"

                >
                    <b-input-group>
                        <template v-slot:append>
                            <b-button @click="file2 = null" v-if="file2" size="sm"  variant="danger"><i class="fas fa-backspace"></i></b-button>
                        </template>
                        <b-form-file browse-text="Прикрепить" placeholder="Файл не выбран" id="file-2" v-model="file2"></b-form-file>
                    </b-input-group>

                </b-form-group>


            </b-card>
        </div>
    </div>
</template>

<script>
    import NavBar from "../../organisms/NavBar";
    import {BCard,BCardText,BFormGroup,BInputGroup,BInputGroupText,
        BButton,BFormFile} from 'bootstrap-vue'
    export default {
        name: "uploadPage",
        components: {
            NavBar,BCard,
            BCardText,BButton,
            BFormFile,BFormGroup,
            BInputGroup,BInputGroupText
        },
        data(){
            return {
                blockPage:true,
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
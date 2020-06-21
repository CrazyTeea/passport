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

        </div>
    </div>
</template>

<script>
    import NavBar from "../../organisms/NavBar";
    import {BFormInput,BInputGroup} from 'bootstrap-vue'
    export default {
        name: "livingInfo",
        components:{
            NavBar,
            BFormInput,
            BInputGroup
        },
        data(){
            return {
                blockPage:true
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

</style>
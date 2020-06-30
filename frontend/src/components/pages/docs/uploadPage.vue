<template>
    <div>
        <nav-bar v-on:block-save="blockPage = !blockPage"/>
        <div class="container">
            <b-card
                    border-variant="primary"
                    class="mt-2 shadow rounded"
            >
                <b-card-text>
                    Some quick example text to build on the card title and make up the bulk of the card's content.
                </b-card-text>

                <b-button href="#" variant="primary">Go somewhere</b-button>
            </b-card>
        </div>
    </div>
</template>

<script>
    import NavBar from "../../organisms/NavBar";
    import {BCard,BCardText,BButton} from 'bootstrap-vue'
    export default {
        name: "uploadPage",
        components: {NavBar,BCard,BCardText,BButton},
        data(){
            return {
                blockPage:true,
            }
        }
    }
</script>

<style scoped>
    .shadow{
        box-shadow: 0 0 10px; /* Параметры тени */
    }
</style>
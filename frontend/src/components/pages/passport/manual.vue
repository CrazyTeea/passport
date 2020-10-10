<template>
    <div id="manual_page">
      <div class="container">
        <div class="row  mt-2">
          <div class="col-10">
            <h4>Инструкция</h4>
          </div>
          <div class="col-2">
            <b-button block>Назад</b-button>
            <b-button block>Скачать инструкцию</b-button>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import { BButton } from 'bootstrap-vue';

export default {
  name: 'manual',
  components: {
    BButton,
  },
};
</script>

<style scoped>

</style>

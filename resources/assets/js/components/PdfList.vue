<template>
  <div id="app">
    <div class="container">
      <uploader @uploadComplete="getData()"></uploader>
      <div v-if="list && list.length" class="row pdflist">
        <div v-for="item in list" class="pdflist__item col-xs-3 col-md-3 col-lg-3" v-on:click="showPdf(item.path_pdf)">
          <div class="col-xs-12 col-md-12 col-lg-12 pdflist__item__title">{{item.filename}}</div>

          <div class="col-xs-12 col-md-12 col-lg-12 pdflist__item__image">
            <img v-bind:src="item.path" style="width: 100%;">
          </div>
        </div>
      </div>
      <pdfview :url="selectedPdfSrc"></pdfview>
    </div>
  </div>
</template>


<script>
  export default {
    data (){
      return {
        list : [],
        selectedPdfSrc: null
      }
    },
    methods : {
      showPdf(path) {
        this.selectedPdfSrc = path
      },
      getData() {
        self = this
        axios.get('/api/v1/documents').then(response => {
          self.list = response.data
        })
      },
    },
    mounted() {
      this.getData()
    }
  }

</script>
<!-- SASS styling -->
<style lang="scss">
  .pdflist {
    border: 1px solid gray;
  }
  .pdflist__item {
    cursor: pointer;
    max-height: 50%;
    overflow: hidden;
  }
  .pdflist__item:hover {
    background: lightgray;
  }

  .pdflist__item__title {
    padding: 1rem 0;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .pdflist__item__image {
    padding: 1rem 0;
  }
</style>
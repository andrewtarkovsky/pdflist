<template>
  <div id="app">
    <div class="container">
      <uploader @uploadComplete="getData()"></uploader>
      <div v-if="list && list.length" class="row">
        <div v-for="item in list" class="col-xs-3 col-md-3 col-lg-3">
          <div class="col-xs-12 col-md-12 col-lg-12">
            <a v-bind:href="item.path_pdf" target="new"><img v-bind:src="item.path" width="100"></a>
          </div>
          <div class="col-xs-12 col-md-12 col-lg-12">{{item.filename}}</div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
  export default {
    data (){
      return {
        list : []
      }
    },
    methods : {
      getData() {
        self = this
        axios.get('/get-list').then(response => {
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
</style>
<template>
  <div class="component-container">
    <div class="container">
      <div v-if="url && url.length">
        <transition name="modal">
          <div class="modal-mask">
            <div class="modal-wrapper">
              <div class="modal-container">

                <div class="modal-header" v-on:click="url = ''">
                  Close Preview
                </div>

                <div class="modal-body">
                  <a v-bind:href="url" target="new">
                    Download: {{url}}
                  </a>
                  <pdf
                          :src="url"
                          v-if="url && url.length"
                  ></pdf>
                </div>

              </div>
            </div>
          </div>
        </transition>
      </div>
    </div>

  </div>
</template>

<script>

  import pdf from 'vue-pdf'

  export default {
    components: {
      pdf
    },
    methods: {
      show: function () {
        this.showModal = true
      },
    },
    data() {
      return {
        currentPage: 0,
        pageCount: 0,
        showModal: false
      }
    },
    props: ['url']
  }

</script>

<style lang="scss">
  .modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    display: table;
    transition: opacity .3s ease;
  }

  .modal-wrapper {
    display: table-cell;
    vertical-align: middle;
  }

  .modal-container {
    width: 50%;
    height: 50%;
    margin: 0px auto;
    padding: 20px 30px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
    transition: all .3s ease;
    font-family: Helvetica, Arial, sans-serif;
  }

  .modal-header {
    font-weight: 600;
    cursor: pointer;
  }

  .modal-header h3 {
    margin-top: 0;
    color: #42b983;
  }

  .modal-body {
    margin: 20px 0;
    overflow-y: scroll;
    max-height: 80%;
  }

  .modal-default-button {
    float: right;
  }

  .modal-enter {
    opacity: 0;
  }

  .modal-leave-active {
    opacity: 0;
  }

  .modal-enter .modal-container,
  .modal-leave-active .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
  }
</style>
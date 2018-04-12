<template>
  <div id="app">
    <div class="container">
      <form enctype="multipart/form-data" novalidate>
        <div class="dropbox">
          <input type="file" name="pdffile" @change="onFileChange" class="input-file">
          <p>
            Add new document
          </p>
        </div>
      </form>
    </div>
  </div>
</template>


<script>
  export default {
    data (){
      return {
        attachment : { name : null,file: null },
        isSaving: false
      }
    },
    methods : {
      onFileChange(event) {
        this.attachment.file = event.target.files[0]
        this.attachmentCreate()
      },
      attachmentCreate() {
        var form = new FormData();

        form.append('name',this.attachment.name);
        form.append('file',this.attachment.file);
        self = this
        self.isSaving = true
        axios.post('/api/v1/documents/upload',form).then(response => {
          self.$emit('uploadComplete', 'done')
          self.isSaving = false
        },error=> {
          self.isSaving = false
          alert(error.message)
        })
      }
    },
    mounted() {
    }

  }

</script>
<!-- SASS styling -->
<style lang="scss">
  .input-file {
    opacity: 0;
    width: 100%;
    height: 100px;
    position: absolute;
    cursor: pointer;
    margin: 1rem 0 1rem 0;
  }

  .dropbox {
    padding: 10px 10px;
    height: 70px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    border: 1px solid lightgray;
    border-radius: 0.8rem;
    background: #17a2b8;
    margin-top: 2rem;
  }

  .dropbox:hover {
    background: #007bff;
  }

  .dropbox p {
    font-size: 1.2rem;
    text-align: center;
    padding: 0.5rem 0 0 0;
  }
</style>
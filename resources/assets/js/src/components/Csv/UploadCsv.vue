<template>
    <form @submit.prevent="doUpload">
        <div class="form-group">
            <b-form-file accept=".csv, .xls" :required="true" ref="files" v-model="file" name="csv"
                         placeholder=".csv, .xls"></b-form-file>
        </div>
        <button class="btn btn-primary" type="submit" v-text="loading ? 'Please Wait...' : 'Upload'"></button>
        <b-modal ref="message" title="Invalid Document" :ok-only="true">
            <b-alert show variant="danger">
                <h4 class="alert-heading">Missing Document Headers</h4>
                <b-list-group>
                    <b-list-group-item v-for="(header,index) in invalid_headers[0]" :key="index">{{ header}}
                    </b-list-group-item>
                </b-list-group>
            </b-alert>
        </b-modal>
    </form>
</template>
<script>

  import {uploadCsv} from "../../actions/UploadCsvAction";

  export default {
    props: ['url'],
    data() {
      return {
        loading: false,
        file: null,
        invalid_headers: [],
        valid_headers: [],
      }
    },
    methods: {
      doUpload(e) {
        let self = this;
        self.loading = true;
        uploadCsv(self.csv, self.url).then(res => {
          self.loading = false;
          self.$toaster.success('Csv uploaded successfully!');
          this.$refs.files.reset();
          self.$emit('input', true);
        }).catch(error => {
          if (error.response.status === 422) {
            if (error.response.data.errors.invalid_headers) {
              self.invalid_headers = error.response.data.errors.invalid_headers;
              self.valid_headers = error.response.data.errors.valid_headers;
              this.$refs.message.show();
            } else {
              self.$toaster.error(error.response.data.message);
            }
          } else {
            self.$toaster.error('Oops! Something went wrong.');
          }
          self.loading = false;
          self.$emit('input', true);
        });
      },
    },
    computed: {
      csv() {
        let self = this;
        let formData = new FormData();
        formData.append('importedFile', self.file);
        return formData;
      }
    }
  }
</script>
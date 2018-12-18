<template>
    <b-form-group :label="label">
        <v-select :options="projects" :multiple="multiple" v-model="selectedProjects"></v-select>
    </b-form-group>
</template>
<script>
  import {getProjects} from "../actions/ProjectAction";
  import vSelect from 'vue-select';

  export default {
    data() {
      return {
        projects: [],
        selectedProjects: this.value
      }
    },
    props: ['value', 'label', 'multiple'],
    methods: {
      fetchProjects() {
        getProjects().then(response => {
          this.projects = _.map(response.data.data, function(obj) {
            return {
              value: obj.id,
              label: obj.project_code,
            }
          });
        })
      },
      handleChange() {
        this.$emit('input', this.selectedProjects)
      }
    },
    mounted() {
      this.fetchProjects();
    },
    watch: {
      selectedProjects: function(value) {
        this.$emit('input', this.selectedProjects)
      },
      value: function(value) {
        this.selectedProjects = value
      }
    },
    components: {
      vSelect
    }
  }
</script>
<template>
    <select v-model="selectedTechnology" class="form-control" @change="handleChange">
        <option :value="0">All Technologies</option>
        <option v-for="technology in technologies" :value="technology.id" v-text="technology.name"></option>
    </select>
</template>
<script>
  import {getTechnologies} from "../actions/TechnologyAction";

  export default {
    data() {
      return {
        technologies: [],
        selectedTechnology: this.value
      }
    },
    props: ['value'],
    methods: {
      fetchTechnologies() {
        let self = this;
        getTechnologies().then(response => {
          self.technologies = response.data;
        })
      },
      handleChange() {
        this.$emit('input', this.selectedTechnology)
      }
    },
    mounted() {
      this.fetchTechnologies();
    }
  }
</script>
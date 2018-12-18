<template>
    <b-form-group
            :label="label"
            label-for="employee">
        <v-select placeholder="Select Employee" :options="employees" v-model="selected"
                  label="label">
            <template slot="option" slot-scope="option">
                <span>{{ option.label }} </span>
                <br/>
                <span style="opacity: 0.5">{{ option.technology}}</span>
            </template>
        </v-select>
    </b-form-group>
</template>

<script>
  import {fetchEmployee} from "../actions/UsersActions";
  import vSelect from 'vue-select';

  export default {
    data() {
      return {
        employees: [],
        selected: this.value
      }
    },
    props: ['value', 'label'],
    mounted() {
      this.fetchEmployees();
    },
    components: {
      vSelect
    },
    methods: {
      fetchEmployees() {
        fetchEmployee().then(res => {
          this.employees = _.map(res.data.data, function(obj) {
            return {
              value: obj.id,
              label: obj.name,
              technology: obj.technology ? obj.technology.name : 'N/A'
            }
          });
        });
      },
      handleChange(value) {
        console.log(value)
      }
    },
    watch: {
      selected: function(value) {
        this.$emit('input', value)
      },
      value: function(value) {
        this.selected = value;
      }
    }
  }
</script>
<style>
    .dropdown-menu :hover {
        color: white;
    }

    .v-select .dropdown-toggle .clear {
        visibility: hidden;
    }
</style>
<template>
    <b-card header="<i class='fa fa-align-justify'></i> Assign to Supervisor">
        <validation-errors :validationErrors="validationErrors"/>
        <b-form @submit="onSubmit" @reset="onReset">
            <employee-select v-model="selectedSupervisor" label="Select Supervisor"/>

            <b-form-group label="Select Technology">
                <technology-select v-model="selectedTechnology"></technology-select>
            </b-form-group>
            <b-form-group label="Select Employees">
                <b-form-checkbox-group plain stacked v-model="selectedEmployees" :options="employees"/>
            </b-form-group>

            <b-button :disabled="loading" type="submit" variant="primary"><i class="fa fa-save"></i> {{
                loading
                ? 'Please Wait..' : 'Submit' }}
            </b-button>
            <b-button type="reset" variant="danger"><i class="fa fa-refresh"></i> Reset</b-button>
            <b-button type="reset" v-b-toggle.sessionForm variant="warning"><i class="fa fa-close"></i>
                Close
            </b-button>
        </b-form>
    </b-card>
</template>
<script>
  import EmployeeSelect from '../../components/EmployeeSelect';
  import ValidationErrors from "../../components/ValidationErrors";
  import TechnologySelect from "../../components/TechnologySelect";
  import {fetchEmployeeByTechnology} from "../../actions/UsersActions";
  import {saveSupervisorAppraise} from "../../actions/AppraiseActions";

  export default {
    data() {
      return {
        loading: false,
        selectedSupervisor: null,
        selectedTechnology: [],
        selectedEmployees: [],
        employees: [],
        validationErrors: null
      }
    },
    components: {
      EmployeeSelect,
      ValidationErrors,
      TechnologySelect
    },
    methods: {
      fetchEmployees(technologyId) {
        fetchEmployeeByTechnology(technologyId).then(response => {
          this.employees = response.data.data.map((employee) => {
            return {
              value: employee.id,
              text: employee.name,
            }
          });
        })
      },
      onSubmit(evt) {
        evt.preventDefault();
        saveSupervisorAppraise(this.selectedSupervisor, this.selectedEmployees).then(response => {
          this.$toaster.success("Successfully Saved");
          this.onReset();
          this.$emit('saved');
        }).catch(error => {
          this.$toaster.error("Please try again later.");
        })
      },
      onReset() {
        this.selectedSupervisor = null;
        this.selectedTechnology = null;
        this.validationErrors = null;
      }
    },
    watch: {
      selectedTechnology: function(value) {
        this.fetchEmployees(value);
      }
    }
  }
</script>
<template>
    <div class="animated fadeIn">
        <b-collapse v-model="visibleForm" id="questionForm">
            <b-card header="<i class='fa fa-align-justify'></i> Project Employee Link">
                <b-row>
                    <b-col md="4">
                        <b-form @submit="handleSubmit" @reset="onReset">
                            <employee-select label="Select Employee" v-model="selectedEmployee"></employee-select>
                            <project-select label="Select Project" v-model="selectedProjects" multiple></project-select>
                            <b-button type="submit" variant="primary"><i class="fa fa-save"></i> Submit</b-button>
                            <b-button type="reset" variant="danger"><i class="fa fa-refresh"></i> Reset</b-button>
                            <b-button type="reset" v-b-toggle.questionForm variant="warning"><i class="fa fa-close"></i>
                                Close
                            </b-button>
                        </b-form>
                    </b-col>
                </b-row>
            </b-card>
        </b-collapse>
        <b-card>
            <h6 slot="header" class="mb-0">
                <i class='fa fa-book'></i> Employee Project
                <b-button type="button" v-b-toggle.questionForm variant="primary" class="pull-right"><i
                        class="fa fa-plus"></i>
                    Add New
                </b-button>
            </h6>
            <b-col md="6">
                <b-form-group label="Select Technology">
                    <technology-select v-model="selectedTechnology"></technology-select>
                </b-form-group>
            </b-col>
            <br/>
            <b-col md="12">
                <table class="table table-striped">
                    <tr>
                        <th>SN.</th>
                        <th>Employee Name</th>
                        <th>Projects</th>
                    </tr>
                    <tr v-for="(employee, index) in employeeProjects">
                        <td v-text="index+1"></td>
                        <td v-text="employee.name"></td>
                        <td>
                            <table class="table table-striped">
                                <tr>
                                    <th>Project Name</th>
                                    <th width="10%">Action</th>
                                </tr>
                                <tr v-for="project in employee.projects">
                                    <td>
                                        {{project.project_code}}
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" @click="handleDelete(project.pivot.id)"><i
                                                class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </b-col>
        </b-card>
    </div>
</template>
<script>
  import TechnologySelect from '../../components/TechnologySelect';
  import EmployeeSelect from '../../components/EmployeeSelect';
  import ProjectSelect from '../../components/ProjectsSelect';
  import vSelect from 'vue-select';
  import {getUserProjects, linkProjectEmployee, unLinkProject} from "../../actions/ProjectAction";

  export default {
    data() {
      return {
        visibleForm: false,
        technologies: null,
        selectedEmployee: null,
        selectedTechnology: 0,
        selectedProjects: null,
        employeeProjects: []
      }
    },
    methods: {
      handleSubmit(e) {
        e.preventDefault();
        linkProjectEmployee(this.selectedEmployee.value, this.selectedProjects).then(response => {
          this.$toaster.success("Successfully Saved");
          this.selectedEmployee = null;
          this.selectedProjects = null;
          this.getData(this.selectedTechnology);
        }).catch(error => {
          this.$toaster.success("Please Try Again!");
        });
      },
      onReset(e) {
        e.preventDefault();
        this.selectedEmployee = null;
        this.selectedProjects = null;
      },
      getData(technologyId) {
        getUserProjects(technologyId).then(response => {
          this.employeeProjects = response.data.data;
        })
      },
      handleDelete(id) {
        this.$confirm().then(res => {
          if (res) {
            unLinkProject(id).then(response => {
              this.getData(0);
            })
          }
        })
      }
    },
    components: {
      TechnologySelect,
      EmployeeSelect,
      vSelect,
      ProjectSelect
    },
    mounted() {
      this.getData(0);
    },
    watch: {
      selectedTechnology: function(value) {
        this.getData(value);
      }
    }
  }
</script>

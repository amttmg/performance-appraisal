<template>
    <div>
        <b-collapse v-model="visibleForm" id="sessionForm">
            <b-row>
                <b-col md="4">
                    <b-card header="<i class='fa fa-align-justify'></i> Add New Appraise">
                        <validation-errors :validationErrors="validationErrors"/>
                        <b-form @submit="onSubmit" @reset="onReset">
                            <b-form-group hidden
                                          label="Project Code :"
                                          label-for="code">
                                <b-form-input v-model="form.session_id" readonly type="text"
                                              placeholder="Enter new session"
                                              required></b-form-input>
                            </b-form-group>
                            <employee-select v-model="form.employee" label="Select Employee"/>
                            <employee-select v-model="form.peer" label="Select Peer"/>
                            <b-form-group>
                                <b-form-checkbox id="self"
                                                 v-model="form.self"
                                                 disabled
                                                 value="1"
                                                 unchecked-value="not-self">
                                    Self Appraisal
                                </b-form-checkbox>
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
                </b-col>
                <b-col md="8">
                    <AssignSupervisor @saved="fetchAppraise"></AssignSupervisor>
                </b-col>
            </b-row>
        </b-collapse>
        <b-card header-tag="header">
            <h6 slot="header" class="mb-0">
                <i class='fa fa-clock-o'></i> Session Details
                <b-button type="button" v-b-toggle.sessionForm variant="primary" class="pull-right"><i
                        class="fa fa-plus"></i>
                    Add New Appraise
                </b-button>
            </h6>
            <b-row>
                <b-col md="4">
                    <b-form-group label="Filter By Technology">
                        <technology-select v-model="selectedTechnology"></technology-select>
                    </b-form-group>
                </b-col>
            </b-row>
            <br/>
            <b-row>
                <b-col md="12">
                    <table class="table table-striped table-sm">
                        <tr>
                            <th>SN.</th>
                            <th>Employee name</th>
                            <th>Assign To</th>
                        </tr>
                        <tr v-for="(employee, index) in employees" :key="index">
                            <td v-text="index+1"></td>
                            <td v-text="employee.employee ? employee.employee.name : ''"></td>
                            <td>
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <th width="30%">Appraise By</th>
                                        <th>Type</th>
                                        <th>Is Completed</th>
                                        <th>Action</th>
                                    </tr>
                                    <tr v-for="appraiseBy in employee.appraiseBy">
                                        <td>{{ appraiseBy.appraise_by ? appraiseBy.appraise_by.name : '' }}</td>
                                        <td>
                                            {{ appraiseBy.type.title }}
                                        </td>
                                        <td>
                                            <i class="fa fa-check-circle" style="color: #007ee5"
                                               v-if="appraiseBy.is_completed"></i>
                                            <p v-if="!appraiseBy.is_completed">No</p>
                                        </td>
                                        <td>
                                            <button title="Delete" class="btn btn-danger btn-sm"
                                                    v-show="!appraiseBy.is_completed"
                                                    @click="deleteAppraise(appraiseBy.id)"><i class="fa fa-trash"></i>
                                            </button>
                                            <button title="Reset Submission" class="btn btn-primary btn-sm"
                                                    v-show="appraiseBy.is_completed"
                                                    @click="resetAppraise(appraiseBy.id)"><i class="fa fa-refresh"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </b-col>
            </b-row>
        </b-card>
    </div>
</template>
<script>
  import {getAllAppraise, saveAppraise, deleteAppraise, resetAppraise} from "../../actions/AppraiseActions";
  import ValidationErrors from "../../components/ValidationErrors";
  import TechnologySelect from "../../components/TechnologySelect";
  import EmployeeSelect from '../../components/EmployeeSelect';
  import AssignSupervisor from './AssignSupervisor';

  export default {
    data() {
      return {
        filter: '',
        form: {
          session_id: this.$router.currentRoute.params.id,
          employee: null,
          peer: null,
          self: 1,
          selectedSupervisor: null
        },
        loading: false,
        validationErrors: null,
        visibleForm: false,
        show: false,
        users: [],
        employees: [],
        selectedTechnology: 0
      }
    },
    components: {
      ValidationErrors,
      TechnologySelect,
      EmployeeSelect,
      AssignSupervisor
    },
    mounted() {
      this.fetchAppraise(0);
    },
    methods: {
      fetchAppraise(technologyId) {
        let sessionId = this.$router.currentRoute.params.id ? this.$router.currentRoute.params.id : null;
        getAllAppraise(sessionId, technologyId).then(res => {
          this.employees = res.data.data;
        })
      },
      resetAppraise(id) {
        this.$confirm().then(result => {
          if (result) {
            resetAppraise(id).then(res => {
              this.$toaster.success("Successfully Reset.");
              this.fetchAppraise();
            })
          }
        })
      },
      onSubmit(evt) {
        evt.preventDefault();
        this.loading = true;
        saveAppraise(this.form).then(response => {
          this.$toaster.success("Success");
          this.form.selectedSupervisor = null;
          this.form.peer = null;
          this.form.employee = null;
          this.fetchAppraise();
          this.loading = false;
          this.validationErrors = null;
        }).catch(error => {
          if (error.response.status === 422) {
            this.validationErrors = error.response.data;
            this.loading = false;
          } else {
            this.$toaster.error("Please Try Again");
            this.loading = false;
          }
        });
      },
      onReset(evt) {
        evt.preventDefault();
        this.reset();
        this.$nextTick(() => {
          this.show = true
        });
      },
      reset() {
        this.form.employee = null;
        this.form.peer = null;
        this.form.selectedSupervisor = null;
      },
      deleteAppraise(id) {
        let options = {
          text: "You can not revert this action.",
          icon: null,
        };
        this.$confirm(options).then((result) => {
          if (result) {
            deleteAppraise(id).then(response => {
              this.$toaster.success("Successfully Deleted.");
              this.fetchAppraise();
            })
          }
        })
      }
    },
    watch: {
      selectedProjects: function(value) {
        this.fetchAppraise(value);
      }
    }
  }
</script>

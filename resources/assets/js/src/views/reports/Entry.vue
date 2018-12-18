<template>
    <div class="animated fadeIn">
        <b-card header-tag="header">
            <h6 slot="header" class="mb-0">
                <i class='fa fa-align-justify'></i> Final Report Entry
            </h6>
            {{ file }}
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Report</th>
                    <th>Action</th>
                    <th>Upload</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(employee, index) in employees">
                    <td> {{ ++index }}</td>
                    <td> {{ employee.name }}</td>
                    <td> {{ employee.username }}</td>
                    <td> {{ employee.email }}</td>
                    <td>
                        <a v-if="employee.active_report" target="_blank"
                           :href="'/uploads/'+employee.active_report.report">
                            <i class="fa fa-file-pdf-o fa-2x"></i>
                        </a>
                    </td>
                    <td>
                        <button v-if="employee.active_report" class="btn btn-danger btn-sm" title="Remove Report"
                                @click="deleteReport(employee.active_report.id)"><i class="fa fa-trash"></i></button>
                    </td>
                    <td>
                        <input type="file" accept="application/pdf" @change="processFile($event, employee.id)"/>
                    </td>
                </tr>
                </tbody>
            </table>
        </b-card>
    </div>
</template>
<script>

  import {fetchEmployeeWithReport} from "../../actions/UsersActions";
  import {deleteReport, uploadReport} from "../../actions/ReportsActions";

  export default {
    data() {
      return {
        employees: [],
        file: ''
      }
    },
    mounted() {
      this.fetchData()
    },
    methods: {
      fetchData() {
        fetchEmployeeWithReport().then(response => {
          this.employees = response.data.data;
        })
      },
      processFile(event, employeeId) {
        let files = event.target.files;
        let formData = new FormData();
        formData.append('file', files[0]);
        formData.append('id', employeeId);
        uploadReport(formData).then(response => {
          this.$toaster.success("Upload Success");
          this.fetchData();
        }).catch(error => {
          this.$toaster.error("Please try again.");
        });
      },
      deleteReport(id) {
        this.$confirm().then(res => {
          if (res) {
            deleteReport(id).then(response => {
              this.$toaster.success("Delete Success");
              this.fetchData();
            }).catch(error => {
              this.$toaster.error("Please try again.");
            });
          }
        })
      }
    }
  }
</script>
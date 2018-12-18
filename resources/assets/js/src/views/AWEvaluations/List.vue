<template>
    <div class="animated fadeIn">
        <b-row>
            <b-col lg="12">
                <b-card>
                    <b-tabs>
                        <b-tab title="Work Evaluation" active>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Employee</th>
                                    <th>Efficiency</th>
                                    <th>Productivity</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(row, index) in data.work">
                                    <td v-text="row.id"></td>
                                    <td v-text="row.user ? row.user.name : ''"></td>
                                    <td v-text="row.efficiency"></td>
                                    <td v-text="row.productivity"></td>
                                    <td v-text="row.total"></td>
                                </tr>
                                </tbody>
                            </table>
                        </b-tab>
                        <b-tab title="Administrative Evaluation">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Employee</th>
                                    <th>Attendance</th>
                                    <th>Punctuality</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(row, index) in data.administrative">
                                    <td v-text="row.id"></td>
                                    <td v-text="row.user ? row.user.name : ''"></td>
                                    <td v-text="row.attendance"></td>
                                    <td v-text="row.punctuality"></td>
                                    <td v-text="row.total"></td>
                                </tr>
                                </tbody>
                            </table>
                        </b-tab>
                    </b-tabs>
                </b-card>
            </b-col>
        </b-row>
        <b-row>
            <b-col lg="12">
                <b-card>
                    <b-row>
                        <div class="col-md-3">
                            <h5>Work Evaluation</h5>
                            <csv-upload url="/evaluations/work"></csv-upload>
                        </div>
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-3">
                            <h5>Administrative Evaluation</h5>
                            <csv-upload url="/evaluations/administrative"></csv-upload>
                        </div>
                    </b-row>
                </b-card>
            </b-col>
        </b-row>
    </div>
</template>
<script>
  import csvUpload from '../../components/Csv/UploadCsv';
  import {getEvaluations} from "../../actions/AppraiseActions";

  export default {
    data() {
      return {
        data: []
      }
    },
    components: {
      csvUpload
    },
    mounted() {
      this.fetchData();
    },
    methods: {
      fetchData() {
        getEvaluations().then(res => {
          this.data = res.data.data;
        })
      }
    }
  }
</script>

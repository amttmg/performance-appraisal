<template>
    <b-card header="Employee Details">
        <b-card>
            <div v-if=" employeeDetail.administrative_evaluations">
                <h4>Administrative Evaluation</h4>
                <table class="table" >
                    <tbody>
                    <tr v-if=" employeeDetail.administrative_evaluations">
                        <th width="30%"><span class="text-primary">Attendance</span> :
                            {{ employeeDetail.administrative_evaluations.attendance }} out of 5
                        </th>
                        <th width="30%"><span class="text-primary">Punctuality</span> : {{
                            employeeDetail.administrative_evaluations.punctuality }} out of 5
                        </th>
                        <th><span class="text-primary">Total</span> : {{ employeeDetail.administrative_evaluations.total }} out of 10
                        </th>
                    </tr>
                    <tr v-else>
                        <td style="text-align:center;">There are no records to show</td>
                    </tr>
                    </tbody>
                </table>
            </div>
           <div v-if=" employeeDetail.work_evaluations">
               <h4>Work Evaluation</h4>
               <table class="table">
                   <tbody>
                   <tr v-if=" employeeDetail.work_evaluations">
                       <th width="30%"><span class="text-primary">Work Efficiency</span> : {{
                           employeeDetail.work_evaluations.efficiency }} out of 10
                       </th>
                       <th width="30%"><span class="text-primary">Work Productivity</span> : {{
                           employeeDetail.work_evaluations.productivity }} out of 15
                       </th>
                       <th><span class="text-primary">Total</span> : {{ employeeDetail.work_evaluations.total }} out of 25</th>
                   </tr>
                   <tr v-else>
                       <td style="text-align:center;">There are no records to show</td>
                   </tr>
                   </tbody>
               </table>
           </div>
        </b-card>
        <div v-if="employeeDetail.active_projects.length">
            <h4>Project Details</h4>
            <b-table :filter="filter" show-empty bordered striped hover small
                     lass="table-sm"
                     responsive="sm"
                     :items="employeeDetail.active_projects"
                     :fields="projectDetailFields">
                <template slot="index" slot-scope="data">
                    {{data.index + 1}}
                </template>
            </b-table>
        </div>
    </b-card>
</template>
<script>
  export default {
    props: ['employeeDetail'],
    data() {
      return {
        filter: '',
        workEvaluationFields: [
          {key: 'index', label: 'SN.'},
          {key: 'code', sortable: true},
          {key: 'planned_vs_spent_hours', sortable: true},
          {key: 'description', sortable: true},
          {key: 'remarks', sortable: true},
        ],
        adminEvaluationsFields: [
          {key: 'index', label: 'SN.'},
          {key: 'code', sortable: true},
          {key: 'description', sortable: true},
          {key: 'punctuality', sortable: true},
          {key: 'score', sortable: true},
          {key: 'remarks', sortable: true},
        ],
        projectDetailFields: [
          {key: 'index', label: 'SN.'},
          {key: 'project_code', sortable: true},
          {key: 'planned_vs_spent_hours', sortable: true, label: 'P. vs S. Hours (Out of 15)'},
          {key: 'planned_vs_spent_beta_release', sortable: true, label: 'P. vs S. Beta Release (Out of 10)'},
          {key: 'project_quality', sortable: true, label:'Project Quality (Out of 10)'},
          {key: 'project_complexity', sortable: true, label: 'Project Complexity (Out of 5)'},
          {key: 'bug_vs_planned', sortable: true, label: 'Bug Hours (Out of 5)'},
          {key: 'code_quality', sortable: true, label: 'Code Quality (Out of 5)'},
          {key: 'total_score', sortable: true, label: 'Total (Out of 40)'},
          {key: 'is_completed', sortable: true},
          {key: 'department', sortable: true},
        ],
      }
    }
  }
</script>
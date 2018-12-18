<template>
    <div class="animated fadeIn">
        <b-card header="<i class='fa fa-align-justify'></i> Project List">
            <data-table :draw="draw" :actions="actions" url="projects" bordered :columns="fields" :perPage="perPage"
                        striped
                        caption="<i class='fa fa-align-justify'></i> Employee List" @actionClick="clickedAction">
            </data-table>
        </b-card>
        <b-row>
            <b-col lg="12">
                <b-card>
                    <div class="col-md-3">
                        <csv-upload url="/projects/upload-csv" v-model="draw"></csv-upload>
                    </div>
                </b-card>
            </b-col>
        </b-row>
        <b-modal ref="projectEdit" title="Update Project">
            <p class="my-4">{{ item }}</p>
        </b-modal>
    </div>
</template>
<script>
  import DataTable from '../../components/Table/DataTable'
  import csvUpload from '../../components/Csv/UploadCsv';
  import {deleteProject} from "../../actions/ProjectAction";

  export default {
    data() {
      return {
        fields: [
          {key: 'project_code', sortable: true},
          {key: 'planned_vs_spent_hours', sortable: true, label:'P. vs S. Hours'},
          {key: 'planned_vs_spent_beta_release', sortable: true, label: 'P. vs S. Beta Release'},
          {key: 'project_quality', sortable: true},
          {key: 'project_complexity', sortable: true},
          {key: 'bug_vs_planned', sortable: true},
          {key: 'code_quality', sortable: true},
          {key: 'total_score', sortable: true},
          {key: 'is_completed', sortable: true},
          {key: 'department', sortable: true},
          {key: 'actions'}
        ],
        actions: [
          {name: 'edit', label: 'Edit', icon: 'fa fa-edit', class: 'primary'},
          {name: 'delete', label: 'Delete', icon: 'fa fa-trash', class: 'danger'}
        ],
        striped: false,
        bordered: false,
        outlined: false,
        small: false,
        hover: false,
        dark: false,
        fixed: false,
        footClone: false,
        perPage: 50,
        draw: false,
        item: ''
      }
    },
    methods: {
      clickedAction(item) {
        let self = this;
        if (item.delete) {
          this.$confirmDelete().then(d => {
            if (d) {
              deleteProject(item.delete.item.id).then(res => {
                self.$toaster.success(res.data.message);
                self.draw = true;
              }).catch(e => {
                console.log(e);
              })
            }
          });
        } else if (item.edit) {
          self.item = item.edit.item;
          this.$refs.projectEdit.show();
        }
      }
    },
    components: {
      csvUpload,
      DataTable
    },
  }
</script>

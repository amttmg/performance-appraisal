<template>
    <div class="animated fadeIn">
        <b-card header="<i class='fa fa-align-justify'></i> Employee List">
            <data-table :draw="draw" url="users" bordered :actions="actions" :columns="columns" :perPage="perPage"
                        striped
                        caption="<i class='fa fa-align-justify'></i> Employee List" @actionClick="clickedAction">
            </data-table>
            <b-button variant="primary" @click="sendNewPasswordToAll"> Set new password &nbsp;<i class="fa fa-paper-plane"></i></b-button>
        </b-card>
        <b-card>
            <div class="col-md-3">
                <csv-upload url="/users"></csv-upload>
            </div>
        </b-card>
        <b-modal ref="userEdit" title="Update Employee">
            <p class="my-4">{{ item }}</p>
        </b-modal>
    </div>
</template>
<script>
  import DataTable from '../../components/Table/DataTable'
  import CsvUpload from '../../components/Csv/UploadCsv';
  import {deleteEmployee, setNewPassword} from "../../actions/UsersActions";

  export default {
    data: () => {
      return {
        items: [],
        item: '',
        columns: [
          {key: 'id', sortable: true},
          {key: 'name', sortable: true},
          {key: 'username', sortable: true},
          {key: 'email', sortable: true},
          {key: 'technology.name', sortable: false},
          {key: 'actions', label: 'Actions'}
        ],
        actions: [
          {
            name: 'edit',
            label: 'Edit',
            icon: 'fa fa-edit',
            class: 'primary'
          },
          {
            name: 'delete',
            label: 'Delete',
            icon: 'fa fa-trash',
            class: 'danger'
          }, {
            name: 'password',
            label: 'Send Password',
            icon: 'fa fa-paper-plane',
            class: 'primary'
          }],
        currentPage: 1,
        perPage: 50,
        draw: false
      }
    },
    methods: {
      sendNewPasswordToAll() {
        this.$confirm({
          title: 'Are you sure want to set new password to all ?',
          dangerMode: false, text: 'This will reset previous password'
        }).then(yes => {
          if (yes) {
            setNewPassword().then(res => {
              this.$toaster.success("New password set successfully !")
            }).catch(error => {
              console.log(error);
              this.$toaster.error("Something went wrong please try again !")
            })
          }
        });
      },
      clickedAction(item) {
        let self = this;
        if (item.delete) {
          this.$confirmDelete().then(d => {
            if (d) {
              deleteEmployee(item.delete.item.id).then(res => {
                self.$toaster.success(res.data.message);
                self.draw = true;
              }).catch(e => {
                console.log(e);
              })
            }
          });
        } else if (item.edit) {
          self.item = item.edit.item;
          self.$refs.userEdit.show();
        } else if (item.password) {
          this.$confirm(
            {
              title: 'Are you sure want to set new password ?',
              dangerMode: false,
              text: "this will reset previous password "
            }
          ).then(yes => {
            if (yes) {
              setNewPassword(item.password.item.id).then(res => {
                this.$toaster.success("New password set successfully !")
              }).catch(error => {
                console.log(error);
                this.$toaster.error("Something went wrong please try again !")
              })
            }
          });
        }
      }
    },
    components: {
      CsvUpload,
      DataTable
    }
  }
</script>

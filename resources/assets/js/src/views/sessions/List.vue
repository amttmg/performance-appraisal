<template>
    <div class="animated fadeIn">
        <b-collapse v-model="visibleForm" id="sessionForm">
            <b-card header="<i class='fa fa-align-justify'></i> Add New Session">
                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                    <b-form-group
                            label="Project Code :"
                            label-for="code">
                        <b-form-input v-model="form.code" type="text" placeholder="Enter new session"
                                      required></b-form-input>
                    </b-form-group>
                    <b-form-group
                            label="Description :"
                            label-for="description">
                        <b-form-textarea id="description"
                                         v-model="form.description"
                                         placeholder="Enter Description"
                                         :rows="3"
                                         :max-rows="6" required>
                        </b-form-textarea>
                    </b-form-group>
                    <b-form-group
                            label="From Date :"
                            label-for="from">
                        <b-form-input v-model="form.from" type="date" placeholder="From Date" required></b-form-input>
                    </b-form-group>
                    <b-form-group
                            label="To Date :"
                            label-for="to">
                        <b-form-input v-model="form.to" type="date" placeholder="To Date" required></b-form-input>
                    </b-form-group>
                    <b-form-group>
                        <b-form-checkbox id="sessionStatus"
                                         v-model="form.is_active"
                                         value="true"
                                         unchecked-value="0">
                            Active this session
                        </b-form-checkbox>
                    </b-form-group>
                    <b-button type="submit" variant="primary"><i class="fa fa-save"></i> Submit</b-button>
                    <b-button type="reset" variant="danger"><i class="fa fa-refresh"></i> Reset</b-button>
                    <b-button type="reset" v-b-toggle.sessionForm variant="warning"><i class="fa fa-close"></i> Close
                    </b-button>
                </b-form>
            </b-card>
        </b-collapse>
        <b-card header-tag="header">
            <h6 slot="header" class="mb-0">
                <i class='fa fa-clock-o'></i> Session List
                <b-button type="button" v-b-toggle.sessionForm variant="primary" class="pull-right"><i
                        ref="addNewButtonIcon" class="fa fa-plus"></i>
                    Add New
                </b-button>
            </h6>
            <b-row>
                <b-col md="12" class="my-1">
                    <b-col md="4" class="my-1 pull-right">
                        <b-form-group>
                            <b-input-group>
                                <b-form-input v-model="filter" placeholder="Type to Search"></b-form-input>
                                <b-input-group-append>
                                    <b-btn :disabled="!filter" @click="filter = ''">Clear</b-btn>
                                </b-input-group-append>
                            </b-input-group>
                        </b-form-group>
                    </b-col>
                </b-col>
            </b-row>
            <b-table :filter="filter" show-empty bordered striped hover small
                     lass="table-sm"
                     responsive="sm"
                     :items="sessions"
                     :fields="fields">
                <template slot="index" slot-scope="data">
                    {{data.index + 1}}
                </template>
                <template slot="is_active" slot-scope="row">
                    <b-button-toolbar>
                        <b-btn class="mx-1 btn-sm" variant="primary" v-if="row.item.is_active">
                            <i class="fa fa-check"></i>
                        </b-btn>
                        <b-btn class="mx-1 btn-sm" variant="danger" @click="changeState(row.item)"
                               v-if="!row.item.is_active">
                            <i class="fa fa-times"></i>
                        </b-btn>
                        <router-link :to="'/session/detail/'+row.item.id+'/'+row.item.code">
                            <b-btn class="mx-1 btn-sm" variant="primary">
                                <i class="fa fa-info"></i>
                            </b-btn>
                        </router-link>
                    </b-button-toolbar>
                </template>
            </b-table>
        </b-card>
    </div>
</template>
<script>
  import {storeSession, getSession, changeState} from "../../actions/SessionAction";

  export default {
    data() {
      return {
        show: 'true',
        form: {
          code: '',
          description: '',
          from: '',
          to: '',
          is_active: true,
        },
        filter: '',
        sessions: [],
        visibleForm: false,
        fields: [
          {key: 'index', label: 'SN.'},
          {key: 'code', label: 'Project Code', sortable: true},
          {key: 'description', sortable: true},
          {key: 'from', label: 'From Date', sortable: true},
          {key: 'to', label: 'To Date', sortable: true},
          {key: 'is_active', sortable: true}
        ]
      }
    },
    mounted() {
      this.getAllSessions();
    },
    methods: {
      getAllSessions() {
        let self = this;
        getSession().then(res => {
          self.sessions = res.data.data;
        });
      },
      changeState(item) {
        let self = this;
        if (!item.state) {
          this.$confirm({icon: 'warning', title: 'are you sure want to active ?', dangerMode: false}).then(confirm => {
            if (confirm) {
              changeState(item.id, {is_active: 1}).then(res => {
                self.$toaster.success("Update Successfully !");
                self.sessions = _.map(self.sessions, function(session) {
                  session.is_active = session.id === item.id;
                  return session;
                });
              }).catch(res => {
                console.log(res);
                self.$toaster.error("Something went wrong !");
              });
            }
          })
        }
      },
      onSubmit(evt) {
        evt.preventDefault();
        let data = qs.stringify(this.form);
        let self = this;
        storeSession(data).then(res => {
          if (res.data.data.is_active) {
            self.sessions = _.map(self.sessions, function(session) {
              session.is_active = false;
              return session;
            });
          }
          self.sessions = [res.data.data, ...self.sessions];
          self.$toaster.success("New session added successfully !");
          self.reset();
          self.visibleForm = false;
        }).catch(res => {
          console.log(res);
          this.$toaster.error("Something went wrong !");
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
        this.form.code = '';
        this.form.description = '';
        this.form.from = '';
        this.form.to = '';
        this.form.is_active = 1;
      },
    }
  }
</script>
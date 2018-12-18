<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-2">
                <b-card no-body header="<b>Employee List</b>">
                    <b-list-group flush>
                        <b-list-group-item
                                href="#"
                                v-for="appraise in appraises"
                                :key="appraise.id"
                                :class="{active: appraise.id===selected.id}"
                                @click="handleSelect(appraise)">
                            <i class="fa fa-check-circle" v-show="appraise.is_completed"></i>
                            {{ appraise.appraise_of.name }}
                            <b-badge style="color: white" variant="info" class="pull-right"
                                     v-text="appraise.type.title"></b-badge>
                        </b-list-group-item>
                    </b-list-group>
                </b-card>
                <b-card no-body header="<b>Your PA Reports</b>" v-if="report">
                    <b-list-group flush>
                        <b-list-group-item>
                            <a href="/my-report" target="_blank"> <i class="fa fa-download"></i> Click
                                here to download</a>
                        </b-list-group-item>
                    </b-list-group>
                </b-card>
            </div>
            <div class="col-md-10">
                <project-detail :employeeDetail="selected.appraise_of"
                                v-if="Object.keys(selected.appraise_of).length && role.title!='developer'"></project-detail>
                <div v-show="!selected.is_completed">
                    <b-card v-show="!questionGroups.length" header="<b>Evaluation Form</b>">
                        <h4 style="text-align: center"
                            v-text="loading? 'Please Wait....' : 'Please Select Employee to Rate'"></h4>
                    </b-card>
                    <b-card v-show="questionGroups.length" header="<b>Evaluation Form</b>">
                        <question-table :answers="questionAnswers" v-for="group in questionGroups" :key="group.id"
                                        :group="group"></question-table>

                        <b-card header="Feedback">
                            <b-form-group label="Strength">
                                <b-form-textarea id="textarea1"
                                                 v-model="strengthVsWeakness.strength"
                                                 placeholder="Strength"
                                                 :rows="3"
                                                 :max-rows="6">
                                </b-form-textarea>
                            </b-form-group>
                            <b-form-group label="Weakness">
                                <b-form-textarea id="textarea1"
                                                 v-model="strengthVsWeakness.weakness"
                                                 placeholder="Weakness"
                                                 :rows="3"
                                                 :max-rows="6">
                                </b-form-textarea>
                            </b-form-group>
                            <b-form-group label="Training Required">
                                <b-form-textarea id="textarea1"
                                                 v-model="strengthVsWeakness.training_required"
                                                 placeholder="Training Required"
                                                 :rows="3"
                                                 :max-rows="6">
                                </b-form-textarea>
                            </b-form-group>
                            <b-form-group label="Feedback">
                                <b-form-textarea id="textarea1"
                                                 v-model="strengthVsWeakness.feedback"
                                                 placeholder="Feedback"
                                                 :rows="3"
                                                 :max-rows="6">
                                </b-form-textarea>
                            </b-form-group>
                        </b-card>
                        <b-button-toolbar key-nav aria-label="Toolbar with button groups">
                            <button class="btn btn-success mx-1" @click="handleSubmit">
                                <i class="fa fa-save"></i>
                                {{submitting ? 'Please Wait..' : 'Save as Draft'}}
                            </button>
                            <button class="btn btn-primary mx-1" @click="handleFinalSubmit">
                                <i class="fa fa-save"></i>
                                {{submitting ? 'Please Wait..' : 'Final Submit'}}
                            </button>
                        </b-button-toolbar>
                    </b-card>

                </div>
                <div v-show="selected.is_completed">
                    <b-card header="<b>Evaluation Form</b>">
                        <h4 style="text-align: center">
                            <i class="fa fa-check-circle"></i>
                            You have completed review of this user.
                        </h4>
                    </b-card>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
  import ProjectDetail from './project/List';
  import QuestionTable from './QuestionTable';
  import {getAppraise, getQuestions, saveAnswers} from "../../actions/AppraiseActions";
  import {mapGetters} from 'vuex';

  export default {
    data() {
      return {
        selected: {
          appraise_of: {}
        },
        loading: false,
        submitting: false,
        rating: [],
        appraises: [],
        questionGroups: [],
        questionAnswers: [],
        strengthVsWeakness: {
          strength: '',
          weakness: '',
          training_required: '',
          feedback: ''

        },
        report: {}
      }
    },
    computed: {
      ...mapGetters({role: 'getRole'})
    },
    mounted() {
      this.getAppraise();
    },
    methods: {
      getAppraise() {
        getAppraise().then(response => {
          this.appraises = response.data.data.data;
          this.report = response.data.data.report;
        })
      },
      getQuestions(appraiseId) {
        this.loading = true;
        getQuestions(appraiseId)
          .then(response => {
            this.loading = false;
            this.questionGroups = response.data.data.questions;
            this.strengthVsWeakness = response.data.data.strengthVsWeakness;
          })
      },
      handleSelect(appraise) {
        this.selected = appraise;
        this.getQuestions(appraise.id);
      },
      handleSubmit() {
        if (!this.validate()) {
          return false;
        }
        this.submitting = true;
        saveAnswers(this.questionAnswers.clean(), this.strengthVsWeakness, this.selected).then(response => {
          this.submitting = false;
          this.$toaster.success('Successfully Saved.')
        }).catch(error => {
          this.submitting = false;
          this.$toaster.error('Please Try Again.')
        });
        return true;
      },
      handleFinalSubmit() {
        let defaultSettings = {
          title: "Are you sure ?",
          text: "You can not change after this submission.",
          icon: false,
          buttons: true,
          dangerMode: false,
        };
        this.$confirm(defaultSettings).then(result => {
          if (result) {
            let res = this.handleSubmit();
            if (res) {
              this.selected.is_completed = 1;
            }
          }
        });
      },
      validate() {
        self = this;
        let countErrors = 0;
        self.questionGroups.forEach(function(group) {
          if (group.children.length) {
            group.children.forEach(function(gp) {
              countErrors += self.isValid(gp);
            })
          } else {
            countErrors += self.isValid(group);
          }
        });
        return (countErrors === 0);
      },
      isValid(group) {
        let countErrors = 0;
        group.questions.forEach(function(question) {
          if (!question.answer) {
            question.error = "This field is required.";
            countErrors += 1;
          } else {
            question.error = "";
          }
        });
        return countErrors;
      }
    },
    components: {
      QuestionTable,
      ProjectDetail
    }
  }
  Array.prototype.clean = function(deleteValue) {
    for (let i = 0; i < this.length; i++) {
      if (this[i] == deleteValue) {
        this.splice(i, 1);
        i--;
      }
    }
    return this;
  };
</script>
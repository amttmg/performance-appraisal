<template>
    <div class="animated fadeIn">
        <b-collapse v-model="visibleForm" id="questionForm">
            <b-card header-tag="header">
                <h6 slot="header" v-if="formActionType=='create'">
                    <i class='fa fa-align-justify'></i> Add New Question
                </h6>
                <h6 slot="header" v-if="formActionType=='update'">
                    <i class='fa fa-align-justify'></i> Update Question
                </h6>
                <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                    <b-form-group id="questionInputGroup"
                                  label="Question Group :"
                                  label-for="questionInput">
                        <b-form-select id="questionInput"

                                       required
                                       v-model="form.group_id">
                            <option slot="first" :value="null">--- Please Select ---</option>
                            <template v-for="group in questionsGroups">
                                <optgroup v-if="group.children.length" :label="group.title">
                                    <option v-for="gp in group.children" :value="gp.id" v-text="gp.title"></option>
                                </optgroup>
                                <option v-if="!group.children.length" :value="group.id" v-text="group.title"></option>
                            </template>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group
                            label="Question :"
                            label-for="question">
                        <b-form-textarea id="question" v-model="form.question" :rows="3" :max-rows="6"
                                         placeholder="Enter Question" required>
                        </b-form-textarea>
                    </b-form-group>
                    <b-form-group label="Select Technologies :">
                        <b-form-checkbox v-model="selectAllTechnology"
                                         :indeterminate="indeterminate"
                                         aria-describedby="technologies"
                                         aria-controls="technologies"
                                         value-field="id"
                                         text-field="name"
                                         @change="toggleAll">
                            {{ selectAllTechnology ? 'Un-select All' : 'Select All' }}
                        </b-form-checkbox>
                        <b-form-checkbox-group v-model="selectedTechnologies"
                                               id="technologySelect"
                                               name="flavs"
                                               :options="technologies"
                                               value-field="id"
                                               text-field="name"
                                               aria-label="Technologies">

                        </b-form-checkbox-group>
                    </b-form-group>
                    <b-button type="submit" variant="primary"><i class="fa fa-save"></i> {{ formActionType === 'update'
                        ? 'Update' : 'Submit'}}
                    </b-button>
                    <b-button type="reset" variant="danger"><i class="fa fa-refresh"></i> Reset</b-button>
                    <b-button type="reset" v-b-toggle.questionForm variant="warning"><i class="fa fa-close"></i> Close
                    </b-button>
                </b-form>
            </b-card>
        </b-collapse>
        <b-card header-tag="header">
            <h6 slot="header" class="mb-0">
                <i class='fa fa-book'></i> Question List
                <b-button type="button" v-b-toggle.questionForm variant="primary" @click="reset" class="pull-right"><i
                        class="fa fa-plus"></i>
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
                     :items="questions"
                     :fields="fields">
                <template slot="index" slot-scope="data">
                    {{data.index + 1}}
                </template>
                <template slot="actions" slot-scope="data">
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-danger mr-2" @click="deleteQuestion(data.item.id)"><i
                                class="fa fa-trash"></i></button>
                        <button class="btn btn-sm btn-primary" @click="editQuestion(data.item)"><i
                                class="fa fa-edit"></i></button>
                    </div>
                </template>
                <template slot="technologies" slot-scope="row">
                    <div>
                        <b-badge pill class="mx-1" variant="primary" v-if="row.item.technologies.length===12">
                            All
                        </b-badge>
                        <b-badge v-if="row.item.technologies.length!==row.item.count" pill class="mx-1"
                                 variant="primary"
                                 v-for="(technology,key) in row.item.technologies"
                                 :key="key">{{
                            technology.name }}
                        </b-badge>
                    </div>
                </template>
                <template slot="group" slot-scope="row">
                    <div>
                        <b-badge pill class="mx-1" variant="primary" v-if="row.item.group.parent">
                            {{ row.item.group.parent.title}}
                            <i class="fa fa-arrow-right"></i> {{ row.item.group.title}}
                        </b-badge>
                        <b-badge pill class="mx-2" variant="primary" v-if="!row.item.group.parent">{{
                            row.item.group.title}}
                        </b-badge>
                    </div>
                </template>
            </b-table>
        </b-card>
    </div>
</template>
<script>
  import {getTechnologies} from '../../actions/TechnologyAction';
  import {getQuestionGroup} from '../../actions/QuestionGroup';
  import {deleteQuestions, getQuestions, storeQuestion, updateQuestion} from "../../actions/QuestionAction";

  export default {
    data() {
      return {
        show: 'true',
        formActionType: 'create',
        questionId: null,
        form: {
          question: '',
          technologies: [],
          group_id: null
        },
        visibleForm: false,
        selectedTechnologies: [],
        technologies: [],
        filter: '',
        questions: [],
        questionsGroups: [],
        selectAllTechnology: false,
        indeterminate: false,
        fields: [
          {key: 'index', label: 'SN.'},
          {key: 'question', sortable: true},
          {key: 'group', sortable: true},
          {key: 'technologies', sortable: true},
          {key: 'actions', label: 'Actions'}
        ]
      }
    },
    mounted() {
      this.getTechnologies();
      this.getQuestionGroups();
      this.getQuestions();
    },
    watch: {
      selectedTechnologies(newVal, oldVal) {
        console.log(newVal);
        this.form.technologies = newVal;
        if (newVal.length === 0) {
          this.indeterminate = false;
          this.selectAllTechnology = false;
        } else if (newVal.length === this.technologies.length) {
          this.indeterminate = false;
          this.selectAllTechnology = true;
        } else {
          this.indeterminate = true;
          this.selectAllTechnology = false;
        }
      }
    },
    methods: {
      toggleAll(checked) {
        let self = this;
        self.selectedTechnologies = checked ? _.map(self.technologies, 'id') : []
      },
      editQuestion(question) {
        window.scrollTo(0, 0);
        let self = this;
        self.form.question = question.question;
        self.form.group_id = question.group_id;
        self.form.technologies = _.map(question.technologies, 'id');
        self.selectedTechnologies = self.form.technologies;
        self.formActionType = "update";
        self.questionId = question.id;
        self.visibleForm = true;
      },
      onSubmit(evt) {
        evt.preventDefault();
        let data = qs.stringify(this.form);
        let self = this;
        if (self.formActionType === 'create') {
          storeQuestion(data).then(res => {
            self.$toaster.success('Saved successfully !');
            self.getQuestions();
            self.reset();
          }).catch(err => {
            console.log(err.response);
          });
        } else {
          updateQuestion(self.questionId, data).then(res => {
            self.$toaster.success('Update successfully !');
            self.getQuestions();
            self.reset();
            self.visibleForm = false;
          }).catch(err => {
            console.log(err.response);
          });
        }
      },
      onReset(evt) {
        evt.preventDefault();
        this.reset();
        this.$nextTick(() => {
          this.show = true
        });
      },
      reset() {
        this.selectAllTechnology = false;
        this.form.question = '';
        this.selectedTechnologies = [];
        this.form.group_id = null;
        this.formActionType = 'create';
      },
      getQuestions() {
        let self = this;
        getQuestions().then(res => {
          self.questions = res.data;
        });
      },
      getTechnologies() {
        let self = this;
        getTechnologies().then(res => {
          self.technologies = res.data
        });
      },
      getQuestionGroups() {
        let self = this;
        getQuestionGroup().then(res => {
          self.questionsGroups = res.data;
        });
      },
      deleteQuestion(id) {
        this.$confirm().then(res => {
          if (res) {
            deleteQuestions(id).then(response => {
              console.log(response);
              this.getQuestions();
            })
          }
        });
      }
    }
  }
</script>
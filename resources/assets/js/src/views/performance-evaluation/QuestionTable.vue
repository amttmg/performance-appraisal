<template>
    <b-card :header="group.title">
        <div v-show="group.children.length">
            <div v-for="gp in group.children">
                <h4>{{gp.title}}</h4>
                <table class="table table-sm">
                    <question
                            v-for="(question, index) in gp.questions"
                            :question="question"
                            :index="index"
                            :answers="answers"
                            :key="index"/>
                </table>
            </div>
        </div>
        <table class="table table-sm">
            <question
                    :answers="answers"
                    v-for="(question, index) in group.questions"
                    :question="question"
                    :index="index"
                    :key="index"/>
        </table>
    </b-card>
</template>
<script>
  import Question from './Question';

  export default {
    props: ['group', 'answers'],
    components: {
      Question
    }
  }
  ;
</script>
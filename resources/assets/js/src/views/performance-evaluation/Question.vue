<template>
    <tr>
        <td width="5%">{{index+1}}.</td>
        <td>{{ question.question }}</td>
        <td width="10%">
            <div class="form-group has-error">
                <select class="form-control"
                        style="width: 80px"
                        v-bind:class="{'is-invalid':question.error}"
                        @change="onChange"
                        v-model="question.answer"
                >
                    <option value="0.5">0.5</option>
                    <option value="1">1</option>
                    <option value="1.5">1.5</option>
                    <option value="2">2</option>
                    <option value="2.5">2.5</option>
                    <option value="3">3</option>
                    <option value="3.5">3.5</option>
                    <option value="4">4</option>
                </select>
                <div class="invalid-feedback" v-if="question.error" v-text="question.error">
                </div>
            </div>
        </td>
        <td width="10%">
            <star-rating
                    :max-rating="4"
                    :increment="0.5"
                    :item-size="20"
                    :show-rating="false"
                    v-model="question.answer"
                    read-only
            />
        </td>
       <!-- <td>
            <input type="text" class="form-control" placeholder="Remarks (Optional)" @change="onChange" v-model="question.feedback"/>
        </td>-->
    </tr>
</template>
<script>
  import {StarRating} from 'vue-rate-it';

  export default {
    props: ['question', 'index', 'answers'],
    components: {
      StarRating
    },
    methods: {
      onChange() {
        this.answers[this.question.id] = this.question;
        this.question.error = null;
      }
    }
  }
</script>
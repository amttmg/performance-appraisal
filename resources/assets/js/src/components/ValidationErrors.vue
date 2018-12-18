<template>
    <div class="alert alert-danger" v-if="validationErrors">
        <p v-text="validationErrors.message"></p>
        <ul>
            <li v-for="error in validationErrors.errors" v-text="error[0]"></li>
        </ul>
    </div>
</template>
<script>
  export default {
    props: ['validationErrors']
  }
</script>
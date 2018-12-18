<template>
    <b-nav-item-dropdown right no-caret>
        <template slot="button-content">
            <i class="fa fa-user-circle fa-2x"></i>
        </template>
        <b-dropdown-item
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa fa-lock"/> Logout
        </b-dropdown-item>
    </b-nav-item-dropdown>
</template>
<script>
  export default {
    name: 'header-dropdown',
    data: () => {
      return {itemsCount: 42}
    }
  }
</script>

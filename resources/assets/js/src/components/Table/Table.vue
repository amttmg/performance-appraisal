<template>
    <b-card :header="caption">
        <div class="row">
            <div v-show="!hidePageSize" class="col-md-1">
                <div class="form-group">
                    <label for="sel1">Per Page</label>
                    <select class="form-control" id="sel1" v-model="perPage">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                </div>
            </div>
            <div v-show="!hideSearch" class="col-md-3">
                <div class="form-group">
                    <label for="sel1">Search</label>
                    <input v-model="txtSearch" type="text" class="form-control"/>
                </div>
            </div>
        </div>
        <b-table :hover="hover" :striped="striped" :bordered="bordered" :small="small" :fixed="fixed" responsive="sm"
                 :items="filteredList" :current-page="currentPage" :per-page="perPage">
        </b-table>
        <nav>
            <b-pagination :total-rows="getRowCount(filteredList)" :per-page="perPage" v-model="currentPage"
                          prev-text="Prev" next-text="Next">

            </b-pagination>
        </nav>
    </b-card>
</template>

<script>
  export default {
    name: 'c-table',
    props: {
      caption: {
        type: String,
        default: 'Table'
      },
      hover: {
        type: Boolean,
        default: false
      },
      striped: {
        type: Boolean,
        default: false
      },
      bordered: {
        type: Boolean,
        default: false
      },
      small: {
        type: Boolean,
        default: false
      },
      fixed: {
        type: Boolean,
        default: false
      },
      items: {
        type: Array,
        default: []
      },
      columns: {
        type: Array,
        default: []
      },
      currentPage: {
        type: Number,
        default: 1
      },
      perPage: {
        type: Number,
        default: 10
      },
      hidePageSize: {
        type: Boolean,
        default: false
      },
      hideSearch: {
        type: Boolean,
        default: false
      },
    },
    data() {
      return {
        perPage: this.perPage,
        filter: ''
      }
    },
    methods: {
      getRowCount(data) {
        return data.length
      }
    },
    computed: {
      filteredList() {
        let self = this;
        return self.items.filter((val) => {
          return val['name'].toLowerCase().search(self.filter.toLowerCase()) > -1
        });
      }
    }
  }
</script>

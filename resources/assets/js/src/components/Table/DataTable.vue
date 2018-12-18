<template>
    <b-container fluid>
        <b-row>
            <b-col md="2" class="my-1">
                <b-form-group>
                    <b-form-select :options="pageOptions" :plain="true" v-model="perPageItems"></b-form-select>
                </b-form-group>
            </b-col>
            <b-col md="10" class="my-1">
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
        <b-table :busy="loading" show-empty :hover="hover" :filter="filter" :striped="striped" :bordered="bordered"
                 :small="small"
                 :fixed="fixed" class="table-sm" responsive="sm"
                 :items="items" :sort-by.sync="sortBy"
                 :sort-desc.sync="sortDesc" :fields="columns" :current-page="currentPage" :per-page="perPageItems"
                 @filtered="onFiltered">
            <template slot="actions" slot-scope="row" v-if="actions.length">
                <div>
                    <b-button-toolbar>
                        <b-btn class="mx-1 btn-sm" :title="action.label" :variant="action.class" v-for="(action, key) in actions" :key="key"
                               @click="$emit('actionClick', {[action.name]:row})">
                            <i :class="action.icon"></i>
                        </b-btn>
                    </b-button-toolbar>
                </div>
            </template>
        </b-table>
        <b-row>
            <b-col md="6" class="my-1" offset-md="6">
                <b-pagination class="pull-right" :total-rows="totalRows" :per-page="perPageItems" v-model="currentPage"
                              prev-text="Prev"
                              next-text="Next">
                </b-pagination>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
  import {fetchData} from "../../actions/DataTableAction";

  export default {
    props: {
      url: {
        type: String
      },
      actions: {
        default: () => {
          return [];
        },
        type: Array
      },
      caption: {
        type: String,
        default: 'Table'
      },
      pageOptions: {
        type: Array,
        default: () => {
          return [10, 25, 50, 100]
        }
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
      columns: {
        default: [],
        type: Array
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
      draw: {
        type: Boolean,
        default: false
      },
    },
    data() {
      return {
        filter: '',
        sortBy: '',
        sortDesc: '',
        totalRows: 0,
        currentPage: 1,
        items: [],
        perPageItems: this.perPage,
        loading: false
      }
    },
    mounted() {
      this.fetchData();
    },
    methods: {
      getRowCount(data) {
        return data.length
      },
      onFiltered(filteredItems) {
        this.totalRows = filteredItems.length;
        this.currentPage = 1
      },
      fetchData() {
        let self = this;
        self.loading = true;
        fetchData(self.url, self.query)
          .then(response => {
            self.items = response.data.data
          });
        this.$parent.draw = false;
        self.loading = false;
      },
    },
    computed: {
      filteredList() {
        let self = this;
        return self.items.filter((val) => {
          return val['name'].toLowerCase().search(self.filter.toLowerCase()) > -1
        });
      },
      query() {
        return {
          sort_by: this.sortBy,
          sort_desc: this.sortDesc,
          page: this.currentPage,
          search_query: this.filter,
          limit: this.perPage
        };
      }
    },
    watch: {
      draw(state) {
        if (state) {
          this.fetchData();
        }
      }
    },
  }
</script>

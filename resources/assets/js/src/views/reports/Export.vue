<template>
    <div class="animated fadeIn">
        <b-card header-tag="header">
            <h6 slot="header" class="mb-0">
                <i class='fa fa-align-justify'></i> Export To Excel
            </h6>
            <b-link href="/api/appraise/report">
                <b-button type="button" v-b-toggle.sessionForm variant="primary">
                    <i class="fa fa-download"></i>
                    Export Formatted Report
                </b-button>
            </b-link>
            <b-link href="/api/appraise/report-all">
                <b-button type="button" v-b-toggle.sessionForm variant="primary">
                    <i class="fa fa-download"></i>
                    Export Not Formatted Report
                </b-button>
            </b-link>
        </b-card>
    </div>
</template>
<script>
  import {getReports} from "../../actions/ReportsActions";

  export default {
    data() {
      return {
        reportsData: []
      }
    },
    mounted() {
      this.fetchReports();
    },
    methods: {
      fetchReports() {
        window.open('/api/appraise/report', '_blank');
      }
    }
  }
</script>
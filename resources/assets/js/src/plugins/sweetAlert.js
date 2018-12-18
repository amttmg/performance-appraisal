import swal from 'sweetalert';

const sweetAlert = {
  install(Vue, options) {

    Vue.prototype.$confirmDelete = function(options) {
      let defaultSettings = {
        title: "Are you sure ?",
        text: "Once deleted, you will not be able to recover!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      };
      let finalSettings = {...defaultSettings, ...options};
      return swal(finalSettings);
    };
    Vue.prototype.$confirm = function(options) {
      let defaultSettings = {
        title: "Are you sure ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      };
      let finalSettings = {...defaultSettings, ...options};
      return swal(finalSettings);
    };
    Vue.prototype.$confirmSuccess = function(options) {
      console.log(options);
      let defaultSettings = {
        text: "Delete Successfully!",
        icon: "success",
      };
      let finalSettings = {...defaultSettings, ...options};
      return swal(finalSettings);
    };

    Vue.prototype.$confirmError = function(options) {
      let defaultSettings = {
        text: "Oops something went wrong!",
        icon: "error",
      };
      let finalSettings = {...defaultSettings, ...options};
      return swal(finalSettings);
    };

    Vue.prototype.$confirmWarning = function(options) {
      let defaultSettings = {
        text: "Did you forget to select ?",
        icon: "warning",
      };
      let finalSettings = {...defaultSettings, ...options};
      return swal(finalSettings);
    }
  }
};

export default sweetAlert;

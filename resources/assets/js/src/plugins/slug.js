const slug = {
  install(Vue, options) {
    Vue.prototype.$slug = function(str) {
      //replace all special characters | symbols with a space
      str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();

      // trim spaces at start and end of string
      str = str.replace(/^\s+|\s+$/gm, '');

      // replace space with dash/hyphen
      str = str.replace(/\s+/g, '-');

      return str;
    }
  }
};

export default slug;

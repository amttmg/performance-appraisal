const StripTags = {
  install(Vue, options) {
    Vue.prototype.$htmlStripTags = function(text) {
      let regex = /(<([^>]+)>)/ig;
      return text.replace(regex, "");
    }
  }
};

export default StripTags;

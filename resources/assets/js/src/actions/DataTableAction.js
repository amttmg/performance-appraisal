import {get, post} from '../helper/helper'

const fetchData = (url,query) => {
  return get(url, query);
};

export {
  fetchData,
}
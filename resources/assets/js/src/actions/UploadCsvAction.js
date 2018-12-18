import {get, post} from '../helper/helper'

const uploadCsv = (file, url) => {
  return post(url, file);
};

export {
  uploadCsv,
}

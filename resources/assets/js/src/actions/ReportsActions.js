'use strict';

import {deleteRecord, get, post} from '../helper/helper'

const getReports = () => {
  return get('appraise/report');
};

const uploadReport = (formData) => {
  return post('/appraise/report-upload', formData);
};

const deleteReport = id => {
  return get('/appraise/report-delete/' + id)
};


export {
  getReports,
  uploadReport,
  deleteReport,
}

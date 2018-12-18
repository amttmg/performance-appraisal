'use strict';

import {get, post, deleteRecord} from '../helper/helper'

const getAppraise = () => {
  return get('get-appraise-assigned');
};

const getQuestions = (appraiseId) => {
  return get('get-questions/' + appraiseId)
};

const saveAnswers = (answers, strengthVsWeakness, appraise) => {
  return post('appraise/save', {answers, strengthVsWeakness, appraise});
};

const saveAppraise = (appraise) => {
  return post('appraise', appraise);
};
const saveSupervisorAppraise = (supervisor, employees) => {
  return post('appraise/supervisor', {supervisor, employees})
};

const getAllAppraise = (sessionId, technologyId) => {
  let query = 'appraise/?';
  if (sessionId) {
    query += 'session_id=' + sessionId + '&';
  }
  query += 'technology_id=' + technologyId;
  return get(query);
};
const getEmployeeDetail = (employee) => {
  return get('appraise/employee-detail/' + employee);
};
const deleteAppraise = (id) => {
  return deleteRecord('appraise/' + id);
};

const resetAppraise = (id) => {
  return get('appraise/reset/' + id);
};

const getEvaluations = () => {
  return get('evaluations/get');
};

export {
  deleteAppraise,
  saveSupervisorAppraise,
  getAllAppraise,
  getAppraise,
  getQuestions,
  saveAnswers,
  saveAppraise,
  resetAppraise,
  getEmployeeDetail,
  getEvaluations
}

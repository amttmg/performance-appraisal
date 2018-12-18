import {deleteRecord, get, post, patch} from '../helper/helper'

const getQuestions = () => {
  return get('question');
};
const storeQuestion = (data) => {
  return post('question', data);
};
const updateQuestion = (id, data) => {
  return patch('question/' + id, data);
};
const deleteQuestions = (id) => {
  return deleteRecord('question/' + id)
};

export {
  getQuestions,
  storeQuestion,
  deleteQuestions,
  updateQuestion
}

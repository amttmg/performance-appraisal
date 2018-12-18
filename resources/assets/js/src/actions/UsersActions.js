import {get, post, deleteRecord} from '../helper/helper'

const fetchEmployee = () => {
  return get('users');
};
const fetchUsersForDropDown = () => {
  return get('users/select-data');
};
const setNewPassword = (id = null) => {
  if (id) {
    return post('users/set-new-password/' + id);
  }
  return post('users/set-new-password');
};

const importEmployee = (file) => {
  return post('users', file);
};
const deleteEmployee = (id) => {
  return deleteRecord('users/' + id);
};
const getSelf = () => {
  return get('users/self');
};

const fetchEmployeeByTechnology = (technologyId) => {
  return get('users/technology/' + technologyId);
};

const fetchEmployeeWithReport = () => {
  return get('users/with-report');
};

export {
  fetchEmployee,
  fetchEmployeeWithReport,
  importEmployee,
  deleteEmployee,
  getSelf,
  fetchUsersForDropDown,
  setNewPassword,
  fetchEmployeeByTechnology
}

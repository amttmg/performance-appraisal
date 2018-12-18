import {get, post, deleteRecord} from '../helper/helper'

const getProjects = (page) => {
  return get('projects?page=' + page);
};

const storeProjectFromCsv = (file,) => {
  return post('projects', file);
};
const deleteProject = (id) => {
  return deleteRecord('projects/' + id);
};

const linkProjectEmployee = (employeeId, projects) => {
  return post('projects/link', {employeeId, projects});
};

const getUserProjects = (technologyId) => {
  return get('projects/get-projects/' + technologyId);
};

const unLinkProject = (id) => {
  return post('projects/unlink/' + id);
};
export {
  getProjects,
  getUserProjects,
  storeProjectFromCsv,
  deleteProject,
  linkProjectEmployee,
  unLinkProject
}

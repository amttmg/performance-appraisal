import {get, post, patch} from '../helper/helper'

const getSession = () => {
  return get('session');
};

const changeState = (id, data) => {
  return patch('session/change-state/' + id, data);
};

const storeSession = (data) => {
  return post('session', data);
};

export {
  getSession,
  storeSession,
  changeState
}

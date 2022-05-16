class Auth {

  login(user, id) {
    localStorage.setItem('user', user);
    localStorage.setItem('user_id', id);
  }

  logout() {
    localStorage.clear();
  }

  isAuthenticated() {
    if (localStorage.getItem('user')!=null && localStorage.getItem('user_id')!=null){
      return true
    }
    return false;
  }

}

export default new Auth();
import axios from "axios";
// import router from "./router/router.js";
// import constants from "./utilis/constants.js";
class Auth {
  constructor() {
    console.log("authorization");
    this.token = window.localStorage.getItem("token");
    let userData = window.localStorage.getItem("user");

    console.log("Raw user data:", userData);

    if (userData === "undefined") {
        window.localStorage.removeItem("token");
        window.localStorage.removeItem("user");
        window.location.href = "login";
    } else {
        this.user = userData ? JSON.parse(userData) : null;
        console.log("Parsed user object:", this.user);
    }
}

  login(token, user) {
    console.log("ligin");
    console.log(token,user);
    window.localStorage.setItem("token", token);
    window.localStorage.setItem("user", JSON.stringify(user));

    this.token = token;
    this.user = user;
  }

  logout() {
    window.localStorage.removeItem("token");
    window.localStorage.removeItem("user");
    this.user = null;
    // router.push({ name: "Index" });
  }

  check() {
    if (
      window.localStorage.getItem("token") === null ||
      window.localStorage.getItem("token") === "undefined"
    ) {
      if (this.user != null && this.user.email_verified_at == null) {
        window.localStorage.removeItem("deviceToken");
        window.localStorage.removeItem("token");
        window.localStorage.removeItem("user");
        this.user = null;

        return false;
      }

      window.localStorage.removeItem("token");
      window.localStorage.removeItem("user");
      this.user = null;

      return false;
    }

    return true;
  }

  getToken() {
    return this.token;
  }

  getUser() {
    return this.user;
  }

  setUser(user) {
    window.localStorage.setItem("user", JSON.stringify(user));
    this.user = user;
  }

  getUserRole() {
    if (!this.user) {
        console.warn("User object is null or undefined.");
        return null;
    }
    if (!this.user.role) {
        console.warn("Role is missing in the user object.");
        return null;
    }

    return this.user.role;
    
}

  isDriver() {
    return this.getUserRole() === constants.USER_ROLE.driver ? true : false;
  }

  isUser() {
    return this.getUserRole() === constants.USER_ROLE.user ? true : false;
  }

  isAuthenticated() {
    return !!window.localStorage.getItem("user");
  }
}

export default new Auth();

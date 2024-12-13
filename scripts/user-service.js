function isAuthorized() {
    const cookie = document.cookie;
    const authCookie = cookie
      .split(";")
      .find((cookie) => cookie.includes("PHPSESSID"));
    if (!authCookie) {
      return false;
    }
    return true;
}

function logout(isRedirect = true) {
    document.cookie =
      "PHPSESSID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    if (isRedirect) {
      window.location.href = "../pages/login.php";
    }
}

function automaticLogout() {
    setInterval(() => {
      if (!isAuthorized()) {
        logout(false);
      }
    }, 1000);
}
  
automaticLogout();
  
  
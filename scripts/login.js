document.addEventListener("DOMContentLoaded", function () {
  if (isAuthorized()) {
    window.location.href = "category-list.php";
  }
});

const form = document.querySelector("form");

form.addEventListener("submit", async (e) => {
    e.preventDefault();
  
    const email = form.querySelector("input[name='email']").value;
    const password = form.querySelector("input[name='password']").value;
  
    const response = await fetch("../authorization/login.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({ email, password }),
    });
  
    const data = await response.json();
    const messageDiv = form.querySelector("span[class='error-message']");
    if (data.error) {
      messageDiv.textContent = data.error;
      return;
    }
  });
  
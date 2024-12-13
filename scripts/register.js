const form = document.querySelector("form");
form.addEventListener("submit", handleFormSubmit);

const password = form.querySelector("input[name='password']");
password.addEventListener("input", validatePassword);

const passwordConfirmation = document.querySelector("input[name='password-confirmation'");
passwordConfirmation.addEventListener("input", validatePasswordMatch);

async function handleFormSubmit(e) {
  e.preventDefault();
  if (!validateUserInput()) {
    return handleResult("message", "Invalid input", false);
  }

  const formData = getFormData();
  const errorMessage = validateFormData(formData);

  if (errorMessage) {
    return handleResult("message", errorMessage, false);
  }

  try {
    const response = await submitForm(formData);
    const data = await response.json();

    if (data.error) {
      return handleResult("message", data.error, false);
    }

    if (response.ok) {
      redirectTo("login.php");
    }
  } catch (error) {
    return handleResult("message", "An unexpected error occurred.", false);
  }
}

function validatePassword() {
  const password = this.value;
  const requirements = [
    { message: "Password is too short", isValid: password.length >= 8 },
    { message: "Password must contain 1 uppercase letter", isValid: /[A-Z]/.test(password) },
    { message: "Password must contain 1 lowercase letter", isValid: /[a-z]/.test(password) },
    { message: "Password must contain 1 number", isValid: /\d/.test(password) },
  ];

  const errorContainer = document.querySelector("input[name='password']").nextElementSibling;

  errorContainer.innerHTML = "";

  const failedRequirements = requirements.filter(req => !req.isValid);

  if (failedRequirements.length) {
    failedRequirements.forEach(({ message }) => {
      const error = document.createElement("li");
      error.textContent = message;
      errorContainer.appendChild(error);
    });
  }

  validatePasswordMatch();
}

function validatePasswordMatch() {
  const password = document.querySelector("input[name='password']");
  const passwordConfirmation = document.querySelector("input[name='password-confirmation']");
  const matchError = document.querySelector("input[name='password-confirmation']").nextElementSibling;

  if(!(password === passwordConfirmation)) {
    matchError.textContent = "Passwords do not match"
  }
}

function getFormData() {
  return {
    email: document.querySelector("input[name='email']").value,
    password: document.querySelector("input[name='password']").value,
    passwordConfirmation: document.querySelector("input[name='password-confirmation']").value,
  };
}

function validateFormData({ password, passwordConfirmation }) {
    if (password.length < 8) {
      return "Password must be at least 8 characters long.";
    }
  
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/;
    if (!passwordRegex.test(password)) {
      return "Password must contain 1 uppercase letter, 1 lowercase letter, and 1 number.";
    }
  
    if (password !== passwordConfirmation) {
      return "Passwords do not match.";
    }
  
    return null;
}
  
async function submitForm({ email, password }) {
    return fetch("../authorization/register.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({ password, email }),
    });
}    
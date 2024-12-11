const form = document.querySelector("form");

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = getFormData();
    const errorMessage = validateFormData(formData);

    if (errorMessage) {
        return handleError(errorMessage, "form");
    } 
    
    try {
        const response = await submitForm(formData);
        const data = await response.json();
  
        if (data.error) {
          return handleError(data.error, "form");
        }
  
        window.location.href = "login.php";
    } catch (error) {
        handleError("An unexpected error occurred.", "form");
    }
});

const password = form.querySelector("input[name='password']");

passwordInput.addEventListener("input", function () {
    const passwordValue = this.value;
    const passwordConfirmationValue = document.querySelector("input[name='password-confirmation'").value;

    // Add check password length

    // Add check uppercase letter

    // Add check lowercase letter

    // Add check number

    // Add check password match
});

function getFormData() {
    return {
      email: document.querySelector("input[name='email'").value,
      password: document.querySelector("input[name='password'").value,
      passwordConfirmation: document.querySelector("input[name='password-confirmation'").value,
    };
}

function validateFormData({ password, passwordConfirmation }) {
    if (password.length < 8) {
      return "Password must be at least 8 characters long.";
    }
  
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/;
    if (!passwordRegex.test(password)) {
      return "Password must contain at least one uppercase letter, one lowercase letter, and one number.";
    }
  
    if (password !== passwordConfirmation) {
      return "Passwords do not match.";
    }
  
    return null;
}
  
async function submitForm({ email, password }) {
    return fetch("./authorization/register.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({ password, email }),
    });
}    
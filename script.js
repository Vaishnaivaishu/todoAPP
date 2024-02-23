document.addEventListener("DOMContentLoaded", function() {
    const usernameInput = document.querySelector('input[name="username"]');
    const emailInput = document.querySelector('input[name="email"]');
    const passwordInput = document.querySelector('input[name="password"]');
    const usernameError = document.getElementById("username-error");
    const emailError = document.getElementById("email-error");
    const passwordError = document.getElementById("password-error");

    usernameInput.addEventListener("keyup", function() {
        const username = this.value;
        if (username.length < 8 || !/^(?=.*[A-Z])(?=.*[a-z])(?=.*[^a-zA-Z0-9])(?=.*\d).{8,}$/.test(username)) {
            usernameError.textContent = "Username must be at least 8 characters and can contain 1 Uppercase,Special Character,Digit.";
        } else {
            usernameError.textContent = "";
        }
    });

    emailInput.addEventListener("keyup", function() {
        const email = this.value;
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            emailError.textContent = "Invalid email address.";
        } else {
            emailError.textContent = "";
        }
    });

    passwordInput.addEventListener("keyup", function() {
        const password = this.value;
        if (password.length < 8 || !/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/.test(password)) {
            passwordError.textContent = "Password must be at least 8 characters long and contain at least one letter and one digit.";
        } else {
            passwordError.textContent = "";
        }
    });
});


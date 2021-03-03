function showPassword() {
    let passwordField = document.getElementById("passwordInput");
    if (passwordField.type === "password") {
        passwordField.type = "text";
    } else {
        passwordField.type = "password";
    }
}
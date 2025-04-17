function validateRegisterForm() {
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    if (username.length < 3) {
        alert("Username must be at least 3 characters long.");
        return false;
    }
    if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        return false;
    }
    return true;
}
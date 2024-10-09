function handleUserTypeChange() {
    var userType = document.getElementById("user_type").value;
    var emailField = document.getElementById("admin_email");

    // Show the email field only if admin is selected
    if (userType === "admin") {
        emailField.style.display = "block";
    } else {
        emailField.style.display = "none";
    }
}

// handles the form submission when the user submits the form.
function handleSubmit(event) {
    event.preventDefault();
    var userType = document.getElementById("user_type").value;
    var email = document.getElementById("email").value;

    if (userType === "user") {
        window.location.href = "home.html"; // go to this page
    } else if (userType === "admin") {
        // Check if email field is filled and validate email on the server
        if (email) {
            document.getElementById("user_form").submit(); // Submit the form if email is true
        } else {
            alert("Please enter your email.");
        }
    } else {
        alert("Please select a user type.");
    }
}
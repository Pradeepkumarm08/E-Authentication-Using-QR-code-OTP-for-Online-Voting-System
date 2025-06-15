document.getElementById("signup-form").addEventListener("submit", function(event) {
    event.preventDefault();

    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const terms = document.getElementById("terms").checked;

    if (!terms) {
        alert("Please agree to the terms and conditions.");
        return;
    }

    console.log("Sign Up Details:", { name, email, password });

    alert("Sign up successful!");
    this.reset();
});

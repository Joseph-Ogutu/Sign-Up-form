document.getElementById('signInButton').addEventListener('click', function() {
    document.getElementById('signup').style.display = 'none';
    document.getElementById('signIn').style.display = 'block';

    const signInPasswordField = document.getElementById('signInPassword');
    const signInShowPasswordCheckbox = document.getElementById('signInShowPassword');

    signInShowPasswordCheckbox.addEventListener('click', function() {
        console.log('Show password checkbox clicked');
        if (signInShowPasswordCheckbox.checked) {
            console.log('Showing password');
            signInPasswordField.type = 'text';
        } else {
            console.log('Hiding password');
            signInPasswordField.type = 'password';
        }
    });
});

document.getElementById('signUpButton').addEventListener('click', function() {
    document.getElementById('signIn').style.display = 'none';
    document.getElementById('signup').style.display = 'block';

    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('confirmPassword');
    const showPasswordCheckbox = document.getElementById('showPassword');
    const passwordStrengthIndicator = document.getElementById('password-strength');

    showPasswordCheckbox.addEventListener('click', function() {
        if (showPasswordCheckbox.checked) {
            passwordField.type = 'text';
            confirmPasswordField.type = 'text';
        } else {
            passwordField.type = 'password';
            confirmPasswordField.type = 'password';
        }
    });

    passwordField.addEventListener('input', function() {
        checkPasswordStrength(passwordField.value, passwordStrengthIndicator);
        confirmPasswordField.value = passwordField.value; // Mirror password input to confirm password input
    });
});

function checkPasswordStrength(password, strengthIndicator) {
    let strength = 0;

    // Check for length
    if (password.length >= 8) {
        strength++;
    }

    // Check for uppercase letters
    if (/[A-Z]/.test(password)) {
        strength++;
    }

    // Check for lowercase letters
    if (/[a-z]/.test(password)) {
        strength++;
    }

    // Check for numbers
    if (/\d/.test(password)) {
        strength++;
    }

    // Check for special characters
    if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
        strength++;
    }

    // Update the password strength indicator
    switch (strength) {
        case 1:
            strengthIndicator.textContent = 'Weak';
            strengthIndicator.style.color = 'red';
            break;
        case 2:
            strengthIndicator.textContent = 'Medium';
            strengthIndicator.style.color = 'orange';
            break;
        case 3:
            strengthIndicator.textContent = 'Strong';
            strengthIndicator.style.color = 'green';
            break;
        case 4:
            strengthIndicator.textContent = 'Very Strong';
            strengthIndicator.style.color = 'green';
            break;
        case 5:
            strengthIndicator.textContent = 'Extremely Strong';
            strengthIndicator.style.color = 'green';
            break;
        default:
            strengthIndicator.textContent = '';
    }
}
document.getElementById('forget-password-btn').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default link behavior

    // Get the email address or username from the input field
    var emailInput = document.getElementById('email-input');
    var email = emailInput.value.trim();

    // Basic email validation
    if (!email.match(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/)) {
        console.error('Invalid email address');
        return;
    }

    // Send AJAX request to PHP script
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'forget-password.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('email=' + encodeURIComponent(email));

    // Handle response from PHP script
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log('Password reset email sent successfully!');
        } else {
            console.error('Error sending password reset email:', xhr.statusText);
            try {
                var response = JSON.parse(xhr.responseText);
                console.error(response.error); // Display error message from PHP script
            } catch (e) {
                console.error('Error parsing response:', e);
            }
        }
    };
});
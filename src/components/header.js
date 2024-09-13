document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');
    const verifyForm = document.getElementById('verify-form');
    const registerForm = document.getElementById('register-form');
    const switchToVerify = document.getElementById('switch-to-verify');
    const switchToLogin = document.getElementById('switch-to-login');

    // Switch to verify form
    switchToVerify.addEventListener('click', (event) => {
        event.preventDefault();
        loginForm.classList.add('hidden');
        verifyForm.classList.remove('hidden');
    });

    // Switch to register form
    document.getElementById('switch-to-register').addEventListener('click', (event) => {
        event.preventDefault();
        checkStudentId(event); // Ensure this is only called if the ID is valid
    });

    // Switch to login form
    switchToLogin.addEventListener('click', (event) => {
        event.preventDefault();
        registerForm.classList.add('hidden');
        loginForm.classList.remove('hidden');
    });

    // Handle form submission for registration
    registerForm.addEventListener('submit', (event) => {
        event.preventDefault();
        // Handle registration logic here
    });
});

function checkStudentId(event) {
event.preventDefault(); // Prevent form from submitting normally

const studentId = document.getElementById('student_id').value;

// Check student ID via AJAX
fetch('check_student_id.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: new URLSearchParams({
        'student_id': studentId
    })
})
.then(response => response.json())
.then(data => {
    if (data.valid) {
        document.getElementById('verify-form').classList.add('hidden');
        document.getElementById('register-form').classList.remove('hidden');
    } else {
        alert('Invalid Student ID');
    }
})
.catch(error => console.error('Error:', error));
}

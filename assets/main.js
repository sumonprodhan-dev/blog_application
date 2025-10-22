const passwordInput = document.getElementById('password');
const eye1 = document.getElementById('eye1');

eye1.addEventListener('click', function () {
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        this.innerHTML = '<i class="bi bi-eye"></i>';
    } else {
        passwordInput.type = 'password';
        this.innerHTML = '<i class="bi bi-eye-slash"></i>';
    }
});

const confirmPasswordInput = document.getElementById('confirm_password');
const eye2 = document.getElementById('eye2');

eye2.addEventListener('click', function () {
    if (confirmPasswordInput.type === 'password') {
        confirmPasswordInput.type = 'text';
        this.innerHTML = '<i class="bi bi-eye"></i>';
    } else {
        confirmPasswordInput.type = 'password';
        this.innerHTML = '<i class="bi bi-eye-slash"></i>';
    }
});


// const menuToggle = document.getElementById('menuToggle');
// const sidebar = document.getElementById('sidebar');

// menuToggle.addEventListener('click', function () {
//     sidebar.classList.toggle('show');

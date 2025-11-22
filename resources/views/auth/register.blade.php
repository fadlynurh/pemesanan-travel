@extends('layouts.app')


<div class="row justify-content-center">
    <div class="col-md-6">
        <h3>Register</h3>
        <div id="alert"></div>
        <form id="registerForm">
            <div class="mb-2"><label>Name</label><input class="form-control" id="name" required></div>
            <div class="mb-2"><label>Email</label><input class="form-control" id="email" type="email" required></div>
            <div class="mb-2"><label>Phone</label><input class="form-control" id="phone"></div>
            <div class="mb-2"><label>Password</label><input class="form-control" id="password" type="password" required></div>
            <div class="mb-2"><label>Confirm Password</label><input class="form-control" id="password_confirmation" type="password" required></div>
            <button class="btn btn-success">Register</button>
        </form>
    </div>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', function(e){
    e.preventDefault();
    const payload = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        password: document.getElementById('password').value,
        password_confirmation: document.getElementById('password_confirmation').value,
    };
    axios.post('/api/register', payload)
    .then(res=>{
        alert('Registrasi sukses. Silakan login.');
        window.location.href = '/login';
    }).catch(err=>{
        document.getElementById('alert').innerHTML = '<div class="alert alert-danger">Gagal mendaftar. Periksa input.</div>';
    });
});
</script>


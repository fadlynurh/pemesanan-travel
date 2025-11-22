@extends('layouts.app')


<div class="row justify-content-center">
    <div class="col-md-6">
        <h3>Login</h3>
        <div id="alert"></div>
        <form id="loginForm">
            <div class="mb-2">
                <label>Email</label>
                <input class="form-control" id="email" type="email" required>
            </div>
            <div class="mb-2">
                <label>Password</label>
                <input class="form-control" id="password" type="password" required>
            </div>
            <button class="btn btn-primary">Login</button>
        </form>
        <p class="mt-3">Belum punya akun? <a href="/register">Daftar</a></p>
    </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e){
    e.preventDefault();
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    axios.post('/api/login',{email,password})
    .then(res=>{
        localStorage.setItem('token', res.data.token);
        // show logout button if present
        const btn = document.getElementById('btnLogout');
        if (btn) btn.style.display = 'inline-block';
        window.location.href = '/dashboard';
    }).catch(err=>{
        const a = document.getElementById('alert');
        a.innerHTML = '<div class="alert alert-danger">Login gagal. Periksa kredensial.</div>';
    });
});
</script>


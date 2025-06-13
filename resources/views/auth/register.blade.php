<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

    <title>Registration</title>
</head>
<body>
    <section class="container mt-3">
        <div class="position-absolute top-50 start-50 translate-middle shadow-lg p-5">
            <h2 class="fw-bold text-center mb-3">Sign Up</h2>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Name :</label>
                    <input type="text" name="name" class="form-control">
                    @error('name') <div class="alert alert-danger">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Email :</label>
                    <input type="email" name="email" class="form-control">
                    @error('email') <div class="alert alert-danger">{{ $message }}</div> @enderror
                </div><div class="mb-3">
                    <label class="form-label">Password :</label>
                    <input type="password" name="password" class="form-control">
                    @error('password') <div class="alert alert-danger">{{ $message }}</div> @enderror
                </div><div class="mb-3">
                    <label class="form-label">Password Confirmation :</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                <div class="d-flex align-items-center justify-content-end gap-2">
                    <a href="{{ url('login') }}" class="link-dark link-opacity-50-hover me-2 text-sm">Already have an account?</a>
                    <button class="btn btn-primary fw-bold" type="submit">Sign up</button>
                </div>
                <div class="text-center mt-2">

                </div>
            </form>
        </div>
    </section>
</body>
</html>

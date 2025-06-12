<section>
    <header>
        <nav class="navbar bg-dark" data-bs-theme="dark">
            <div class="container-fluid">
                <div class="navbar-brand">
                    <a href="{{ url('/student') }}" class="fw-bold navbar-brand">HOME</a>
                    <a href="{{ url('/student/trash') }}" class="btn"><img src="{{ asset('recycle.png') }}" width="35" height="35">Trashed</a>
                </div>
                <form class="d-flex justify-center" >
                    <input type="search" placeholder="SEARCH" id="search" name="search" class="form-control me-2">
                </form>
                <a href="{{ url('logout') }}" class="btn btn-primary">Logout</a>
            </div>
        </nav>
    </header>
</section>

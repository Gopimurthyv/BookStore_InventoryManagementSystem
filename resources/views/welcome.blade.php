<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">

        <section class="container">
            <div class="flex items-center justify-end w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
                <header >
                        <div class="bg-black p-3 text-end">
                            <a href="{{ route('login') }}" class="btn btn-outline-dark text-white btn-primary fw-bold me-2">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-primary btn-outline-dark text-white fw-bold">Register</a>
                        </div>
                </header>
            </div>
            <main class="flex item-center justify-center">
                    <div class="px-4 py-5 my-5 text-center">
                        <img class="d-block mx-auto mb-4" src="{{ asset('deve_11zon.png') }}" width="150" height="150">
                        <h1 class="display-5 fw-bold text-body-emphasis">Book Store - Inventory Management System</h1>
                        <div class="col-lg-6 mx-auto">
                            <p class="lead mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem hic possimus repudiandae accusantium quas veritatis beatae iusto sunt quod, pariatur voluptate unde quidem ducimus eius explicabo eos aliquid dignissimos non!. Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut et est inventore maxime consectetur natus deserunt quam. Natus laborum, id, nam ut corrupti consectetur voluptatum saepe nisi, obcaecati harum explicabo?</p>
                        </div>
                    </div>
            </main>
        </section>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>

<!DOCTYPE html>

<title>Laravel Demo</title>
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

<style>
    html {
        scroll-behavior: smooth;
    }

    .clamp {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .clamp.one-line {
        -webkit-line-clamp: 1;
    }
</style>

<body style="font-family: Open Sans, sans-serif">
    <section class="px-6 py-8">
        <nav class="md:flex md:justify-between md:items-center">
            <div class="mt-8 md:mt-4 flex items-center">

                <a href="api/todo-lists/create" :active="request()->is('todo-lists.create')" class="font-bold">
                    New TodoList
                </a>

                @auth
                <a href="#" x-data="{}" @click.prevent="document.querySelector('#logout-form').submit()" class="ml-5 font-bold">
                    Log Out
                </a>
                @endauth
                <form id="logout-form" method="POST" action="/logout" class="hidden">
                    @csrf
                </form>

                <a href="api/register" class="ml-6 text-xs font-bold uppercase {{ request()->is('register') ? 'text-blue-500' : '' }}">
                    Register
                </a>

                <a href="api/login" class="ml-6 text-xs font-bold uppercase {{ request()->is('login') ? 'text-blue-500' : '' }}">
                    Log In
                </a>

            </div>
        </nav>

    </section>


</body>
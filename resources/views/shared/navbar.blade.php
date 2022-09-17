<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">{{ env('APP_NAME') }}</a>
        <form class="d-flex" role="search" method="GET" action="/search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="s" value="{{ Request::get('s') }}">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>
</nav>

<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">{{ env('APP_NAME') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <form class="d-flex" role="search" method="GET" action="/search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="s" value="{{ Request::get('s') }}">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>
</nav>

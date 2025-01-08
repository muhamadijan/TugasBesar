<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">Manajemen App</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <!-- Akun Pengguna: Hanya untuk Owner -->
                @if(auth()->user()->role === 'owner')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">Akun Pengguna</a>
                    </li>
                @endif

                <!-- Stores: Untuk Owner dan Manager -->
                @if(auth()->user()->role === 'owner')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('stores.index') }}">Stores</a>
                    </li>
                @endif

                <!-- Transactions: Untuk Owner, Manager, dan Kasir -->
                @if(in_array(auth()->user()->role, ['owner', 'manager', 'cashier']))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('transactions.index') }}">Transactions</a>
                    </li>
                @endif

                <!-- Products: Untuk Owner dan Manager -->
                @if(in_array(auth()->user()->role, ['owner', 'manager', 'warehouse_staff']))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                    </li>
                @endif

                <!-- Audit Logs: Hanya untuk Owner -->
                @if(auth()->user()->role === 'owner')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('audit_logs.index') }}">Audit Logs</a>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="#">Halo, {{ auth()->user()->name }}</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link" style="text-decoration: none;">Keluar</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

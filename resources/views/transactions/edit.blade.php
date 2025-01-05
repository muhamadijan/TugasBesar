@extends('layouts.akun')

@section('content')
<div class="container">
    <h2>Edit Transaksi #{{ $transaction->transaction_code }}</h2>

    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="store_id" class="form-label">Toko</label>
            <select name="store_id" id="store_id" class="form-control" required>
                @foreach ($stores as $store)
                    <option value="{{ $store->id }}" {{ $store->id == $transaction->store_id ? 'selected' : '' }}>
                        {{ $store->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Kasir</label>
            <select name="user_id" id="user_id" class="form-control" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $transaction->user_id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div id="products-container" class="mb-3">
            <label for="products" class="form-label">Produk</label>
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Kuantitas</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody id="product-rows">
                    @foreach ($transaction->products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>
                            <input type="hidden" class="product-price" value="{{ $product->price }}">
                            {{ number_format($product->price, 2) }}
                        </td>
                        <td>
                            <input type="number" class="product-quantity form-control" name="quantity[{{ $product->id }}]" min="0" value="{{ $product->pivot->quantity }}" data-product-id="{{ $product->id }}">
                        </td>
                        <td class="product-subtotal">
                            Rp {{ number_format($product->pivot->quantity * $product->price, 2, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mb-3">
            <label for="total_amount" class="form-label">Total</label>
            <input type="number" name="total_amount" id="total_amount" class="form-control" value="{{ $transaction->total_amount }}" readonly>
        </div>

        <div class="mb-3">
            <label for="transaction_date" class="form-label">Tanggal</label>
            <input type="date" name="transaction_date" id="transaction_date" class="form-control" value="{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('Y-m-d') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Perbarui Transaksi</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const quantityInputs = document.querySelectorAll('.product-quantity');
        const totalAmountInput = document.getElementById('total_amount');

        // Fungsi untuk menghitung subtotal dan total transaksi
        function calculateTotal() {
            let total = 0;

            document.querySelectorAll('.product-quantity').forEach(input => {
                const quantity = parseFloat(input.value) || 0;
                const price = parseFloat(input.closest('tr').querySelector('.product-price').value);
                const subtotal = quantity * price;

                input.closest('tr').querySelector('.product-subtotal').textContent = 'Rp ' + subtotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); // Format subtotal
                total += subtotal;
            });

            totalAmountInput.value = total.toFixed(2); // Format total transaksi
        }

        // Menambahkan event listener untuk input kuantitas
        quantityInputs.forEach(input => {
            input.addEventListener('input', calculateTotal); // Hitung ulang total saat kuantitas berubah
        });

        // Memastikan total dihitung saat halaman pertama kali dimuat
        calculateTotal();
    });
</script>
@endsection

@extends('layouts.admin')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h2>Tambah Transaksi</h2>
        </div>

        <div class="section-body">
            <form action="{{ route('transactions.store') }}" method="POST" id="transaction-form">
                @csrf

                <!-- Toko Field -->
                <div class="mb-3">
                    <label for="store_id" class="form-label">Toko</label>
                    <select name="store_id" id="store_id" class="form-control" required>
                        @foreach ($stores as $store)
                            <option value="{{ $store->id }}">{{ $store->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Kasir Field -->
                <div class="mb-3">
                    <label for="user_id" class="form-label">Kasir</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="" disabled selected>Pilih Kasir</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Produk Table -->
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
                            @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" class="product-checkbox">
                                        {{ $product->name }}
                                    </td>
                                    <td>
                                        <input type="hidden" class="product-price" value="{{ $product->price }}">
                                        {{ number_format($product->price, 2) }}
                                    </td>
                                    <td>
                                        <input type="number" name="quantity[]" class="product-quantity form-control" min="0" value="0">
                                    </td>
                                    <td class="product-subtotal">0.00</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Total Amount Field -->
                <div class="mb-3">
                    <label for="total_amount" class="form-label">Total</label>
                    <input type="number" name="total_amount" id="total_amount" class="form-control" readonly>
                </div>

                <!-- Transaction Date Field -->
                <div class="mb-3">
                    <label for="transaction_date" class="form-label">Tanggal</label>
                    <input type="date" name="transaction_date" id="transaction_date" class="form-control" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-success" id="submit-btn">Simpan</button>
            </form>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const quantityInputs = document.querySelectorAll('.product-quantity');
        const totalAmountInput = document.getElementById('total_amount');

        // Function to calculate total amount and update subtotal
        function calculateTotal() {
            let total = 0;

            document.querySelectorAll('.product-quantity').forEach(input => {
                const quantity = parseFloat(input.value) || 0;
                const price = parseFloat(input.closest('tr').querySelector('.product-price').value);
                const subtotal = quantity * price;

                input.closest('tr').querySelector('.product-subtotal').textContent = subtotal.toFixed(2);
                total += subtotal;
            });

            totalAmountInput.value = total.toFixed(2);
        }

        // Add event listener for quantity changes
        quantityInputs.forEach(input => {
            input.addEventListener('input', calculateTotal);
        });

        // Calculate total on initial load
        calculateTotal();
    });
</script>
@endsection

@extends('base.main')
@section('content')
    <div class="page-title">
        <div class="row m-3">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 id="title">Add Barang Masuk</h3>
            </div>
        </div>
    </div>
    @if (session()->has('error'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <form action="/barang_masuk/store" method="POST">
                @csrf
                <div class="form-group col-8">
                    <label>Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk"
                        class="form-control @error('tanggal_masuk') is-invalid @enderror" id="tanggal_masuk"
                        placeholder="Tanggal Masuk" value="{{ old('tanggal_masuk') ?? date('Y-m-d') }}">
                    @error('tanggal_masuk')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-8">
                    <label>Nama Barang</label>
                    <select class="form-select" name="merk_barang" id="merk_barang">
                        @foreach ($merkBarang as $item)
                            <option value="{!! $item !!}">{!! $item !!}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="form-group col-8">
                    <label>Ukuran Barang (ml)</label>
                    <select class="form-select" name="ukuran" id="ukuran">
                    </select>
                </div> --}}
                <div class="form-group col-8">
                    <label>Nama Supplier</label>
                    <select class="form-select" name="kode_supplier" id="kode_supplier">
                        @foreach ($suppliers as $supplier)
                            <option value="{!! $supplier->kode_supplier !!}">{!! $supplier->nama_supplier !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-8">
                    <label>Jumlah Barang</label>
                    <input type="number" min="0" name="jumlah_barang"
                        class="form-control @error('jumlah_barang') is-invalid @enderror" id="jumlah_barang"
                        placeholder="Jumlah Barang" value="{{ old('jumlah_barang') }}">
                    @error('jumlah_barang')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-8">
                    <label>Harga Beli</label>
                    <input type="number" name="harga_satuan" min="0"
                        class="form-control @error('harga_satuan') is-invalid @enderror" id="harga_satuan"
                        placeholder="Harga Satuan" value="{{ old('harga_satuan') }}">
                    @error('harga_satuan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-8">
                    <label>Total Harga</label>
                    <input type="number" name="total_harga" class="form-control @error('total_harga') is-invalid @enderror"
                        id="total_harga" placeholder="Total Harga" value="{{ old('total_harga') }}" readonly>
                    @error('total_harga')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- <div class="form-group col-8">
                    <label>Tanggal Kadaluwarsa</label>
                    <input type="date" name="expired" class="form-control @error('expired') is-invalid @enderror"
                        id="expired" placeholder="Tanggal Kadaluwarsa" value="{{ old('expired') }}">
                    @error('expired')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div> --}}
                <button type="submit" class="btn btn-success mt-3">Submit</button>
            </form>
        </div>
    </div>

    <script>
        $('#harga_satuan').on('keyup', function(e) {
            var code = e.keyCode || e.which
            var jumlah = $('#jumlah_barang').val()
            var harga = $('#harga_satuan').val()
            var total = jumlah * harga

            $('#total_harga').val(total)
        });



        $(document).ready(function() {
            let merkBarang = $('select[name="merk_barang"]').val();
            if (merkBarang) {
                jQuery.ajax({
                    url: '/merk_barang/' + merkBarang + '/ukuran',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('select[name="ukuran"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="ukuran"]').append(
                                '<option value="' + value + '">' + value +
                                '</option>');
                        });
                    }
                });
            }

            $('select[name="merk_barang"]').on('change', function() {
                merkBarang = $(this).val();
                if (merkBarang) {
                    jQuery.ajax({
                        url: '/merk_barang/' + merkBarang + '/ukuran',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('select[name="ukuran"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="ukuran"]').append(
                                    '<option value="' + value + '">' + value +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="city_origin"]').empty();
                }
            });
        });
    </script>
@endsection

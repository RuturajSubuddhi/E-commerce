@extends('adminPanel.layout.layout')
@section('main_content')
<div class="page-content container-fluid">

    {{-- Forms Side by Side --}}
    <div class="row">
        {{-- Shipping Rate Form --}}
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4>Shipping Rate</h4>
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form method="post" action="{{ route('setting.shipping_rate.update') }}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="form-label">Division</label>
                                <select class="form-select" name="division_id" onchange="districtGet(this)">
                                    <option value="">SELECT DIVISION</option>
                                    @foreach($divisionList as $division)
                                    <option value="{{ $division->id }}" {{ ($shippingCost->division_id ?? '') == $division->id ? 'selected' : '' }}>
                                        {{ $division->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('division_id')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label">District</label>
                                <select class="form-select" name="district_id" id="districtList">
                                    <option value="">SELECT DISTRICT</option>
                                    @foreach($districtList as $district)
                                    @if($district->division_id == ($shippingCost->division_id ?? ''))
                                    <option value="{{ $district->id }}" {{ ($shippingCost->district_id ?? '') == $district->id ? 'selected' : '' }}>
                                        {{ $district->name }}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('district_id')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="form-label">Inside Shipping Costs</label>
                                <input type="number" name="inside_shipping_cost" class="form-control" min="0" value="{{ old('inside_shipping_cost', $shippingCost->inside_price ?? 0) }}">
                                @error('inside_shipping_cost')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label">Outside Shipping Costs</label>
                                <input type="number" name="outside_shipping_cost" class="form-control" min="0" value="{{ old('outside_shipping_cost', $shippingCost->outside_price ?? 0) }}">
                                @error('outside_shipping_cost')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Currency Form --}}
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4>Currency Set</h4>
                    <form method="post" action="{{ route('currency.setting.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="form-label">Country</label>
                                <select name="currency_country" class="form-select" onchange="updateCurrencyData(this)">
                                    <option value="">SELECT COUNTRY</option>
                                    @foreach($currencyList as $item)
                                    <option value="{{ $item->country_name }}"
                                        data-symbol="{{ $item->currency_symbol }}"
                                        data-rate="{{ $item->par_dollar_rate ?? 0 }}"
                                        {{ ($currencyData->country_name ?? '') == $item->country_name ? 'selected' : '' }}>
                                        {{ $item->country_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('currency_country')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label">Currency Symbol</label>
                                <input type="text" name="currency_symbol" id="currency_symbol" class="form-control" value="{{ old('currency_symbol', $currencyData->currency_symbol ?? '') }}">
                                @error('currency_symbol')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="form-label">Par Dollar Rate</label>
                                <input type="number" name="dollar_rate" id="dollar_rate" class="form-control" min="0" step="any" value="{{ old('dollar_rate', $currencyData->par_dollar_rate ?? 0) }}">
                                @error('dollar_rate')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Shipping Rates Table --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4>Shipping Rates List</h4>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Country</th>
                                <th>Division</th>
                                <th>District</th>
                                <th>Inside Price</th>
                                <th>Outside Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($divisionList as $division)
                            @foreach($division->districts as $district)
                            @php
                            $shipping = $district->shippingCosts->first();
                            @endphp
                            <tr>
                                <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                <td>{{ $division->country->name }}</td>
                                <td>{{ $division->name }}</td>
                                <td>{{ $district->name }}</td>
                                <td>{{ $shipping->inside_price ?? '-' }}</td>
                                <td>{{ $shipping->outside_price ?? '-' }}</td>
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')
<script>
    function districtGet(data) {
        let division_id = $(data).val();
        if (division_id) {
            $.ajax({
                url: "{{ url('admin/district/list/get') }}",
                type: "get",
                data: {
                    division_id: division_id
                },
                success: function(response) {
                    $('#districtList').html(response);
                }
            });
        } else {
            $('#districtList').html('<option value="">SELECT DISTRICT</option>');
        }
    }

    function updateCurrencyData(select) {
        let selectedOption = select.options[select.selectedIndex];
        let symbol = selectedOption.getAttribute('data-symbol') || '';
        let rate = selectedOption.getAttribute('data-rate') || 0;

        document.getElementById('currency_symbol').value = symbol;
        document.getElementById('dollar_rate').value = rate;
    }
</script>
@endsection
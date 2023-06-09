@extends('layouts.master')
@section('title','Payment Currency')
@section('sub_page','Currency Setting')
@section('page')
    <a href="{{ route('admin.payment-currency.index')}}">
        Payment Currency
    </a>
@endsection

@section('main-content')
    <section class="content">
        @include('admin.section.flash_message')

        @include('admin.payrollSetting.common.breadcrumb')

        <div class="card">
            <div class="card-body">
                <form class="forms-sample"  action="{{route('admin.payment-currency.save')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="status" class="form-label">Choose Payroll Currency <span style="color: red">*</span> </label>
                            <select class="form-select" id="currency" name="currency"  >
                                <option value="" {{isset($currencyDetail) ? '' : 'selected'}}  disabled>Choose Payroll Currency</option>
                                @foreach(\App\Helpers\PaymentCurrencyHelper::CURRENCY_DETAIL as $key => $value)
                                    <option value="{{$value['id']}}"
                                        {{ (isset($currencyDetail) && ($currencyDetail->code) == $value['code']) ? 'selected': '' }}>

                                        {{$value['symbol']}} ({{$value['name']}} - {{$value['code']}})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection


@section('scripts')

    <script>
        $(document).ready(function () {
            $("#currency").select2({
                placeholder: "Choose Payroll Currency"
            });
        });
    </script>

@endsection









@extends('layouts.master')
@section('title')
فاتورة طلب
@endsection
@section('css')
    <style>
        @media print {
            #print_Button {
                display: none;
            }
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0">فاتورة طلب</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="default-color">الرئيسيه</a></li>
                    <li class="breadcrumb-item active">فاتورة طلب</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection


@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body" id="print">
                    <div class="invoice-header">
                        <h1 class="text-info">رقم الطلب : {{ $order->id }} </h1>
                        <div class="billed-from">
                            <h4>اسم المطعم : {{ $order->restaurant->name }}</h4>
                                <p class="h-5">عنوان المطعم : {{ $order->restaurant->regoin->city->name }}, {{ $order->restaurant->regoin->name }}</p>
                        </div><!-- billed-from -->
                    </div><!-- invoice-header -->
                    <div class="row mg-t-20">
                        <div class="col-md">
                            <h4 class="invoice-info-row"><span>اسم العميل</span> :
                                <span>{{ $order->client->name }}</span>
                            </h4>
                            <p class="h-5">عنوان العميل : {{ $order->address }}</p>
                        </div>
                    </div>
                    <div class="table-responsive mg-t-40">
                        <table class="table table-invoice border text-md-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-left">اسم المنتج</th>
                                    <th class="text-center">الصوره</th>
                                    <th class="text-center">الكميه</th>
                                    <th class="text-center">السعر</th>
                                    <th class="text-left">الملاحظات</th>
                                    <th class="text-center">الاجمالي</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->products as $product )
                                <tr>
                                    <td class="text-center">{{ $loop->index+1 }}</td>
                                    <td class="text-left">{{ $product->name }}</td>
                                    <td class="text-center"><img src="{{ $product->image }}" style="width:50px;height:50px" alt=""></td>
                                    <td class="text-center">{{ $product->pivot->quantity }}</td>
                                    <td class="text-center">{{ $product->pivot->price }} ج.م</td>
                                    <td class="text-left">{{ $product->pivot->notes }}</td>
                                    <td class="text-center">{{ $product->pivot->quantity * $product->pivot->price}} ج.م</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td class="valign-middle" colspan="4">
                                        <div class="invoice-notes">
                                            <label class="main-content-label text-13"></label>
                                        </div><!-- invoice-notes -->
                                    </td>
                                    <td class="text-right">خدمة التوصيل</td>
                                    <td class="text-center" colspan="3">{{ $order->restaurant->delivary_cost }} ج.م</td>
                                </tr>
                                <tr>
                                    <td class="valign-middle" colspan="4">
                                        <div class="invoice-notes">
                                            <label class="main-content-label text-13"></label>
                                        </div><!-- invoice-notes -->
                                    </td>
                                    <td class="text-right">الاجمالي</td>
                                    <td class="text-center" colspan="2">{{ $order->total_cost }} ج.م</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr class="mg-b-40">
                    <button class="btn btn-danger  float-left mt-3 mr-2" id="print_Button" onclick="printDiv()"> <i
                            class="mdi mdi-printer ml-1"></i>طباعة</button>
                </div>
            </div>

        </div>
    </div>

    <!-- row closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script type="text/javascript">
        function printDiv() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
@endsection

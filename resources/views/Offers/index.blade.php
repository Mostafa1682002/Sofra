@extends('layouts.master')
@section('title')
قائمة العروض
@endsection
@section('css')
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">قائمة العروض</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="default-color">الرئيسيه</a></li>
                <li class="breadcrumb-item active">قائمة العروض</li>
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
            <div class="card-body">
                @if (session('success'))
                <div class="alert  alert-success" role="alert">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('success') }}
                </div>
                @endif
                @if ($errors->any())
                <div class="alert  alert-danger" role="alert">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    لم يتم حفظ البيانات
                </div>
                @foreach ($errors->all() as $error)
                <div class="alert  alert-danger" role="alert">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ $error }}
                </div>
                @endforeach
                @endif
                <br><br>
                <div class="table-responsive">
                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50" style="text-align: center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم</th>
                                <th>المطعم</th>
                                <th>الوصف</th>
                                <th>الصوره</th>
                                <th>من</th>
                                <th>الي</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($offers as $offer)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $offer->name }}</td>
                                <td>{{ $offer->restaurant->name }}</td>
                                <td>{{ $offer->discription }}</td>
                                <td>
                                    <img style="width: 50px;height:50px" src="{{ $offer->image }}" alt="">
                                </td>
                                <td>{{ $offer->start_time }}</td>
                                <td>{{ $offer->end_time }}</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{ $offer->id }}" title="حذف"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <!-- delete_modal_Grade -->
                            <div class="modal fade" id="delete{{ $offer->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                                حذف عرض
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('offers.destroy', $offer->id) }}" method="post">
                                                @method('Delete')
                                                @csrf
                                                هل انت متاكد من عملية حذف العرض؟
                                                <br>
                                                <input id="id" type="hidden" name="id" class="form-control" value="{{ $offer->id }}">
                                                <input id="id" type="text" name="name" readonly class="form-control" value="{{ $offer->name }}">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                                    <button type="submit" class="btn btn-danger">حذف</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- row closed -->
@endsection
{{-- @section('js')
@endsection --}}

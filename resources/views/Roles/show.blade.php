@extends('layouts.master')
@section('title')
    عرض صلاحيات الرتبه
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0">عرض صلاحيات الرتبه</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="default-color">الرئيسيه</a></li>
                    <li class="breadcrumb-item active">عرض صلاحيات الرتبه</li>
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
                    <div class="form-row">
                        <div class="col">
                            <h3 for="title"> اسم الرتبه :
                                <span class="text-danger">{{ $role->name }}</span>
                            </h3>
                        </div>
                    </div>
                    <br><br>
                    <div>
                        <h3>
                            الصلاحيات :
                        </h3>
                    </div>
                    <div class="form-row">
                        @if (!empty($rolePermissions))
                            @foreach ($rolePermissions as $permission)
                                <div class="col col-md-3">
                                    <p>{{ $permission->ar_name }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>


    <!-- row closed -->
@endsection
@section('js')
@endsection

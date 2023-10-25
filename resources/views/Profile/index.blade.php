@extends('layouts.master')
@section('title')
    الملف الشخصي
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0"> الملف الشخصي</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="default-color">الرئيسيه</a></li>
                    <li class="breadcrumb-item active"> الملف الشخصي</li>
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
                    <form action="{{ route('profile.update', $profile->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col">
                                <label for="title">الاسم</label>
                                <input type="text" name="name" class="form-control" value="{{ $profile->name }}">
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col">
                                <label for="email">البريد الالكتروني</label>
                                <input type="email" name="email" class="form-control" value="{{ $profile->email }}">
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-row">
                            <div class="col">
                                <label for="title">الباسورد</label>
                                <input type="password" name="password" class="form-control" value="">
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col">
                                <label for="title">تاكيد الباسورد</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" type="submit">تحديث</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- row closed -->
@endsection
@section('js')
@endsection

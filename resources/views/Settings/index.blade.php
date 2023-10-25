@extends('layouts.master')
@section('title')
    الاعدادات
@endsection
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0">الاعدادات</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="default-color">الرئيسيه</a></li>
                    <li class="breadcrumb-item active">الاعدادات</li>
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
                    <form action="{{ route('settings.update',$setting->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col">
                                <label for="title">الهاتف</label>
                                <input type="text" name="phone" class="form-control" value="{{ $setting->phone }}">
                            </div>
                            <div class="col">
                                <label for="title">البريد الالكتروني</label>
                                <input type="email" name="email" class="form-control" value="{{ $setting->email }}">
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col">
                                <label for="f_link">لينك الفيس بوك</label>
                                <input type="text" name="f_link" class="form-control" value="{{ $setting->f_link }}">
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col">
                                <label for="i_link">لينك الانستجرام</label>
                                <input type="text" name="i_link" class="form-control" value="{{ $setting->i_link }}">
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col">
                                <label for="i_link">لينك الواتس اب</label>
                                <input type="text" name="w_link" class="form-control" value="{{ $setting->w_link }}">
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col">
                                <label for="t_link">لينك تويتر</label>
                                <input type="text" name="t_link" class="form-control" value="{{ $setting->t_link }}">
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col">
                                <label for="y_link">لينك اليوتيوب</label>
                                <input type="text" name="y_link" class="form-control" value="{{ $setting->y_link }}">
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col">
                                <label for="commission_rate">نسبة العموله <span class="text-danger">*</span></label>
                                <input type="number" step="any" name="commission_rate" min="0"  max="100" class="form-control" value="{{ $setting->commission_rate }}">
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">عن التطبيق <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="about_app" id="exampleFormControlTextarea1" rows="4">{{ $setting->about_app }}</textarea>
                        </div>
                        <br>
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

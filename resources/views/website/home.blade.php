<?php $page = 'index'; ?>
@extends('layout.mainlayout')

@section('page-title', 'منصة مستر حسين')

@section('content')
    @include('website.sections.hero')
    @include('website.sections.stats')
    @include('website.sections.why-us')
    @include('website.sections.trending-offline')
    @include('website.sections.featured-students')
    @include('website.sections.reviews')
    @include('website.sections.centers')
@endsection

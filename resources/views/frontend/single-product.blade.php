@extends('frontend.layout')
@section('pages')
    <x-product-details :slug="$slug" />
@endsection
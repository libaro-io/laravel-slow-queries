<?php /** @var  Illuminate\Support\Collection<int, Libaro\LaravelSlowQueries\Data\SlowPageAggregation> $slowPagesAggregations */ ?>

@extends('slow-queries::layouts.default')
@section('pagetitle', 'Slow pages')

@section('content')
    <div class="overflow-hidden bg-white shadow sm:rounded-lg">
        <div class="px-4 py-6 sm:px-6">
            <h3 class="text-base font-semibold leading-7 text-gray-900">Settings</h3>
            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Overview of the laravel slow queriers package settings.</p>
        </div>
        <div class="border-t border-gray-100">
            <dl class="divide-y divide-gray-100">

                @foreach($settings as $setting)
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 flex items-center">
                        <dt class="text-sm font-medium">
                            <div class="text-gray-900">
                            {{$setting['name']}}
                            </div>
                            <div class="text-gray-400">{{$setting['description']}}</div>
                        </dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 flex items-center">
                            {{$setting['value']}}
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>


@endsection

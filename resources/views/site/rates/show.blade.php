@extends('site.layout.base')
@section('content')
    <div class="container">
        <h1 class="text-center">Тарифы</h1>
        <ul class="nav nav-tabs etp-tabs-nav" role="tablist">
            <li role="presentation" class="active"><a class="etp-tabs-nav__link" href="#base" aria-controls="base" role="tab" data-toggle="tab">Бизнес участник базовый</a></li>
            <li role="presentation"><a class="etp-tabs-nav__link" href="#subcription" aria-controls="subcription" role="tab" data-toggle="tab">Бизнес участник абонемент</a></li>
            <li role="presentation"><a class="etp-tabs-nav__link" href="#organizer" aria-controls="organizer" role="tab" data-toggle="tab">Бизнес Организатор</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="rate-content tab-pane active" id="base">
                @include('site.rates.base')
            </div>
            <div role="tabpanel" class="rate-content tab-pane" id="subcription">
                @include('site.rates.subscription')
            </div>
            <div role="tabpanel" class="rate-content  tab-pane" id="organizer">
                @include('site.rates.organizer')
            </div>
        </div>
    </div>
@stop
@section('scripts')
@stop
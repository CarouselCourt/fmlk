@extends('encounters.layout')

@section('title')
    Adventure
@endsection

@section('content')
<div>
    @if (Auth::check() && Auth::user()->hasPower('edit_data'))
        <a data-toggle="tooltip" title="[ADMIN] Edit Encounter" href="{{ url('admin/data/encounters/edit/') . '/' . $encounter->id }}" class="mb-2 float-right"><i class="fas fa-crown"></i></a>
    @endif
    <div class="row col-12 mb-2 text-center">
        <h1>{!! $encounter->name !!} - [{{ $area->name }}] </h1>
    </div>
    <div class="col-lg-10 col-12 m-auto text-center" style="position: relative; overflow: hidden; background:url({{ $area->imageUrl }}); max-height:500px;background-size: cover; background-position: center;">
        <!-- image -->
        @if ($encounter->has_image)
            <img src="{{ $encounter->imageUrl }}" class="m-auto"
                style="max-width:90%;">
        @endif
    </div>
    @isset($action_options)
    <div class="card rounded-0 p-4 text-justify">
        {!! $encounter->initial_prompt !!}
        <div class="text-center">
            <h5> What do you do?</h5>
            <hr>
            @foreach ($action_options as $option)
                {!! Form::open(['url' => 'encounter-areas/' . $area->id . '/act', 'class'=>'p-0']) !!}
                {!! Form::hidden('area_id', $area->id) !!}
                {!! Form::hidden('encounter_id', $encounter->id) !!}
                {!! Form::hidden('action', $option->id) !!}
                <div class="form-group">
                    {!! Form::submit($option->name, ['class' => 'btn btn-primary action-'. $option->id ]) !!}
                </div>
                {!! Form::close() !!}
            @endforeach
        </div>
    </div>
    @endisset
    @isset($response)
    <div class="card rounded-0 text-center">
        <p class="pt-4"> <b>{{ $action }} </b></p>
        <hr>
        {!! $response !!}
        <a href="/encounter-areas">
            <div class="btn btn-primary mb-5">Leave</div>
        </a>
    </div>
    @endisset
</div>
@endsection


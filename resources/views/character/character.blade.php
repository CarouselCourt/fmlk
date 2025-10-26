@extends('character.layout', ['isMyo' => $character->is_myo_slot])

@section('profile-title')
    {{ $character->fullName }}
@endsection

@section('meta-img')
    {{ $character->image->thumbnailUrl }}
@endsection

@section('profile-content')
    @if ($character->is_myo_slot)
        {!! breadcrumbs(['MYO Slot Masterlist' => 'myos', $character->fullName => $character->url]) !!}
    @else
        {!! breadcrumbs([
            $character->category->masterlist_sub_id ? $character->category->sublist->name . ' Masterlist' : 'Character masterlist' => $character->category->masterlist_sub_id ? 'sublist/' . $character->category->sublist->key : 'masterlist',
            $character->fullName => $character->url,
            'Stats' => $character->url . '/stats',
        ]) !!}
    @endif

    @include('character._header', ['character' => $character])

    @if ($character->images()->where('is_valid', 1)->whereNotNull('transformation_id')->exists())
        <div class="card-header mb-2">
            <ul class="nav nav-tabs card-header-tabs">
                @foreach ($character->images()->where('is_valid', 1)->get() as $image)
                    <li class="nav-item">
                        <a class="nav-link form-data-button {{ $image->id == $character->image->id ? 'active' : '' }}" data-toggle="tab" role="tab" data-id="{{ $image->id }}">
                            {{ $image->transformation_id ? $image->transformation->name : 'Main' }}
                        </a>
                    </li>
                @endforeach
                <li>
                    <h3>{!! add_help('Click on a transformation to view the image. If you don\'t see the transformation you\'re looking for, it may not have been uploaded yet.') !!}</h3>
                </li>
            </ul>
        </div>
    @endif

    {{-- Main Image --}}
    <div class="row mb-3" id="main-tab">
        <div class="col-md-7">
            <div class="text-center">
                <a href="{{ $character->image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists(public_path($character->image->imageDirectory . '/' . $character->image->fullsizeFileName)) ? $character->image->fullsizeUrl : $character->image->imageUrl }}"
                    data-lightbox="entry" data-title="{{ $character->fullName }}">
                    <img src="{{ $character->image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists(public_path($character->image->imageDirectory . '/' . $character->image->fullsizeFileName)) ? $character->image->fullsizeUrl : $character->image->imageUrl }}"
                        class="image" alt="{{ $character->fullName }}" />
                </a>
            </div>
            @if ($character->image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists(public_path($character->image->imageDirectory . '/' . $character->image->fullsizeFileName)))
                <div class="text-right">You are viewing the full-size image. <a href="{{ $character->image->imageUrl }}">View watermarked image</a>?</div>
            @endif
        </div>
        @include('character._image_info', ['image' => $character->image])
    </div>


	<div class="row justify-content-between p-3">
		<div class="col-6 p-1">
        @if (count($image->character->pets))
                    <div class="row justify-content-center text-center">
                        {{-- get one random pet --}}
                        @php
                            $pets = $image->character
                                ->pets()
                                ->orderBy('sort', 'DESC')
                                ->limit(config('lorekeeper.pets.display_pet_count'))
                                ->get();
                        @endphp
                        @foreach ($pets as $pet)
                            @if (config('lorekeeper.pets.pet_bonding_enabled'))
                                @include('character._pet_bonding_info', ['pet' => $pet])
                            @else
                                <div class="ml-2 mr-3">
                                    <img src="{{ $pet->pet->variantImage($pet->id) }}" style="max-width: 75px;" />
                                    <br>
                                    <span class="text-light badge badge-dark" style="font-size:95%;">{!! $pet->pet_name !!}</span>
                                    </div>
                                @endif
                        @endforeach
                    </div>
                @endif
		</div>

		<div class="col-6 p-1 card">
        @if (count($image->character->equipment()))
                    <div class="p-2">
                        <div class="mb-0">
                            <h5>Equipment</h5>
                        </div>
                        <div class="text-center row">
                            @foreach ($image->character->equipment()->take(5) as $equipment)
                                <div class="col-md-4">
                                    @if ($equipment->has_image)
                                        <img class="rounded" src="{{ $equipment->imageUrl }}" data-toggle="tooltip" title="{{ $equipment->equipment->name }}" style="max-width: 75px;" />
                                    @elseif($equipment->equipment->imageurl)
                                        <img class="rounded" src="{{ $equipment->equipment->imageUrl }}" data-toggle="tooltip" title="{{ $equipment->equipment->name }}" style="max-width: 75px;" />
                                    @else
                                        {!! $equipment->equipment->displayName !!}
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>


    
    <div class="row justify-content-center p-3">
		<div class="col-6 p-1 card">
        @include('character._tab_skills', ['character' => $character, 'skills' => $skills])
		</div>
        <div class="col-6 p-1 card">
        @foreach ($character->stats->chunk(4) as $chunk)
                <div class="row align-items-center justify-content-between no-gutters">
                    @foreach ($chunk as $stat)
                    
                        <div class="p-1 m-2 rounded p-2 stat-entry" style="width: 100px; height: 100px; background-color: {{ $stat->stat->colour }};" data-id="{{ $stat->id }}">
                            <h6 class="text-center" style=" text-transform:uppercase;">
                                {{ $stat->stat->name }}
                                <br>
                                (lvl {{ $stat->stat_level }})
                            </h6>
                            <h6 class="text-center">
                                    <b>
                                        {{ $character->currentStatCount($stat->stat->id) }}
                                    </b>
                                    </h6>
                            </div>
                        
                    @endforeach
	</div>
    @endforeach
    </div>
    </div>

    {{-- Info --}}
    <div class="card character-bio">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" id="statsTab" data-toggle="tab" href="#stats" role="tab">Stats</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="notesTab" data-toggle="tab" href="#notes" role="tab">Description</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="skillsTab" data-toggle="tab" href="#skills" role="tab">Skills</a>
                </li>
                @if (Auth::check() && Auth::user()->hasPower('manage_characters'))
                    <li class="nav-item">
                        <a class="nav-link" id="settingsTab" data-toggle="tab" href="#settings-{{ $character->slug }}" role="tab"><i class="fas fa-cog"></i></a>
                    </li>
                @endif
            </ul>
        </div>
        <div class="card-body tab-content">
            <div class="tab-pane fade show active" id="stats">
                @include('character._tab_stats', ['character' => $character])
            </div>
            <div class="tab-pane fade" id="notes">
                @include('character._tab_notes', ['character' => $character])
            </div>
            <div class="tab-pane fade" id="skills">
                
            </div>
            @if (Auth::check() && Auth::user()->hasPower('manage_characters'))
                <div class="tab-pane fade" id="settings-{{ $character->slug }}">
                    {!! Form::open(['url' => $character->is_myo_slot ? 'admin/myo/' . $character->id . '/settings' : 'admin/character/' . $character->slug . '/settings']) !!}
                    <div class="form-group">
                        {!! Form::checkbox('is_visible', 1, $character->is_visible, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
                        {!! Form::label('is_visible', 'Is Visible', ['class' => 'form-check-label ml-3']) !!} {!! add_help('Turn this off to hide the character. Only mods with the Manage Masterlist power (that\'s you!) can view it - the owner will also not be able to see the character\'s page.') !!}
                    </div>
                    <div class="text-right">
                        {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                    <hr />
                    <div class="text-right">
                        <a href="#" class="btn btn-outline-danger btn-sm delete-character" data-slug="{{ $character->slug }}">Delete</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    @include('character._transformation_js')
    @include('character._image_js', ['character' => $character])
@endsection

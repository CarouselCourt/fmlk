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

    <div class="card character-bio">
	<div class="row align-items-start">
		<div class="col card-body">
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
                        <div class="ml-auto float-right mr-3">
                            <a href="{{ $character->url . '/pets' }}" class="btn btn-outline-info btn-sm">View All</a>
                        </div>
                    </div>
                @endif
		</div>

		<div class="col card-body">
        @if (count($image->character->equipment()))
                    <div class="mb-1 mt-4">
                        <div class="mb-0">
                            <h5>Equipment</h5>
                        </div>
                        <div class="text-center row">
                            @foreach ($image->character->equipment()->take(5) as $equipment)
                                <div class="col-md-2">
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
                        <div class="float-right">
                            <a href="{{ $character->url . '/stats' }}">View All...</a>
                        </div>
                    </div>
                @endif
            </div>
		</div>
        </div>
        </div>
    <div class="card character-bio">
    <div class="row align-items-start">
		<div class="col card-body">
        <div class="row">
                    <div class="col-lg-5 col-md-6 col-3">
                        <h5>Background</h5>
                    </div>
                    <div class="col-lg-7 col-md-6 col-8">{!! $image->character->class_id ? $image->character->class->displayName : 'None' !!}
                        @if (Auth::check())
                            @if (Auth::user()->isStaff == $image->character->user_id && $image->character->class_id == null)
                                <a href="#" class="btn btn-outline-info btn-sm edit-class ml-1" data-id="{{ $image->character->id }}"><i class="fas fa-cog"></i></a>
                            @endif
                        @endif
                    </div>
                </div>
                @if ($image->character->homeSetting)
                    <div class="row">
                        <div class="col-lg-5 col-md-6 col-4">
                            <h5>Home</h5>
                        </div>
                        <div class="col-lg-7 col-md-6 col-8">{!! $image->character->location ? $image->character->location : 'None' !!}</div>
                    </div>
                @endif
                @if ($image->character->factionSetting)
                    <div class="row">
                        <div class="col-lg-5 col-md-6 col-4">
                            <h5>Faction</h5>
                        </div>
                        <div class="col-lg-7 col-md-6 col-8">{!! $image->character->faction ? $image->character->currentFaction : 'None' !!}{!! $character->factionRank ? ' (' . $character->factionRank->name . ')' : null !!}</div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-lg-5 col-md-6 col-4">
                            <h5>Species</h5>
                    </div>
                    <div class="col-lg-7 col-md-6 col-8">{!! $image->species_id ? $image->species->displayName : 'None' !!}</div>
                </div>
		</div>
        <div class="col card-body">
        <div class="row">
        @foreach ($character->stats->chunk(4) as $chunk)
                <div class="row justify-content-center no-gutters">
                    @foreach ($chunk as $stat)
                        <div class="col-md-2 p-1 m-2 rounded p-2 stat-entry" style="background-color: {{ $stat->stat->colour }};" data-id="{{ $stat->id }}">
                            <h5 class="text-center">
                                {{ $stat->stat->name }}
                                (lvl {{ $stat->stat_level }})
                            </h5>
                            <div class="text-center">
                                <p>
                                    <b>Stat Value:</b>
                                    <u>
                                        <span data-toggle="tooltip" title="Base Stat: {{ $stat->count }}">
                                            {{ $character->totalStatCount($stat->stat->id) . ' (+ ' . $character->totalStatCount($stat->stat->id) - $stat->count . ')' }}
                                            {!! $character->totalStatCount($stat->stat->id) - $stat->count > 0 ? add_help('This stat has gained extra points through equipment.') : '' !!}
                                        </span>
                                    </u>
                                    <br />
                                    <b>Current Value:</b>
                                    <u>
                                        {{ $character->currentStatCount($stat->stat->id) }}
                                        {!! add_help('This is the current value of the stat. This can differ due to debuffs, damage taken, etc.') !!}
                                    </u>
                                </p>
                            </div>
                        </div>
                    @endforeach
	</div>
    </div>
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
                @include('character._tab_skills', ['character' => $character, 'skills' => $skills])
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

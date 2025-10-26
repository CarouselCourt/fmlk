@extends('character.layout', ['isMyo' => $character->is_myo_slot])

@section('profile-title')
    {{ $character->fullName }}'s Profile
@endsection

@section('meta-img')
    {{ $character->image->thumbnailUrl }}
@endsection

@section('profile-content')
    @if ($character->is_myo_slot)
        {!! breadcrumbs(['MYO Slot Masterlist' => 'myos', $character->fullName => $character->url, 'Profile' => $character->url . '/profile']) !!}
    @else
        {!! breadcrumbs([
            $character->category->masterlist_sub_id ? $character->category->sublist->name . ' Masterlist' : 'Character masterlist' => $character->category->masterlist_sub_id ? 'sublist/' . $character->category->sublist->key : 'masterlist',
            $character->fullName => $character->url,
            'Profile' => $character->url . '/profile',
        ]) !!}
    @endif

    @include('character._header', ['character' => $character])

    <div class="mb-3">
        <div class="text-center">
            <a href="{{ $character->image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists(public_path($character->image->imageDirectory . '/' . $character->image->fullsizeFileName)) ? $character->image->fullsizeUrl : $character->image->imageUrl }}"
                data-lightbox="entry" data-title="{{ $character->fullName }}">
                <img src="{{ $character->image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists(public_path($character->image->imageDirectory . '/' . $character->image->fullsizeFileName)) ? $character->image->fullsizeUrl : $character->image->imageUrl }}"
                    class="image img-fluid" alt="{{ $character->fullName }}" />
            </a>
        </div>
        @if ($character->image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists(public_path($character->image->imageDirectory . '/' . $character->image->fullsizeFileName)))
            <div class="text-right">You are viewing the full-size image. <a href="{{ $character->image->imageUrl }}">View watermarked image</a>?</div>
        @endif
    </div>

    <div class="container-fluid character-bio" id="info-{{ $image->id }}">
	<div class="row">
		<div class="col-md-4">

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
		<div class="col-md-4">
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
		<div class="col-md-4">
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
                @if ($image->transformation_id)
                    <div class="row">
                        <div class="col-lg-5 col-md-6 col-4">
                            <h5>Form {!! add_help('The main image is always the active image') !!}</h5>
                        </div>
                        <div class="col-lg-7 col-md-6 col-8">
                            <a href="{{ $image->transformation->url }}">
                                {!! $image->transformation->displayName !!}
                            </a>
                        </div>
                    </div>
                @endif
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

			</p>
		</div>
	</div>
</div>

    {{-- Bio --}}
<a class="float-left" href="{{ url('reports/new?url=') . $character->url . '/profile' }}"><i class="fas fa-exclamation-triangle" data-toggle="tooltip" title="Click here to report this character's profile." style="opacity: 50%;"></i></a>
@if(Auth::check() && ($character->user_id == Auth::user()->id || Auth::user()->hasPower('manage_characters')))
    <div class="text-right mb-2">
        <a href="{{ $character->url . '/profile/edit' }}" class="btn btn-outline-info btn-sm"><i class="fas fa-cog"></i> Edit Profile</a>
    </div>
@endif
@if($character->profile->custom_values->count() > 0)
    <div class="row no-gutters">
        @php $valueGroups = $character->profile->custom_values->groupBy('group'); @endphp
        @foreach($valueGroups as $groupName => $values)
            <div class="col-12 mb-3">
                <div class="card">
                    @if($groupName)
                        <div class="card-header">
                            <h5 class="mb-0 mx-n1">{{ $values->first()->group }}</h5>
                        </div>
                    @endif
                    <ul class="list-group list-group-flush">
                        @foreach($values as $value)
                            <li class="list-group-item px-3">
                                <div class="row no-gutters align-items-center">
                                    @if($value->name && $value->name != "")
                                        <div class="col-4 col-md-3"><h6 class="mb-0" style="font-weight: bold;">{{ $value->name }}</h6></div>
                                        <div class="col-8 col-md-9 pl-2">{!! $value->data_parsed !!}</div>
                                    @else
                                        <div class="col-12">{!! $value->data_parsed !!}</div>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
@endif
@if($character->profile->parsed_text)
    <div class="card mb-3">
        <div class="card-body parsed-text">
                {!! $character->profile->parsed_text !!}
            </div>
        </div>
    @endif

    @if ($character->is_trading || $character->is_gift_art_allowed || $character->is_gift_writing_allowed)
        <div class="card mb-3">
            <ul class="list-group list-group-flush">
                @if ($character->is_gift_art_allowed >= 1 && !$character->is_myo_slot)
                    <li class="list-group-item">
                        <h5 class="mb-0"><i class="{{ $character->is_gift_art_allowed == 1 ? 'text-success' : 'text-secondary' }} far fa-circle fa-fw mr-2"></i>
                            {{ $character->is_gift_art_allowed == 1 ? 'Gift art is allowed' : 'Please ask before gift art' }}</h5>
                    </li>
                @endif
                @if ($character->is_gift_writing_allowed >= 1 && !$character->is_myo_slot)
                    <li class="list-group-item">
                        <h5 class="mb-0"><i class="{{ $character->is_gift_writing_allowed == 1 ? 'text-success' : 'text-secondary' }} far fa-circle fa-fw mr-2"></i>
                            {{ $character->is_gift_writing_allowed == 1 ? 'Gift writing is allowed' : 'Please ask before gift writing' }}</h5>
                    </li>
                @endif
                @if ($character->is_trading)
                    <li class="list-group-item">
                        <h5 class="mb-0"><i class="text-success far fa-circle fa-fw mr-2"></i> Open for trades</h5>
                    </li>
                @endif
            </ul>
        </div>
    @endif
@endsection

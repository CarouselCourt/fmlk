@if ($character->skills()->where('skill_id', $children->id)->exists())
    @php
        $characterSkill = $character
            ->skills()
            ->where('skill_id', $children->id)
            ->first();
    @endphp
@else
    @php $characterSkill = null; @endphp
@endif
<li class="mx-auto">
    <div class="member-view-box" id="children-{{ $children->id }}">
        <div class="member-image">
            <button class="{{ $children->url }}" class="{{ isset($characterSkill) ? '' : 'disabled' }} btn btn-lg btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#skilltree" aria-expanded="false" aria-controls="skilltree">
                <strong>{!! $children->name !!}</strong>
</button>
            <div class="member-details text-center collapse" id="skilltree">
                <p class="mb-0">
                    <small data-toggle="tooltip" title="Prerequisite/Requires. <br>This children is required.">R: {!! isset($children->prerequisite) ? $children->prerequisite->displayName : 'None' !!}</small>
                    <br>
                    @if (isset($characterSkill))
                        <small>Level: {{ $characterSkill->level }}</small>
                    @else
                        <small>Not unlocked.<br>Requires {{ $children->parent->name }} level {{ $children->parent_level }}</small>
                    @endif
                </p>
            </div>
        </div>
    </div>

    @if ($children->children->count() && $characterSkill)
        <a href="javascript:void(0);">
            <i class="fas fa-sort-down" style="margin-left:1px"></i>
        </a>
        <ul class="active">
            @foreach ($children->children as $child)
                @include('character._skill_children', ['children' => $child, 'skill' => $skill])
            @endforeach
        </ul>
    @endif
</li>

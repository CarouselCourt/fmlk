@if (count($skills))
    @foreach ($skills->chunk(2) as $chunk)
        <div class="row">
            @foreach ($chunk as $skill)
                <div class="col-md">
                    <div class="text-center">
                    <a class="btn" data-bs-toggle="collapse" href="#skilltree" role="button" aria-expanded="false" aria-controls="skilltree"><h5>
                            {{ $skill->name }}
                        </h5>
                        @if ($character->skills()->where('skill_id', $skill->id)->exists())
                            @php
                                $characterSkill = $character
                                    ->skills()
                                    ->where('skill_id', $skill->id)
                                    ->first();
                            @endphp
                            </a>
                            <br>
                            Level: {{ $characterSkill->level }}
                    </div>
                    <div class="collapse" id="skilltree">
                    <div class="row">
                        @foreach ($skill->children as $children)
                            <div class="col-md  mx-auto body children-body children-scroll">
                                <div class="children-skill ">
                                    <ul>
                                        @include('character._skill_children', ['children' => $children, 'skill' => $skill])
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                @else
                </div>
                <p class="mx-auto text-center">Not unlocked.
                    <br>
                    @if ($skill->prerequisite)
                        Requires {!! $skill->prerequisite->displayname !!}
                    @endif
                </p>
            @endif
        </div></div>
    @endforeach
    </div>
    <hr>
@endforeach
@else
<p class="text-center">No available skills.</p>
@endif

<script>
    $(function() {
        $('.children-skill ul').hide();
        $('.children-skill>ul').show();
        $('.children-skill ul.active').show();
        $('.children-skill li').on('click', function(e) {
            var children = $(this).find('> ul');
            if (children.is(":visible")) children.hide('fast').removeClass('active');
            else children.show('fast').addClass('active');
            e.stopPropagation();
        });
    });
</script>

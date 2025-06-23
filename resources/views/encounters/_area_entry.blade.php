<div class="col-md-4 col-12 mb-3 text-center ">
    @if (Auth::check() && Auth::user()->hasPower('edit_data'))
        <a data-toggle="tooltip" title="[ADMIN] Edit Area" href="{{ url('admin/data/encounters/areas/edit/') . '/' . $area->id }}" class="mb-2 float-right"><i class="fas fa-crown"></i></a>
    @endif
    <div class="card">
        @if ($area->has_thumbnail)
            <div class="card-header p-0">
                <a href="{{ $area->url }}"><img class="w-100" src="{{ $area->thumbImageUrl }}" alt="{{ $area->name }}" /></a>
            </div>
        @endif
        <div class="card-body p-0">
            <h4>{{ $area->name }}</h4>

            {!! $area->parsed_description !!}
            @if ($area->limits->count())
            <div class="text-muted small">(Requires <?php
            $limits = [];
            foreach ($area->limits as $limit) {
                $name = $limit->item->displayName;
                $limits[] = $name;
            }
            echo implode(', ', $limits);
            ?>)</div>
        @endif
        </div>
        
        <div class="card-footer ">
            <a href="encounter-areas/{{ $area->id }}" class="btn btn-primary btn-sm"> Explore</a>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.initiate-explore-{{ $area->id }}', function() {
        $.ajax({
            type: "GET",
            url: "{{ url('encounter-areas/' . $area->id) }}",
        }).done(function(res) {
            $("#encounter-area").fadeOut(500, function() {
                $("#encounter-area").html(res);
                $("#encounter-area").fadeIn(500);
            });
        }).fail(function(jqXHR, textStatus, errorThrown) {
            alert("AJAX call failed: " + textStatus + ", " + errorThrown);
        });
    });
</script>

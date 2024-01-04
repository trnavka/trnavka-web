<div class="timeline-2023">
    <div class="container-fluid">
        <div class="content">
            <div class="row">
                <div class="col-12">
                    <h2 class="wp-block-heading mb-3">Čo sme zažili</h2>
                </div>
                <div class="col-lg-8">
                    <p class="lead">
                        Ak ste to zažili, tak si môžete pripomenúť jednotlivé akcie. Ak ste to nezažili, tak vás pozývame to zažiť v roku 2024.
                    </p>
                </div>
            </div>
        </div>

        <ol class="timeline">
            @foreach($events as $event)
                <li class="timeline-item
                @if(!empty($event['image']) || !empty($event['comment'])) | extra-space
                @endif
                ">
                                    <span class="timeline-item-icon | faded-icon">
                                        <img src="@asset('images/' . $event['icon'])" alt="">
                                    </span>
                    <div class="timeline-item-wrapper">
                        <div class="timeline-item-description">
                            <span><strong>{{$event['subject']}}</strong>{{' ' === $event['action'] ? ', ' : $event['action']}} {!! $event['date'] !!}</span>
                        </div>
                        @if(!empty($event['image']) || !empty($event['comment']))
                            <div class="comment">
                                @if(!empty($event['image']))
                                    <img src="@asset('images/2023/events/' . $event['image'])"/>
                                @endif
                                @if(!empty($event['comment']))
                                    <p>{!! $event['comment'] !!}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
</div>

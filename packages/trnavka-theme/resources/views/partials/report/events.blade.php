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

        @php($lastMonth = null)

        <ol class="timeline">
            @foreach($events as $event)
                @if($lastMonth !== $event['month'])
                    <li class="timeline-item">
                        <h3 class="text-primary @if(null !== $lastMonth) mt-5 @endif">
                            {{$event['month']}}
                        </h3>
                    </li>
                @endif
                <li class="timeline-item">
                    <span class="timeline-item-icon | faded-icon">
                                        <img src="@asset('images/' . $event['icon'])" alt="">
                                    </span>
                    <div class="timeline-item-wrapper @if($event['emphasize']) timeline-item-emphasized @endif">
                        <div class="timeline-item-description">
                            <div>
                                <div class="timeline-date-and-service mb-2">
                                    {!! $event['date'] !!} • {{$event['service']}}
                                </div>
                                <strong>{{$event['subject']}}</strong>{{$event['action']}}</div>
                        </div>
                        @if(!empty($event['image']) || !empty($event['comment']) || (!empty($event['link_label']) && !empty($event['link_url'])))
                            <div class="comment">
                                @if(!empty($event['image']))
                                    <img src="@asset('images/' . $year . '/events/' . $event['image'])"/>
                                @endif
                                @if(!empty($event['comment']))
                                    <p>
                                        {!! $event['comment'] ?? '' !!}
                                    </p>
                                @endif
                                @if(!empty($event['link_label']) && !empty($event['link_url']))
                                    <p>
                                        <a href="{{$event['link_url']}}">{{$event['link_label']}}</a>
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>
                </li>

                @php($lastMonth = $event['month'])
            @endforeach
        </ol>
    </div>
</div>

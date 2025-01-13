<div class="report-features-dicaprio">
    <div class="container-fluid ">
        <div class="row">
            @foreach($services as $i => $service)
                <div class="col-12">
                    <div class="row report-features-item">
                        <div class="col-lg-8 item-image @if(($i + 1) % 2 === 0) order-lg-last @endif">
                            @if(isset($service['image']))
                                <img src="@asset('images/' . $year . '/' . $service['image'])?cb=4"/>
                            @endif
                        </div>
                        <div class="col-lg-4 d-flex align-self-center">
                            <div class="content @if(($i + 1) % 2 === 0) content-left @else content-right @endif">
                                <h3 class="wp-block-heading mb-4">{{$service['title']}}</h3>
                                <div class="service-content">
                                    <ul>
                                        @foreach($service['numbers'] as $number)
                                            <li>
                                                <strong>{{$number[0]}}</strong> {{$number[1]}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="container-fluid ">
    <div class="row">
        <div class="col-12">
            <h2 class="my-4">
                Neverejné štatistiky Daj na to!
            </h2>
        </div>
        <div class="col-12 pb-5">
            Predplatné od 1. 1. 2023 (staré + nové):
            <h3>@euro($subscription_stats->sum / 100)</h3>
            Počet darcov od 1. 1. 2023 (staré + nové):
            <h3>{{$subscription_stats->count}}</h3>
        </div>
        <div class="col-4">
            <h3>"Predplatné" - nové</h3>

            Celkový počet darcov za celé obdobie:
            {{$dajnato_stats['new_dielo_payments']['all_users']}}

            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>Mesiac</th>
                        <th>Počet darcov</th>
                        <th>Suma</th>
                    </tr>
                </thead>
            @foreach($dajnato_stats['new_dielo_payments']['by_year'] as $data)
                <tr>
                    <td>{{$data->year}}</td>
                    <td>{{$data->count}}</td>
                    <td>@euro($data->sum / 100)</td>
                </tr>
            @endforeach
            </table>
        </div>
        <div class="col-4">
            <h3>"Predplatné" - staré</h3>

            Celkový počet darcov za celé obdobie:
            {{$dajnato_stats['old_dielo_payments']['all_users']}}

            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>Rok</th>
                        <th>Počet darcov</th>
                        <th>Suma</th>
                    </tr>
                </thead>
            @foreach($dajnato_stats['old_dielo_payments']['by_year'] as $data)
                <tr>
                    <td>{{$data->year}}</td>
                    <td>{{$data->count}}</td>
                    <td>@euro($data->sum / 100)</td>
                </tr>
            @endforeach
            </table>
        </div>
        <div class="col-4">
            <h3>Všetky dary</h3>

            Celkový počet darcov za celé obdobie:
            {{$dajnato_stats['all_payments']['all_users']}}

            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>Rok</th>
                        <th>Počet darcov</th>
                        <th>Suma</th>
                    </tr>
                </thead>
                @foreach($dajnato_stats['all_payments']['by_year'] as $data)
                    <tr>
                        <td>{{$data->year}}</td>
                        <td>{{$data->count}}</td>
                        <td>@euro($data->sum / 100)</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
<hr>

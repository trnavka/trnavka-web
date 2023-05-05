<div class="service-finances">
    <div class="container-fluid">
        <div class="row">
            <h2>Prehľad organizácií diela</h2>
            <div class="text-end" style="color: #3B3B42;">
                Klikni na "+" na zobrazenie detailov
            </div>
            <div class="accordion" id="accordionExample">
                @foreach($financial_subjects as $financial_subject)
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="{{$financial_subject->slug}}-heading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#{{$financial_subject->slug}}" aria-expanded="true" aria-controls="{{$financial_subject->slug}}">
                                <span>
                                    <strong class="d-block">{{$financial_subject->title}}</strong>
                                    <span class="d-block mt-1">
                                        Príjmy: @euro($financial_subject->getIncome()) <span class="px-4"></span> <span class="d-inline-block">Výdavky: -@euro($financial_subject->getCosts())</span>
                                    </span>
                                    <span class="d-block text-primary">
                                        Ročne potrebujeme z darov @euro($financial_subject->getLoss() * -1)
                                    </span>
                                </span>
                            </button>
                        </h3>
                        <div id="{{$financial_subject->slug}}" class="accordion-collapse collapse" aria-labelledby="{{$financial_subject->slug}}-heading">
                            <div class="accordion-body">

                                @if(!empty($financial_subject->description))
                                    <p class="small">
                                        {{$financial_subject->description}}
                                    </p>
                                @endif

                                <h4>Príjmy</h4>
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <tr>
                                            <td>Príspevky (členské, poplatky)</td>
                                            <td style="text-align: right;">@euro($financial_subject->incomeServiceFees)</td>
                                        </tr>
                                        <tr>
                                            <td>Milodary, zbierky</td>
                                            <td style="text-align: right;">@euro($financial_subject->incomeCollections)</td>
                                        </tr>
                                        <tr>
                                            <td>Zvonček</td>
                                            <td style="text-align: right;">@euro($financial_subject->incomeParishCollections)</td>
                                        </tr>
                                        <tr>
                                            <td>Dotácie</td>
                                            <td style="text-align: right;">@euro($financial_subject->incomeGrants)</td>
                                        </tr>
                                        <tr>
                                            <td>2% z dane</td>
                                            <td style="text-align: right;">@euro($financial_subject->income2percents)</td>
                                        </tr>
                                        <tr>
                                            <td>Spolu</td>
                                            <td style="text-align: right;">@euro($financial_subject->getIncome())</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="mt-2">
                                    <h4>Výdavky</h4>
                                </div>
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <tr>
                                            <td>Energie</td>
                                            <td style="text-align: right;">@euro(-$financial_subject->costsUtility)</td>
                                        </tr>
                                        <tr>
                                            <td>Materiál</td>
                                            <td style="text-align: right;">@euro(-$financial_subject->costsMaterial)</td>
                                        </tr>
                                        <tr>
                                            <td>Opravy</td>
                                            <td style="text-align: right;">@euro(-$financial_subject->costsMaintenance)</td>
                                        </tr>
                                        <tr>
                                            <td>Personálne náklady</td>
                                            <td style="text-align: right;">@euro(-$financial_subject->costsHr)</td>
                                        </tr>
                                        <tr>
                                            <td>Poplatky</td>
                                            <td style="text-align: right;">@euro(-$financial_subject->costsFees)</td>
                                        </tr>
                                        <tr>
                                            <td>Ostatné</td>
                                            <td style="text-align: right;">@euro(-$financial_subject->costsOther)</td>
                                        </tr>
                                        <tr>
                                            <td>Spolu</td>
                                            <td style="text-align: right;">@euro(-$financial_subject->getCosts())</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

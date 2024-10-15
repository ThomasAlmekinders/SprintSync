@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1>Over SprintNest</h1>
                <p class="lead text-center mb-5">Samenwerken, plannen en organiseren met gemak.</p>
                
                <div class="mb-5">
                    <h2 class="h4">Onze Missie</h2>
                    <p>Bij <strong>SprintNest</strong> streven we ernaar om teams te ondersteunen in het beheren van projecten door een eenvoudig, gebruiksvriendelijk platform aan te bieden. Wat dit project uniek maakt, is dat het is ontwikkeld door een student als eindopdracht voor de opleiding Software Developer. Hoewel SprintNest momenteel nog in de testfase zit, biedt het een solide basis voor kleine bedrijven en testers die op zoek zijn naar een eenvoudig en effectief scrum-bord.</p>
                    <p>Het platform is ontworpen om de efficiëntie binnen teams te verhogen, door middel van strakke en eenvoudige scrum-functionaliteiten. Dit maakt het voor teams gemakkelijk om overzicht te houden over taken en projecten, zonder te worden afgeleid door complexe of overbodige functies. Dit minimalistische design bevordert niet alleen de productiviteit, maar verbetert ook de communicatie binnen het team, waardoor iedereen op de hoogte blijft van de voortgang.</p>
                    <p>Hoewel SprintNest nog in ontwikkeling is, werken we hard aan de uitbreiding van functionaliteiten. Denk hierbij aan het toevoegen van contactformulieren, bedrijfsaccounts, en de mogelijkheid om opmerkingen te plaatsen onder scrum-borden en taken. Ons doel is om een flexibel en intuïtief platform te creëren dat blijft groeien en verbeteren.</p>
                </div>

                <div class="mb-5">
                    <h2 class="h4">Ons Team</h2>
                    <p><strong>SprintNest</strong> is het resultaat van hard werken door één student die gepassioneerd is over softwareontwikkeling. Als onderdeel van een eindopdracht voor de opleiding Software Developer, heeft dit project als doel om praktische ervaring op te doen in het werken met Laravel en het bouwen van webapplicaties. Hoewel dit project op dit moment door één persoon wordt ontwikkeld, zijn de ambities groot.</p>
                    <p>Mijn ervaring ligt voornamelijk in frontend-ontwikkeling, waar ik heb geleerd hoe ik responsive, gebruiksvriendelijke websites kan ontwerpen en bouwen. Met SprintNest heb ik echter de kans om mijn vaardigheden te verbreden en me te verdiepen in backend-ontwikkeling en projectbeheer. Dit project is een leerervaring die mij helpt groeien als ontwikkelaar, terwijl ik tegelijkertijd probeer een platform te bieden dat nuttig kan zijn voor andere bedrijven en teams.</p>
                </div>

                <div class="mb-5">
                    <h2 class="h4">Waarom Kiezen Voor SprintNest?</h2>
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex align-items-start">
                            <i class="bi bi-check-circle-fill text-success me-3 icon-size"></i>
                            <span>Intuïtief en makkelijk in gebruik</span>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="bi bi-check-circle-fill text-success me-3 icon-size"></i>
                            <span>Verbeterde samenwerking en communicatie</span>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="bi bi-check-circle-fill text-success me-3 icon-size"></i>
                            <span>Flexibele tools voor projectmanagement</span>
                        </li>
                    </ul>
                </div>

                <div class="text-center">
                    <img src="{{ asset('/images/Scrum_Voorbeeld_Resized _Comp.webp') }}" 
                         class="img-fluid rounded shadow" 
                         with="800px" height="525px"
                         alt="Scrumboard">
                </div>
            </div>
        </div>
    </div>
@endsection

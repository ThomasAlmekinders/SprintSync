@extends('account.beheer.index')

@section('beheer-content')
<div class="container-xxl py-4">

    <div class="row justify-content-center mb-4">
        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="border border-1 h-100 rounded p-4 bg-light">
                <h5 class="mb-3 text-center">Totaal aantal gebruikers</h5>
                <h2 class="text-center">{{ $totalUsers }}</h2>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="border border-1 h-100 rounded p-4 bg-light">
                <h5 class="mb-3 text-center">Totaal aantal formulieren</h5>
                <h2 class="text-center">{{ $totalForms }}</h2>
            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-8 mb-3">
            <div class="border border-1 h-100 rounded p-4 bg-light">
                <h5 class="mb-3 text-center">Registraties per maand</h5>
                <canvas id="monthlyRegistrationsChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="border border-1 h-100 rounded p-4 bg-light">
                <h5 class="mb-3 text-center">Status van formulieren</h5>
                <ul class="list-group">
                    @foreach($formStatusCounts as $status => $count)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ ucfirst($status) }}</span>
                            <span class="badge bg-primary rounded-pill">{{ $count }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-8 mb-3">
            <div class="border border-1 h-100 rounded p-4 bg-light">
                <h5 class="mb-3 text-center">Formulieren per maand</h5>
                <canvas id="monthlyFormsChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>



<!-- Add Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const monthlyRegistrations = @json($monthlyRegistrations);
    const labels1 = Array.from({length: 12}, (_, i) => new Date(0, i + 1).toLocaleString('default', { month: 'long' }));
    const data1 = labels1.map((_, index) => monthlyRegistrations[index + 1] || 0);

    const ctx1 = document.getElementById('monthlyRegistrationsChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: labels1,
            datasets: [{
                label: 'Registraties',
                data: data1,
                backgroundColor: '#0d6efd',
                borderColor: '#0b5ed7',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const monthlyForms = @json($monthlyForms);
    const labels2 = Array.from({length: 12}, (_, i) => new Date(0, i + 1).toLocaleString('default', { month: 'long' }));
    const data2 = labels2.map((_, index) => monthlyForms[index + 1] || 0);

    const ctx2 = document.getElementById('monthlyFormsChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: labels2,
            datasets: [{
                label: 'Formulieren',
                data: data2,
                backgroundColor: '#28a745',
                borderColor: '#218838',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection

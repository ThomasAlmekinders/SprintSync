@extends('account.beheer.index')

@section('beheer-content')
<div class="container-xxl py-4">
    <div class="row justify-content-center">
        <div class="col-12">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

            @if($contactSubmissions->isEmpty())
                <p>Er zijn geen contactformulier inzendingen.</p>
            @else
                <table class="table">
                    @foreach($contactSubmissions as $submission)
                        <tr class="align-middle" data-status="{{ $submission->status }}">
                            <td>
                                <strong>{{ $submission->first_name }} {{ $submission->last_name }}</strong>
                                <br>
                                <span class="text-muted">{{ $submission->subject ?? 'Geen onderwerp' }}</span>
                            </td>
                            <td class="text-muted text-end">
                                <small>{{ $submission->created_at->format('d-m-Y H:i') }}</small>
                            </td>
                            <td class="text-end">
                                <span class="badge 
                                    @if($submission->status == 'new') bg-success 
                                    @elseif($submission->status == 'in_progress') bg-warning 
                                    @elseif($submission->status == 'answered') bg-primary 
                                    @elseif($submission->status == 'closed') bg-secondary 
                                    @endif">
                                    {{ ucfirst($submission->status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="#" class="btn btn-sm text-primary text-info text-nowrap" data-bs-toggle="modal" data-bs-target="#submissionModal" 
                                    data-status="{{ $submission->status }}"
                                    data-first-name="{{ $submission->first_name }}" 
                                    data-last-name="{{ $submission->last_name }}" 
                                    data-email="{{ $submission->email }}" 
                                    data-phone="{{ $submission->phone_number ?? 'Niet opgegeven' }}" 
                                    data-message="{!! nl2br(e($submission->message)) !!}" 
                                    data-ip="{{ $submission->ip_address }}" 
                                    data-created-at="{{ $submission->created_at->format('d-m-Y H:i') }}">Bekijk meer</a>
                            </td>
                            <td class="text-end">
                                <form action="{{ route('beheer.formulieren.delete', $submission->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm ms-2 text-danger" onclick="return confirm('Weet je zeker dat je deze inzending wilt verwijderen?');">Verwijderen</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="submissionModal" tabindex="-1" aria-labelledby="submissionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="submissionModalLabel">Formulier details</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Info rows -->
                <div class="mb-3">
                    <strong>Naam:</strong> <span id="modalFirstName"></span> <span id="modalLastName"></span>
                </div>
                <div class="mb-3">
                    <strong>Email:</strong> <span id="modalEmail"></span>
                </div>
                <div class="mb-3">
                    <strong>Telefoon:</strong> <span id="modalPhone"></span>
                </div>

                <!-- Message section -->
                <h6><strong>Bericht:</strong></h6>
                <div id="modalMessage" class="bg-light p-3 rounded text-dark" style="white-space: pre-wrap;"></div>

                <!-- Meta data -->
                <div class="mt-4">
                    <small><strong>IP-adres:</strong> <span id="modalIp" class="text-muted"></span></small><br>
                    <small><strong>Verzonden op:</strong> <span id="modalCreatedAt" class="text-muted"></span></small>
                </div>
            </div>
            <div class="modal-footer">
                <span id="modalStatus" class="badge"></span> <!-- Status badge moved here -->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluiten</button>
            </div>
        </div>
    </div>
</div>

<script defer>
const modal = document.getElementById('submissionModal');
modal.addEventListener('show.bs.modal', (event) => {
    const button = event.relatedTarget;
    const status = button.getAttribute('data-status');
    const firstName = button.getAttribute('data-first-name');
    const lastName = button.getAttribute('data-last-name');
    const email = button.getAttribute('data-email');
    const phone = button.getAttribute('data-phone');
    const message = button.getAttribute('data-message');
    const ip = button.getAttribute('data-ip');
    const createdAt = button.getAttribute('data-created-at');

    modal.querySelector('#modalFirstName').innerHTML  = firstName;
    modal.querySelector('#modalLastName').innerHTML  = lastName;
    modal.querySelector('#modalEmail').innerHTML  = email;
    modal.querySelector('#modalPhone').innerHTML  = phone;
    modal.querySelector('#modalMessage').innerHTML  = message;
    modal.querySelector('#modalIp').innerHTML  = ip;
    modal.querySelector('#modalCreatedAt').innerHTML  = createdAt;

    // Set status badge in the modal
    const modalStatus = modal.querySelector('#modalStatus');
    modalStatus.innerHTML = status.charAt(0).toUpperCase() + status.slice(1); // Capitalize status
    modalStatus.className = 'badge'; // Reset classes

    // Apply correct class based on the status
    if (status === 'new') {
        modalStatus.classList.add('bg-success');
    } else if (status === 'in_progress') {
        modalStatus.classList.add('bg-warning');
    } else if (status === 'answered') {
        modalStatus.classList.add('bg-primary');
    } else if (status === 'closed') {
        modalStatus.classList.add('bg-secondary');
    }
});
</script>

<style>
    tr.align-middle[data-status="closed"] td {
        background: #eaeaea;
        background-color: #eaeaea;
        opacity: 0.5;
    }
</style>
@endsection

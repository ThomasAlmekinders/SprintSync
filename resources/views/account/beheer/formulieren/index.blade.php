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
                                <span class="badge font-weight-bold 
                                    @if($submission->status == 'new') bg-success 
                                    @elseif($submission->status == 'in_progress') bg-warning 
                                    @elseif($submission->status == 'answered') bg-primary 
                                    @elseif($submission->status == 'closed') bg-secondary 
                                    @endif">
                                    {{ $submission->status }}
                                </span>
                            </td>
                            <td class="text-end">
                            <a href="#" class="btn btn-sm text-primary text-info text-nowrap font-weight-bold" data-bs-toggle="modal" data-bs-target="#submissionModal" 
                                data-id="{{ $submission->id }}"
                                data-status="{{ $submission->status }}"
                                data-first-name="{{ $submission->first_name }}" 
                                data-last-name="{{ $submission->last_name }}" 
                                data-email="{{ $submission->email }}" 
                                data-phone="{{ $submission->phone_number ?? 'Niet opgegeven' }}" 
                                data-message="{!! nl2br(e($submission->message)) !!}" 
                                data-ip="{{ $submission->ip_address }}" 
                                data-created-at="{{ $submission->created_at->format('d-m-Y H:i') }}">Bekijk</a>

                            </td>
                            <td class="text-end">
                                <form action="{{ route('beheer.formulieren.delete', $submission->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm ms-2 text-danger font-weight-bold" onclick="return confirm('Weet je zeker dat je deze inzending wilt verwijderen?');">Verwijderen</button>
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
                <div class="mb-3">
                    <strong>Naam:</strong> <span id="modalFirstName"></span> <span id="modalLastName"></span>
                </div>
                <div class="mb-3">
                    <strong>Email:</strong> <span id="modalEmail"></span>
                </div>
                <div class="mb-3">
                    <strong>Telefoon:</strong> <span id="modalPhone"></span>
                </div>

                <h6><strong>Bericht:</strong></h6>
                <div id="modalMessage" class="bg-light p-3 rounded text-dark" style="white-space: pre-wrap;"></div>

                <div class="mt-4">
                    <small><strong>IP-adres:</strong> <span id="modalIp" class="text-muted"></span></small><br>
                    <small><strong>Verzonden op:</strong> <span id="modalCreatedAt" class="text-muted"></span></small>
                </div>
            </div>
            <div class="modal-footer">                
                <form id="statusUpdateForm" action="{{ route('beheer.formulieren.update', ':id') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <select id="statusSelect" name="status" class="form-select">
                            <option value="new">Nieuw</option>
                            <option value="in_progress">In Behandeling</option>
                            <option value="answered">Beantwoord</option>
                            <option value="closed">Gesloten</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
                
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluiten</button>
            </div>
        </div>
    </div>
</div>

<script defer>
    const modal = document.getElementById('submissionModal');
    modal.addEventListener('show.bs.modal', (event) => {
        const button = event.relatedTarget;
        const submissionId = button.getAttribute('data-id');
        const status = button.getAttribute('data-status');
        const firstName = button.getAttribute('data-first-name');
        const lastName = button.getAttribute('data-last-name');
        const email = button.getAttribute('data-email');
        const phone = button.getAttribute('data-phone');
        const message = button.getAttribute('data-message');
        const ip = button.getAttribute('data-ip');
        const createdAt = button.getAttribute('data-created-at');

        modal.querySelector('#modalFirstName').innerHTML = firstName;
        modal.querySelector('#modalLastName').innerHTML = lastName;
        modal.querySelector('#modalEmail').innerHTML = email;
        modal.querySelector('#modalPhone').innerHTML = phone;
        modal.querySelector('#modalMessage').innerHTML = message;
        modal.querySelector('#modalIp').innerHTML = ip;
        modal.querySelector('#modalCreatedAt').innerHTML = createdAt;

        modal.querySelector('#statusSelect').value = status;

        const form = modal.querySelector('#statusUpdateForm');
        form.action = form.action.replace(':id', submissionId);

    });
</script>

<style>
    .font-weight-bold {
        font-weight: 600;
        font-size: .875rem;
    }


    tr.align-middle[data-status="closed"] td {
        background: #eaeaea;
        background-color: #eaeaea;
        opacity: 0.5;
    }
    tr.align-middle[data-status="new"] td {
        background: #d4edda;
        background-color: #d4edda;
        color: #155724;
    }
    tr.align-middle[data-status="in_progress"] td {
        background: #fff3cd;
        background-color: #fff3cd;
        color: #856404;
    }
    tr.align-middle[data-status="answered"] td {
        background: #cce5ff;
        background-color: #cce5ff;
        color: #004085;
    }
</style>
@endsection

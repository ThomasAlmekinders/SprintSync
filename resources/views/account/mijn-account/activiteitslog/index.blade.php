@extends('account.mijn-account.index')

@section('account-content')
<div id="activity-log" class="tab-pane fade show active" role="tabpanel" aria-labelledby="activity-log-tab">
    <div class="px-3 py-4">
        <h3>Activiteitslog</h3>
        @if($activityLogs->isEmpty())
            <p>Geen activiteiten gevonden.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <colgroup>
                        <col style="min-width: 175px;">
                        <col style="min-width: 175px;">
                        <col style="min-width: 350px;">
                        <col style="min-width: 150px;">
                        <col style="min-width: 300px;">
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="text-nowrap">Tijd</th>
                            <th class="text-nowrap">Log naam</th>
                            <th class="text-nowrap">Log beschrijving</th>
                            <th class="text-nowrap">IP adres</th>
                            <th class="text-nowrap">User agent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activityLogs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('d-m-Y H:i:s') }}</td>
                                <td>{{ $log->log_name }}</td>
                                <td>{{ $log->log_description }}</td>
                                <td>{{ $log->ip_address ?? 'Onbekend' }}</td>
                                <td>{{ $log->user_agent ?? 'Onbekend' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection

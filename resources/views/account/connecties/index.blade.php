@extends('layouts.app')

@section('content')
<div class="container-xxl py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <h1 class="mb-4">Connecties</h1>
            
            <!-- Zoekbalk -->
            <div class="search-container">
                <form id="search-form" class="mb-4">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Zoek naar een persoon..." aria-label="Zoek naar een persoon..." id="search-input" name="search" autocomplete="off">
                    </div>
                </form>
                <!-- Fade background -->
                <div class="search-fade" id="searchFade"></div>
                <!-- Zoekresultaten -->
                <div class="search-results" id="resultsList" style="display: none;"></div>
            </div>

            <!-- Connecties Lijst -->
            <h2 class="mt-4">Lijst van Connecties</h2>
            <div id="connectionsList" class="list-group">
                @foreach($connections as $connection)
                    <a class="list-group-item list-group-item-action d-flex align-items-center"
                       href="/connecties/bekijk/{{ $connection->first_name }}-{{ $connection->last_name }}/{{ $connection->id }}"
                       title="Bekijk het profiel van {{ $connection->first_name }} {{ $connection->last_name }}">
                        <img src="/images/profile_pictures/{{ $connection->profile_picture }}" alt="Profielfoto" class="img-fluid rounded-circle me-2" style="width: 50px; height: 50px;">
                        <div>
                            <h6 class="mb-1">{{ $connection->first_name }} {{ $connection->last_name }}</h6>
                            <p class="mb-0 text-muted"><span>@</span>{{ $connection->username }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

        </div>
    </div>
</div>

<!-- Persoon modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Gebruiker Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center  px-3 py-5">
                <div class="user-profile">
                    <img src="" alt="Profielfoto" id="userProfilePic" class="img-fluid rounded-circle mb-3" style="width: 100px; height: 100px;">
                    <h6 id="userFullName" class="mb-1"></h6>
                    <p id="userUsername" class="text-muted">@<span></span></p>
                </div>
                <div aria-live="polite" aria-atomic="true" style="position: relative;">
                    <div class="toast" id="errorToast" style="width: 100%; display: none;">
                        <div class="toast-body" id="toastMessage"></div>
                    </div>
                </div>
                <p id="userDetails"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-close-modal" data-bs-dismiss="modal">Sluiten</button>
                <button type="button" class="btn btn-primary" id="addConnectionBtn">Voeg toe als connectie</button>
            </div>
        </div>
    </div>
</div>

<script>
    let debounceTimeout;
    const currentUserId = {{ auth()->user()->id }};

    const closeModalButtons = document.querySelectorAll('.btn-close, .btn-close-modal');
    const overlay = document.createElement('div');

    document.getElementById('search-input').addEventListener('input', function() {
        const query = this.value.trim();

        clearTimeout(debounceTimeout);

        if (query === '') {
            document.getElementById('resultsList').innerHTML = '';
            document.getElementById('searchFade').style.display = 'none';
            document.getElementById('resultsList').style.display = 'none';

            return;
        }

        if (query.length >= 3) {
            document.getElementById('searchFade').style.display = 'block';
            document.getElementById('resultsList').style.display = 'block';


            debounceTimeout = setTimeout(() => {
                searchUsers(query);
            }, 300);
        } else {
            document.getElementById('searchFade').style.display = 'none';
            document.getElementById('resultsList').innerHTML = '';
        }
    });

    document.getElementById('searchFade').addEventListener('click', function() {
        this.style.display = 'none';
        document.getElementById('resultsList').innerHTML = '';
    });

    function searchUsers(query) {
        fetch(`/connecties/zoeken?query=${encodeURIComponent(query)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                updateResultsList(data);
            })
            .catch(error => {
                updateResultsList([]);
            });
    }

    function updateResultsList(users) {
        const resultsList = document.getElementById('resultsList');
        resultsList.innerHTML = '';

        console.log(users);

        if (users.length === 0) {
            const noResultsMessage = document.createElement('li');
            noResultsMessage.innerHTML = 'Geen resultaten';
            noResultsMessage.classList.add('text-muted', 'italic');
            resultsList.appendChild(noResultsMessage);
        } else {
            users.forEach(user => {
                const listItem = document.createElement('li');

                const userLink = document.createElement('a');
                userLink.textContent = user.first_name + " " + user.last_name;

                if (user.id === currentUserId) { 
                    // Als het de huidige gebruiker is, geen link toevoegen
                    userLink.href = '#';
                    userLink.style.pointerEvents = 'none';
                    userLink.textContent += ' (Jij)';
                    userLink.style.fontStyle = 'italic';
                    userLink.style.color = 'gray';
                } else {
                    // Voeg een geldige URL toe voor andere gebruikers
                    userLink.href = `/connecties/view?id=${user.id}`;
                    userLink.addEventListener('click', (event) => {
                        event.preventDefault();
                        showUserModal(user); 
                    });
                }

                listItem.appendChild(userLink);
                resultsList.appendChild(listItem);
            });
        }
    }
    
    closeModalButtons.forEach(button => {
        button.addEventListener('click', function () {
            hideUserModal();
        });
    });

    function showUserModal(user) {
        document.getElementById('userProfilePic').src = "/images/profile_pictures/" + user.profile_picture;
        document.getElementById('userFullName').textContent = user.first_name + " " + user.last_name;
        document.getElementById('userUsername').querySelector('span').textContent = user.unique_id;
        
        document.getElementById('userModal').classList.add('zoom-in', 'show');
        document.getElementById('userModal').style.display = 'block';
        overlay.classList.add('show');
        document.body.classList.add('modal-open');
        overlay.classList.add('modal-backdrop', 'fade');
        document.body.appendChild(overlay);

        document.getElementById('addConnectionBtn').onclick = () => {
            addConnection(user.id); 
        };
    }
    function hideUserModal() {
        document.getElementById('userModalLabel').textContent = " ";
        document.getElementById('userDetails').textContent = "";

        document.getElementById('userModal').classList.remove('zoom-in');
        document.getElementById('userModal').classList.add('zoom-out');

        document.getElementById('userModal').addEventListener('animationend', function handler() {
            document.getElementById('userModal').classList.remove('zoom-out', 'show');
            document.getElementById('userModal').style.display = 'none';
            overlay.classList.remove('show');
            document.body.classList.remove('modal-open');
            overlay.remove();
            document.getElementById('userModal').removeEventListener('animationend', handler);
        });
    }

    function addConnection(userId) {

        fetch(`/connecties/toevoegen/${userId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (response.ok) {
                document.getElementById('userModal').style.display = 'none';
                document.querySelector('.modal-backdrop').classList.remove('show');
                document.querySelector('.modal-backdrop').style.display = 'none';
                document.querySelector('body').classList.remove('modal-open');
                location.reload(); 
            }
        })
        .catch(error => {
            console.error('Er is een fout opgetreden:', error);
            toastMessage.textContent = 'Er is een netwerkfout opgetreden. Probeer het opnieuw.';
        });
    }

</script>

<style>
    .search-fade {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 10;
        display: none;
    }

    .search-container {
        position: relative;
        z-index: 20;
    }

    #search-input {
        z-index: 30;
        position: relative;
    }

    .search-results {
        position: absolute;
        top: 100%;
        left: 10px;
        right: 0px;
        width: calc(100% - 20px);
        background-color: white;
        z-index: 30;
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #ddd;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .search-results li {
        cursor: pointer;
    }
    .search-results li:not(:last-of-type) {
        border-bottom: 1px solid grey;
    }
    .search-results li a {
        width: 100%;
        height: 100%;
        display: block;
        padding: 10px;
    }

    .search-results li:hover {
        background-color: #f0f0f0;
    }

    .no-results {
        padding: 10px;
        color: red;
        font-weight: bold;
    }

    .toast {
        background: #d01313;
        background-color: #d01313;
    }

    @media only screen and (max-width: 600px) {
        #userModal .btn {
            width: 100%;
        }
    }

    #connectionsList a:hover {
        cursor: pointer;
    }
</style>
@endsection

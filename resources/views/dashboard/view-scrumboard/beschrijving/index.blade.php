@extends('dashboard.view-scrumboard.index')

@section('dashboard-content')
<div id="activity-log" class="tab-pane fade show active" role="tabpanel" aria-labelledby="activity-log-tab">
    <div class="px-3 py-4">
        <h3>{{ $scrumboard->title }}</h3>
        <div class="description-block p-3">
            <div id="description-content">
                <p>{{ $scrumboard->description }}</p>
            </div>
            <div id="fade-out"></div>
        </div>
        <button id="toggle-description" class="btn btn-link p-0 mt-2">
            <div class="read-more">
                <span class="align-middle">Lees meer</span>
                <span class="material-icons align-middle">keyboard_arrow_down</span>
            </div>
            <div class="read-less">
                <span class="align-middle">Lees minder</span>
                <span class="material-icons align-middle">keyboard_arrow_up</span>
            </div>
        </button>
    </div>

    <div class="chat-section px-3 py-4">
        <h3>Chat</h3>

        <form method="POST" action="{{ route('scrumboard.store-chat', ['slug' => Str::slug($scrumboard->title), 'id' => $scrumboard->id]) }}">
            @csrf
            <textarea id="chat-message" name="message" rows="3" class="form-control" placeholder="Type je bericht hier..." required></textarea>
            <button type="submit" class="btn btn-primary mt-2">Verstuur</button>
        </form>

        <div class="sent-chats position-relative" id="sent-chats" style="padding-bottom: 3rem;">
            @if ($chats->isNotEmpty())
                @foreach ($chats as $chat)
                    <div class="chat-message mb-2" id="chat-{{ $chat->id }}">
                        <div class="d-flex align-items-start">
                            <img src="/images/profile_pictures/{{ $chat->user->profile_picture }}" alt="{{ $chat->user->first_name }}" class="rounded-circle" width="40" height="40">
                            <div class="ms-2 position-relative w-100">
                                <strong>{{ $chat->user->first_name }} {{ $chat->user->last_name }}</strong>
                                <p class="mb-0 chat-text" data-chat-id="{{ $chat->id }}">{{ $chat->message }}</p>
                                <small class="text-muted">{{ $chat->created_at }}</small>
                                <div class="position-absolute d-flex" style="right: 0; bottom: 0;">
                                    <button class="btn edit-chat text-primary" data-chat-id="{{ $chat->id }}">
                                        <span class="material-icons align-middle">edit</span>
                                    </button>
                                    <form method="POST" action="{{ route('scrumboard.delete-chat', ['slug' => Str::slug($scrumboard->title), 'id' => $scrumboard->id, 'chatId' => $chat->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn" onclick="return confirm('Weet je zeker dat je dit bericht wilt verwijderen?');">
                                            <span class="material-icons align-middle text-danger">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="edit-form d-none" id="edit-form-{{ $chat->id }}">
                        <form method="POST" action="{{ route('scrumboard.edit-chat', ['slug' => Str::slug($scrumboard->title), 'id' => $scrumboard->id, 'chatId' => $chat->id]) }}">
                            @csrf
                            <textarea name="new_message" class="form-control" required>{{ $chat->message }}</textarea>
                            <button type="submit" class="btn btn-link text-primary">Opslaan</button>
                            <button type="button" class="btn btn-link text-secondary cancel-edit" data-chat-id="{{ $chat->id }}">Annuleren</button>
                        </form>
                    </div>
                @endforeach
                <button id="toggle-chat" 
                        class="btn btn-link  position-absolute" 
                        style="bottom: 5px;"
                        data-offset="{{ $chats->count() }}">
                    <span>Bekijk meer berichten ></span>
                </button>
            @else
                <p>Er zijn nog geen chat berichten.</p>
            @endif
        </div>

    </div>
</div>

<script defer>
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('toggle-chat')) {
            document.getElementById('toggle-chat').addEventListener('click', function() {
                const offset = this.getAttribute('data-offset');
                const slug = '{{ Str::slug($scrumboard->title) }}';
                const id = '{{ $scrumboard->id }}';
                
                const actionUrl = `{{ route('scrumboard.load-more-chats', ['slug' => '__SLUG__', 'id' => '__ID__', 'offset' => '__OFFSET__']) }}`;
                const finalUrl = actionUrl.replace('__SLUG__', slug)
                                            .replace('__ID__', id)
                                            .replace('__OFFSET__', offset);

                fetch(finalUrl)
                    .then(response => response.json())
                    .then(data => {
                        const chatContainer = document.getElementById('sent-chats');
                        data.forEach(chat => {
                            const createdAtDate = new Date(chat.created_at);
                            const formattedDate = createdAtDate.toLocaleString('nl-NL', {
                                year: 'numeric',
                                month: '2-digit',
                                day: '2-digit',
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit'
                            });

                            const editSlug = '{{ Str::slug($scrumboard->title) }}';
                            const editId = '{{ $scrumboard->id }}';
                            const editChatId = `${chat.id}`;

                            const editMessageUrl = `{{ route('scrumboard.edit-chat', ['slug' => '__SLUG__', 'id' => '__ID__', 'chatId' => '__CHAT_ID__']) }}`;
                            const editMessageFinalUrl = editMessageUrl.replace('__SLUG__', editSlug)
                                                                        .replace('__ID__', editId)
                                                                        .replace('__CHAT_ID__', editChatId);

                            const chatMessage = `
                                <div class="chat-message mb-2" id="chat-${chat.id}">
                                    <div class="d-flex align-items-start">
                                        <img src="/images/profile_pictures/${chat.user.profile_picture}" alt="${chat.user.first_name}" class="rounded-circle" width="40" height="40">
                                        <div class="ms-2 position-relative w-100">
                                            <strong>${chat.user.first_name} ${chat.user.last_name}</strong>
                                            <p class="mb-0 chat-text" data-chat-id="${chat.id}">${chat.message}</p>
                                            <small class="text-muted">${formattedDate}</small>
                                            <div class="position-absolute d-flex" style="right: 0; bottom: 0;">
                                                <button class="btn edit-chat text-primary" data-chat-id="${chat.id}">
                                                    <span class="material-icons align-middle">edit</span>
                                                </button>
                                                <form method="POST" action="/dashboard/bekijk/${slug}/${id}/beschrijving/delete-chat/${chat.id}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn" onclick="return confirm('Weet je zeker dat je dit bericht wilt verwijderen?');">
                                                        <span class="material-icons align-middle text-danger">delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="edit-form d-none" id="edit-form-${chat.id}">
                                    <form method="POST" action="${editMessageFinalUrl}">
                                        @csrf
                                        <textarea name="new_message" class="form-control" required>${chat.message}</textarea>
                                        <button type="submit" class="btn btn-link text-primary">Opslaan</button>
                                        <button type="button" class="btn btn-link text-secondary cancel-edit" data-chat-id="${chat.id}">Annuleren</button>
                                    </form>
                                </div>`;
                            chatContainer.insertAdjacentHTML('beforeend', chatMessage);
                            useEventListener(this);
                        });
                        this.setAttribute('data-offset', parseInt(offset) + data.length);
                        if (data.length < 5) {
                            this.style.display = 'none';
                        }
                    });
            });
        } else {
            /* Hier doen we niks */
        }
    });
</script>

<script defer>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-chat');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                openEditChat(this);
            });
        });

        const cancelButtons = document.querySelectorAll('.cancel-edit');
        cancelButtons.forEach(button => {
            button.addEventListener('click', function() {
                closeEditChat(this);
            });
        });
    });

    function useEventListener() {
        const editButtons = document.querySelectorAll('.edit-chat');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                openEditChat(this);
            });
        });

        const cancelButtons = document.querySelectorAll('.cancel-edit');
        cancelButtons.forEach(button => {
            button.addEventListener('click', function() {
                closeEditChat(this);
            });
        });
    }

    function openEditChat(item) {
        const chatId = item.dataset.chatId;
        const chatText = document.querySelector(`#chat-${chatId} .chat-text`);
        const editForm = document.getElementById(`edit-form-${chatId}`);

        chatText.classList.add('d-none');
        editForm.classList.remove('d-none');
    }
    function closeEditChat(item) {
        const chatId = item.dataset.chatId;
        const chatText = document.querySelector(`#chat-${chatId} .chat-text`);
        const editForm = document.getElementById(`edit-form-${chatId}`);

        chatText.classList.remove('d-none');
        editForm.classList.add('d-none');
    }
</script>

<script defer>
    document.addEventListener('DOMContentLoaded', function() {
        
        const descBlockHeight = document.querySelector('#description-content').getBoundingClientRect().height;
        const descBlock = document.querySelector('#description-content');
        const descBlockFade = document.querySelector('.description-block #fade-out');
        const descBlockReadMore = document.querySelector('#toggle-description .read-more');
        const descBlockReadLess = document.querySelector('#toggle-description .read-less');

        if (descBlockHeight > 200) {
            descBlock.style.height = "200px";
            descBlockFade.style.display = "block";
            descBlockReadLess.style.display = "none";
        } else {
            descBlockReadMore.style.display = "none";
            descBlockReadLess.style.display = "none";
        }

        descBlockReadMore.addEventListener('click', function() {
            descBlock.style.height = `${descBlockHeight}px`;
            descBlockFade.style.display = "none";
            descBlockReadMore.style.display = "none";
            setTimeout(() => {
                descBlockReadLess.style.display = "block";
            }, 310);
        });
        descBlockReadLess.addEventListener('click', function() {
            descBlock.style.height = "200px";
            descBlockFade.style.display = "block";
            descBlockReadLess.style.display = "none";
            setTimeout(() => {
                descBlockReadMore.style.display = "block";
            }, 310);
            
        });

    });
</script>

<style>
    .description-block {
        overflow: hidden;
        position: relative;
    }

    #description-content {
        transition: height .3s ease-in-out;
    }

    #fade-out {
        position: absolute; 
        bottom: 0; 
        left: 0; 
        width: 100%; 
        height: 50px; 
        
        background: linear-gradient(transparent, #f8fafc); 
        
        display: none;
    }

    .chat-section {
        border-top: 1px solid #e9ecef;
        margin-top: 20px;
    }
    .new-chat-message {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
    }
    .chat-message {
        padding: 10px;
        border-bottom: 1px solid #e9ecef;
    }
    .sent-chats .chat-message:last-of-type {
        border-bottom: none;
    }
</style>
@endsection

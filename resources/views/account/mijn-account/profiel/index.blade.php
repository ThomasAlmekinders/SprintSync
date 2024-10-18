@extends('account.mijn-account.index')

@section('account-content')
<div id="profile" class="tab-pane fade show active" role="tabpanel" aria-labelledby="profile-tab">
    <div class="px-4 py-5">
        <h3 class="mb-4">Profiel</h3>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <!-- Profile Details Form -->
            <div class="col-12 mb-5">
                <form method="POST" action="{{ route('mijn-account.update-profile-user') }}" enctype="multipart/form-data" id="profile-form">
                    @csrf
                    <div class="mb-4">
                        <label for="username" class="form-label">{{ __('Gebruikersnaam') }}</label>
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ Auth::user()->username }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="profile_bio" class="form-label">{{ __('Profiel Bio') }}</label>
                        <textarea id="profile_bio" class="form-control @error('profile_bio') is-invalid @enderror" name="profile_bio" rows="3">{{ Auth::user()->profile_bio }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Wijzigingen opslaan</button>
                </form>
            </div>

            <!-- Profile Picture Form -->
            <div class="col-12 mt-5">
                <div class="card p-3 shadow-sm">
                    <h6 class="mb-3">Profielfoto Uploaden:</h6>
                    <form method="POST" action="{{ route('mijn-account.update-profile-picture') }}" enctype="multipart/form-data" id="profile-picture-form">
                        @csrf
                        <div class="mb-4">
                            <label for="profile_picture" class="form-label">{{ __('Upload een nieuwe profielfoto') }}</label>
                            <input id="profile_picture" type="file" class="form-control @error('profile_picture') is-invalid @enderror" name="profile_picture" required accept="image/*">
                        </div>

                        <div class="mb-4">
                            <h6 id="image-preview-title" style="display: none;">Afbeelding Preview:</h6>
                            <div class="img-container mb-3">
                                <img id="image-preview" class="rounded-circle shadow-sm" style="max-width: 100%; display: none;">
                            </div>
                            <button type="button" class="btn btn-primary" style="display: none;" id="crop-btn">Afbeelding Bijsnijden & Bijwerken</button>
                        </div>
                    </form>

                    <!-- Current Profile Picture -->
                    <div class="mt-4 text-center">
                        <h6>Huidige Profielfoto:</h6>
                        @if(Auth::user()->profile_picture)
                            <div class="profile-picture-container mb-3">
                                <img src="{{ asset('images/profile_pictures/' . Auth::user()->profile_picture) }}" alt="Profielfoto" class="img-thumbnail rounded-circle shadow-sm profile-picture" style="width: 120px; height: 120px;">
                            </div>
                        @else
                            <p>Je hebt nog geen profielfoto geüpload.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script defer>
    document.getElementById('profile_picture').addEventListener('change', function(event) {
        
        var files = event.target.files;
        if (files && files.length > 0) {
            var file = files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                var imagePreview = document.getElementById('image-preview');
                var cropBtn = document.getElementById('crop-btn');

                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                cropBtn.style.display = 'block';

                var cropper = new Cropper(imagePreview, {
                    aspectRatio: 1,
                    viewMode: 1,
                });

                cropBtn.onclick = function() {
                    var canvas = cropper.getCroppedCanvas({
                        width: 150,
                        height: 150,
                    });

                    var fileType = file.type.split('/')[1];

                    canvas.toBlob(function(blob) {
                        var formData = new FormData();
                        formData.append('profile_picture', blob, 'profile_picture.' + fileType);

                        fetch('{{ route('mijn-account.update-profile-picture') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(data => {
                            if (data.filename) {
                                document.querySelector('.img-thumbnail').src = data.filename;
                                document.querySelector('.profile-img').src = data.filename;
                            }

                            cropper.destroy();
                            imagePreview.style.display = 'none';
                            cropBtn.style.display = 'none';
                            document.getElementById('profile_picture').value = '';

                            window.location.reload();
                        })
                        .catch(error => {
                            console.error('Custom error (1): ', error);
                        });
                    });
                }
            }

            reader.readAsDataURL(file);
        }
    });
</script>
@endsection

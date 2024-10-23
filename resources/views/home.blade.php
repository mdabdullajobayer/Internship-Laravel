@extends('layouts.admin', ['title' => 'My Profile'])

@section('mainContent')
    <div class="container">
        <div class="d-flex justify-content-between">
            <div class="d-flex gap-3">
                <div class="rounded-lg">
                    <img class="rounded" id="imgSrc" alt="profile_image" height="80px"/>
                </div>
                <div>
                    <h2 class="fw-bold font-bold">{{ auth()->user()->name }}</h2>
                    <span class="badge bg-warning fs-6 text-capitalize">{{ auth()->user()->user_type }}</span>
                </div>
            </div>
            <div>
                <form id="uploadForm" enctype="multipart/form-data">
                    <div class="upload-container">
                        <label for="image" class="file-uploader">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-upload" viewBox="0 0 16 16">
                                <path
                                    d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                                <path
                                    d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z" />
                            </svg>
                            <input type="file" class="d-none" id="image" name="profile_pic" accept="image/*"
                                required />
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update Profile Picture</button>
                </form>
                <div id="message"></div>
            </div>

        </div>

    </div>

    <script>
        $(document).ready(function() {
            $('#uploadForm').on('submit', function(e) {
                e.preventDefault();
                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('profile.update') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        $('#message').html('<p>' + response['success'] +
                            '</p>');
                     $("#imgSrc").attr('src', loadImage())
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('#message').html('<p>Error: ' + textStatus +
                            '</p>');
                    }
                });
            });
        });

        function loadImage() {
            let url = "{{ auth()->user()->profile_pic }}";

            if (url.match(/\.(jpeg|jpg|gif|png)$/) != null) {
                return "{{ asset('storage') }}"+"/" + url;
            } else {
                return "https://ui-avatars.com/api/?background=random&color=fff&name={{ auth()->user()->name }}"
            }
        }

        $("#imgSrc").attr('src', loadImage())
    </script>
@endsection

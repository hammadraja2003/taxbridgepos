<!-- @props(['key'])

@if(session()->has($key))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get($key) }}</div>
@endif -->

@props(['key'])

@if(session()->has($key))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Toastify({
                text: "{{ session()->get($key) }}",
                duration: 3000,
                gravity: "top", // top or bottom
                position: "right", // left, center or right
                close: true,
                backgroundColor: "#28a745", // success green
                stopOnFocus: true
            }).showToast();
        });
    </script>
@endif

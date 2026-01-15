<!-- @props(['key'])

@if(session()->has($key))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get($key) }}</div>
@endif -->

@props(['key'])

@if(session()->has($key))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Toastify({
                text: "{{ session()->get($key) }}",
                duration: 4000,
                gravity: "top",
                position: "right",
                close: true,
                backgroundColor: "#dc3545", // Bootstrap danger red
                stopOnFocus: true
            }).showToast();
        });
    </script>
@endif

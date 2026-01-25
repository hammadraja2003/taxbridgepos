<!-- @props(['key'])

@if(session()->has($key))
  <div class="alert alert-warning alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get($key) }}</div>
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
                backgroundColor: "#ffc107", // Bootstrap warning yellow
                textColor: "#000",
                stopOnFocus: true
            }).showToast();
        });
    </script>
@endif

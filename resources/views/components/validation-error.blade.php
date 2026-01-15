<!-- @props(['fieldName'])

@error($fieldName)
<div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ $message }}
</div>
@enderror -->

@props(['fieldName'])

@error($fieldName)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Toastify({
                text: "{{ $message }}",
                duration: 4000,
                gravity: "top",
                position: "right",
                close: true,
                backgroundColor: "#dc3545", // Bootstrap danger red
                stopOnFocus: true
            }).showToast();
        });
    </script>
@enderror

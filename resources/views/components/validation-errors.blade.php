@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let errorMessage = `
                <div class="font-medium text-black-600">Whoops! Something went wrong.</div>
                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            `;

            Swal.fire({
                icon: 'error',
                html: errorMessage, // Use 'html' to allow list rendering
                confirmButtonText: 'Ok'
            });
        });
    </script>
@endif

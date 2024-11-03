@include('users.nav')

<div class="container mx-auto p-4">
    <!-- Container for the Appointment Form -->
    <div class="mx-14 mt-10 bg-white rounded-lg shadow-lg">
        <!-- Contact Us Title -->
        <!-- Make an Appointment Title -->
        <!-- <div class="mt-3 text-center text-4xl font-bold">Profile Management</div> -->


        <!-- Form Section -->
        <div class="p-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
            @livewire('profile.update-profile-information-form')

            <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            <div class="mt-10 sm:mt-0">
                @livewire('profile.update-password-form')
            </div>

            <x-section-border />
            @endif
        </div>

    </div>
</div>

</main>



@include('users.user-script')


</body>

</html>
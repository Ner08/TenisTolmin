<x-layout-login>
    @title('Prijava - Tenis Tolmin')
    <style>
        /* Style for autocomplete background color */
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0px 1000px #4b5563 inset !important;
            -webkit-text-fill-color: white !important;
        }

        /* Custom CSS for adjusting login container height */
        .login-container {
            min-height: calc(100vh - 4rem);
            /* Adjusted height based on viewport height and navbar height */
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #1f2937;
            /* Same as bg-gray-800 */
        }

        /* Optional: Adjust the padding/margin of the form container */
        .form-container {
            width: 100%;
            max-width: 24rem;
            /* Adjust this value as needed */
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0 1rem rgba(0, 0, 0, 0.1);
            background-color: #374151;
            /* Same as bg-gray-700 */
        }

        /* Optional: Adjust form input styles */
        .form-input {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: none;
            /* Remove border */
            border-radius: 0.25rem;
            background-color: #4b5563;
            /* Same as bg-gray-600 */
            color: #fff;
            /* Same as text-white */
        }

        /* Optional: Adjust form button styles */
        .form-button {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 0.25rem;
            background-color: #2563eb;
            /* Same as bg-indigo-600 */
            color: #fff;
            /* Same as text-white */
            cursor: pointer;
        }
    </style>

    <div class="login-container">
        <div class="form-container">
            <div class="text-center">
                <img class="mx-auto h-12 w-auto" src="{{ asset('images/logo10.png') }}" alt="logo">
                <h2 class="mt-4 text-center text-3xl font-extrabold text-white">
                    Prijavite se v vaš račun
                </h2>
            </div>
            <form class="mt-4 space-y-4" action="{{ route('authenticate') }}" method="POST">
                @csrf
                <input type="hidden" name="remember" value="true">
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="email" class="sr-only">Uporabniško ime / E-mail</label>
                        <input id="email" name="email" type="text" autocomplete="email" required
                            class="form-input" placeholder="Uporabniško ime / E-mail" >
                    </div>
                    <div>
                        <label for="password" class="sr-only">Geslo</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="form-input" placeholder="Geslo" >
                    </div>
                    @error('email')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="form-checkbox"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="ml-2 block text-sm text-gray-300">
                            Zapomni se me
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-indigo-400 hover:text-indigo-500">
                            Pozabili geslo?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit" class="form-button">
                        Prijava
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-layout-login>

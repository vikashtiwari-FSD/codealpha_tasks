<x-app-layout>

    <div class="py-12">

        <div class="max-w-xl mx-auto bg-white shadow rounded-lg p-6">

            <h2 class="text-2xl font-bold mb-6">
                Security Verification
            </h2>

            <p class="mb-4 text-gray-600">
                Enter your Capability Code to access the protected security area.
            </p>

            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('security.verify') }}">

                @csrf

                <div>

                    <label class="block font-medium">
                        Capability Code
                    </label>

                    <input
                        type="password"
                        name="capability_code"
                        class="w-full border rounded mt-2 p-2"
                        required>

                </div>

                <button
                    type="submit"
                    class="mt-6 bg-blue-600 text-black px-5 py-2 rounded">

                    Verify

                </button>

            </form>

        </div>

    </div>

</x-app-layout>
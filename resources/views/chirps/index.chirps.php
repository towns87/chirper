<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('chirps.store') }}">
            @csrf
            <textarea
                name="message"
                placeholder="{{ __('What\'s on your mind?') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <x-primary-button class="mt-4">{{ __('Chirp') }}</x-primary-button>
            <x-label for='tags'>Tags</x-label>
            <x-input type="text" name="tags" id="tags" placeholder="Enter tags separated by commas"/>
            <x-button type="text" name="tag-button" id="tags">Tag someone!</x-button>
            <x-button type="text" name="review" id="review">Tell us what you think!</x-button>
        </form>
    </div>
</x-app-layout>
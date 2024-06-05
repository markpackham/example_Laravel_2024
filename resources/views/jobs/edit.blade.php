<x-layout>
    <x-slot:heading>
      Edit Job: {{$job->title}}
    </x-slot:heading>
  
    <form method="POST" action="/jobs">
      {{-- Cross-Site Request Forgery (CSRF) token generation for Post requests otherwise we get an HTTP 419--}}
      {{-- "HTTP response status code 419 Page Expired is an unofficial client error that is Laravel-specific 
      and returned by the server to indicate that the Cross-Site Request Forgery (CSRF) validation has failed."
      https://http.dev/419 --}}
      @csrf
  
      <div class="space-y-12">
        <div class="border-b border-gray-900/10 pb-12">

          <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-4">
              <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Title</label>
              <div class="mt-2">
                <div
                  class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                  <input type="text" name="title" id="title" autocomplete="title"
                    class="block flex-1 border-0 bg-transparent py-1.5 px-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                    placeholder="Engineer" required>
                </div>
  
                {{-- Only concerns itself with title errors and no other ones --}}
                @error('title')
                <p class="text-red-500 font-semibold mt-1">{{$message}}
                </p>
                @enderror
              
              </div>
            </div>
  
            <div class="sm:col-span-4">
              <label for="salary" class="block text-sm font-medium leading-6 text-gray-900">Salary</label>
              <div class="mt-2">
                <div
                  class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                  <input type="text" name="salary" id="salary"
                    class="block flex-1 border-0 bg-transparent py-1.5 px-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                    placeholder="$20,000 Per Year" required>
                </div>
  
                @error('salary')
                <p class="text-red-500 font-semibold mt-1">{{$message}}
                </p>
                @enderror
  
                {{-- <div class="mt-10">
                  @if($errors->any())
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li class="text-red-500 italic">{{$error}}</li>
                    @endforeach
                  </ul>
                  @endif
                </div> --}}
             
              </div>
            </div>
  
            <div class="mt-6 flex items-center justify-end gap-x-6">
              <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
              <button type="submit"
                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
            </div>
    </form>
  
  </x-layout>
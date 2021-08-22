<!-- This example requires Tailwind CSS v2.0+ -->
<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto">
        <div class="py-2 align-middle inline-block min-w-full sm:px-1 lg:px-1">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    {{$head}}
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    {{$body}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

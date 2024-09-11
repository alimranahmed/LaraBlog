<div class="animate-pulse">
    <!-- Header Skeleton -->
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <div class="h-4 bg-gray-300 rounded w-1/4 mb-2"></div>
            <div class="h-3 bg-gray-300 rounded w-1/3"></div>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <div class="h-8 bg-gray-300 rounded w-32"></div>
        </div>
    </div>

    <!-- Table Skeleton -->
    <x-backend.table>
        <x-slot name="head">
            <tr>
                <th class="px-4 py-2">
                    <div class="h-4 bg-gray-300 rounded w-64"></div>
                </th>
                <th class="px-4 py-2 flex">
                    <div class="h-4 bg-gray-300 rounded w-16"></div>
                </th>
                <th class="px-4 py-2"></th>
            </tr>
        </x-slot>

        <x-slot name="body">
            <!-- Skeleton rows -->
            @for ($i = 0; $i < 3; $i++)
                <tr>
                    <!-- User info skeleton -->
                    <td class="p-4">
                        <div class="h-4 bg-gray-300 rounded w-1/2 mb-2"></div>
                        <div class="h-3 bg-gray-300 rounded w-1/4 mb-1"></div>
                        <div class="h-3 bg-gray-300 rounded w-1/3 mb-1"></div>
                        <div class="h-3 bg-gray-300 rounded w-1/2"></div>
                    </td>

                    <!-- Status skeleton -->
                    <td class="p-4">
                        <div class="flex">
                            <div class="h-6 w-10 bg-gray-300 rounded-full"></div>
                            <div class="h-4 bg-gray-300 rounded w-1/4 ml-3"></div>
                            <div class="h-4 bg-gray-300 rounded w-1/4 ml-3"></div>
                        </div>
                    </td>

                    <!-- Actions skeleton -->
                    <td class="p-4 flex justify-end">
                        <div class="h-4 bg-gray-300 rounded w-10 mb-1 mr-3"></div>
                        <div class="h-4 bg-gray-300 rounded w-10"></div>
                    </td>
                </tr>
            @endfor
        </x-slot>
    </x-backend.table>

    <!-- Pagination skeleton -->
    <div class="mt-3 flex justify-between w-full">
        <div class="h-2 bg-gray-300 rounded w-60"></div>
        <div class="h-8 bg-gray-300 rounded w-32"></div>
    </div>
</div>

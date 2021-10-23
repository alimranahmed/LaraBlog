<div>
    <div class="grid grid-cols-4 gap-3">
        @foreach($subscribers as $subscriber)
            <div class="rounded border border-indigo-300 pl-2">

                <div class="overflow-x-scroll">{{$subscriber->email}}</div>

                @if($subscriber->verified_at)
                    <div
                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Verified
                    </div>
                @else
                    <div class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        Not Verified
                    </div>
                @endif

                <div class="text-gray-500">{{$subscriber->created_date_time_formatted}}</div>

                @if($subscriber->unsubscribed_at)
                    <div class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">Unsubscribed</div>
                @endif
            </div>
        @endforeach
    </div>
</div>

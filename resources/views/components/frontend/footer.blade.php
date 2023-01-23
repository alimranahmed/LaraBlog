</div>
<div class="mt-4 p-4 border-t border-blue-200 md:flex md:justify-between text-center">
    <div>
        <?php echo '&copy; ' . (new DateTime())->format('Y') . ' Al Imran Ahmed' ?>
        <div>Proudly build with: <a href="https://github.com/alimranahmed/larablog" class="text-indigo-600" target="_blank">Larablog</a></div>
    </div>

    <x-frontend.social-links class="justify-center my-3 md:my-0"/>

    <div>
        <a href="{{route('contact')}}" class="border-b border-dotted border-indigo-600">Contact</a>
    </div>
</div>

@livewireScripts
{{--<script src="{{ asset('js/prism.js') }}" defer></script>--}}

</body>
</html>

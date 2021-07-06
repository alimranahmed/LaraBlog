</div>
<div class="mt-4 py-4 border-t border-blue-200 text-center">
    <?php echo '&copy; ' . (new DateTime())->format('Y') . ' Al Imran Ahmed' ?>
</div>

@livewireScripts
<script src="{{ mix("build/js/app.js") }}"></script>
<script src="{{asset('js/prism.js')}}" defer></script>

</body>
</html>

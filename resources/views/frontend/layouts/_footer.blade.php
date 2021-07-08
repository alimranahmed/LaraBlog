</div>
<div class="mt-4 p-4 border-t border-blue-200 flex justify-between">
    <div>
        <?php echo '&copy; ' . (new DateTime())->format('Y') . ' Al Imran Ahmed' ?>
    </div>
    <div>
        <span>Follow Me: </span>
        <a href="{{route('articles')}}">B</a>
        <a href="https://github.com/alimranahmed" target="_blank">G</a>
        <a href="https://twitter.com/al_imran_cse" target="_blank">T</a>
        <a href="https://www.linkedin.com/in/alimrancse/" target="_blank">L</a>
        <a href="https://www.youtube.com/channel/UC14rfvux_ri5gC4l9AeV1UA" target="_blank">Y</a>
    </div>
    <div>
        <a href="{{route('contact')}}">Contact Me</a>
    </div>
</div>

@livewireScripts
<script src="{{ mix("build/js/app.js") }}"></script>
<script src="{{asset('js/prism.js')}}" defer></script>

</body>
</html>

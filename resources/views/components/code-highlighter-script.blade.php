<script src="{{asset("js/shiki/unpkg.com_shiki@0.14.3_dist_index.js")}}"></script>

<script>
    const htmlDecode = (input) => {
        const doc = new DOMParser().parseFromString(input, "text/html");
        return doc.documentElement.textContent;
    }

    shiki
        .getHighlighter({
            theme: 'material-theme',
            langs: ['js', 'php', 'python', 'shell', 'go', 'java'],
        })
        .then(highlighter => {
            const codeBlocks = document.querySelectorAll("pre code");
            codeBlocks.forEach((codeBlock) => {
                const language = codeBlock.className.split("-")[1];
                codeBlock.innerHTML = highlighter.codeToHtml(
                    htmlDecode(codeBlock.innerHTML),
                    {lang: language}
                )
            })
        })
</script>

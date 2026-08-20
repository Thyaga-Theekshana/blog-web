// Initialize EasyMDE Markdown Editor if the textarea exists
document.addEventListener("DOMContentLoaded", function () {
    const editorElement = document.getElementById("markdown-editor");
    if (editorElement) {
        new EasyMDE({
            element: editorElement,
            spellChecker: false,
            autosave: {
                enabled: false,
            },
            placeholder: "Write your blog content here using Markdown..."
        });
    }
});
<form action="/api/generate-ids" method="POST">
    @csrf
    <button type="submit">Generate IDs</button>
</form>

<p>Generated IDs: <span id="generated-ids"></span></p>

<?php require_once __DIR__ . '/../layouts/header.php' ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Upload CSV File</h2>
                    </div>
                    <div class="card-body">
                        <?php if (! empty($_SESSION['error'])): ?>
                            <div class="alert alert-danger" role="alert" id="server-error">
                                <?= htmlspecialchars($_SESSION['error']) ?>
                            </div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>

                        <div class="alert alert-danger" role="alert" id="js-error" style="display:none"></div>

                        <form action="/parse" method="post" enctype="multipart/form-data" id="csv-upload-form">
                            <div class="mb-3">
                                <label for="csv_file" class="form-label">Select CSV File</label>
                                <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv"
                                       required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
document.getElementById('csv-upload-form').addEventListener('submit', function(e) {
    var fileInput = document.getElementById('csv_file');
    var file = fileInput.files[0];
    var maxSize = 5 * 1024 * 1024; // 5 MB

    if (file && file.size > maxSize) {
        e.preventDefault();
        var jsError = document.getElementById('js-error');
        jsError.textContent = 'Файл слишком большой. Максимальный размер — 5 МБ.';
        jsError.style.display = 'block';
    }
});
</script>

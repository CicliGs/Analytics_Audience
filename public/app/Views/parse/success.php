<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">Success!</h4>
    <p>The CSV file has been successfully uploaded and processed.</p>
</div>

<div class="mt-4">
    <a href="/analyze" class="btn btn-primary">View Data</a>
    <a href="/parse" class="btn btn-secondary">Upload Another File</a>
</div>
</div>

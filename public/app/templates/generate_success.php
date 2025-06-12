<?php require_once __DIR__ . '/header.php'; ?>

<div class="container">
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Success!</h4>
        <p>Test data has been successfully generated.</p>
    </div>
    
    <div class="mt-4">
        <a href="/analyze" class="btn btn-primary">View Data</a>
        <a href="/generate" class="btn btn-secondary">Generate More Data</a>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
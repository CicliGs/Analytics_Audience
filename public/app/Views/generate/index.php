<?php require_once __DIR__ . '/../layouts/header.php'; ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Generate Test Data</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/generate" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Number of Records</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="10000" required>
                                <div class="form-text">Enter the number of records to generate (1-10000)</div>
                            </div>
                            <div class="mb-3">
                                <label for="csv_file" class="form-label">Select CSV File (Optional)</label>
                                <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv">
                                <div class="form-text">If no file is selected, a new file will be created</div>
                            </div>
                            <button type="submit" class="btn btn-primary">Generate Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

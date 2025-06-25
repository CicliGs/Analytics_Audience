<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <h1 class="mb-4">User Analytics</h1>
    <form method="POST" action="/analyze" class="mb-4 p-4 border rounded shadow-sm bg-light">
        <div class="row mb-3">
            <div class="col">
                <label for="country" class="form-label">Country</label>
                <input type="text" id="country" name="country" class="form-control" placeholder="Country" value="<?= htmlspecialchars($_POST['country'] ?? '') ?>">
            </div>
            <div class="col">
                <label for="city" class="form-label">City</label>
                <input type="text" id="city" name="city" class="form-control" placeholder="City" value="<?= htmlspecialchars($_POST['city'] ?? '') ?>">
            </div>
            <div class="col">
                <label for="isActive" class="form-label">Is Active</label>
                <select id="isActive" name="isActive" class="form-control">
                    <option value="">All</option>
                    <option value="1" <?= ($_POST['isActive'] ?? '') === '1' ? 'selected' : '' ?>>Yes</option>
                    <option value="0" <?= ($_POST['isActive'] ?? '') === '0' ? 'selected' : '' ?>>No</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="gender" class="form-label">Gender</label>
                <input type="text" id="gender" name="gender" class="form-control" placeholder="Gender" value="<?= htmlspecialchars($_POST['gender'] ?? '') ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="hasChildren" class="form-label">Has Children</label>
                <select id="hasChildren" name="hasChildren" class="form-control">
                    <option value="">All</option>
                    <option value="1" <?= ($_POST['hasChildren'] ?? '') === '1' ? 'selected' : '' ?>>Yes</option>
                    <option value="0" <?= ($_POST['hasChildren'] ?? '') === '0' ? 'selected' : '' ?>>No</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="familyStatus" class="form-label">Family Status</label>
                <input type="text" id="familyStatus" name="familyStatus" class="form-control" placeholder="Family Status" value="<?= htmlspecialchars($_POST['familyStatus'] ?? '') ?>">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>
</div>

<?php if (! empty($results)): ?>
    <div class="container mt-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Country</th>
                    <th>City</th>
                    <th>Is Active</th>
                    <th>Gender</th>
                    <th>Birth Date</th>
                    <th>Salary</th>
                    <th>Has Children</th>
                    <th>Family Status</th>
                    <th>Registration Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['country'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['city'] ?? '') ?></td>
                        <td><?= $row['isActive'] ? 'Yes' : 'No' ?></td>
                        <td><?= htmlspecialchars($row['gender'] ?? '') ?></td>
                        <td><?= $row['birthDate'] ? date('Y-m-d', strtotime($row['birthDate'])) : '-' ?></td>
                        <td><?= $row['salary'] ? number_format((float)$row['salary'], 2) : '-' ?></td>
                        <td><?= $row['hasChildren'] ? 'Yes' : 'No' ?></td>
                        <td><?= htmlspecialchars($row['familyStatus'] ?? '') ?></td>
                        <td><?= $row['registrationDate'] ? date('Y-m-d', strtotime($row['registrationDate'])) : '-' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="container mt-4 alert alert-info">No results found.</div>
<?php endif; ?>

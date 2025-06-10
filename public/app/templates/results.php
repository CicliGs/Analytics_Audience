<?php require_once __DIR__ . '/header.php'; ?>
<?php require_once __DIR__ . '/filter_form.php'; ?>

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
                <td><?= htmlspecialchars($row['country']) ?></td>
                <td><?= htmlspecialchars($row['city']) ?></td>
                <td><?= $row['isActive'] ? 'Yes' : 'No' ?></td>
                <td><?= htmlspecialchars($row['gender']) ?></td>
                <td><?= htmlspecialchars($row['birthDate']) ?></td>
                <td><?= htmlspecialchars($row['salary']) ?></td>
                <td><?= $row['hasChildren'] ? 'Yes' : 'No' ?></td>
                <td><?= htmlspecialchars($row['familyStatus']) ?></td>
                <td><?= htmlspecialchars($row['registrationDate']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
    <div class="alert alert-info">No results found.</div>
<?php endif; ?>

<?php require_once __DIR__ . '/footer.php'; ?>

<div class="container mt-4">
    <h1 class="mb-4">User Analytics</h1>
    <form method="POST" action="/analyze" class="mb-4 p-4 border rounded shadow-sm bg-light">
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="country" class="form-control" placeholder="Country" value="<?= htmlspecialchars($_POST['country'] ?? '') ?>">
            </div>
            <div class="col">
                <input type="text" name="city" class="form-control" placeholder="City" value="<?= htmlspecialchars($_POST['city'] ?? '') ?>">
            </div>
            <div class="col">
                <select name="isActive" class="form-control">
                    <option value="">Is Active</option>
                    <option value="true" <?= ($_POST['isActive'] ?? '') === 'true' ? 'selected' : '' ?>>Yes</option>
                    <option value="false" <?= ($_POST['isActive'] ?? '') === 'false' ? 'selected' : '' ?>>No</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="gender" class="form-control" placeholder="Gender" value="<?= htmlspecialchars($_POST['gender'] ?? '') ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <select name="hasChildren" class="form-control">
                    <option value="">Has Children</option>
                    <option value="true" <?= ($_POST['hasChildren'] ?? '') === 'true' ? 'selected' : '' ?>>Yes</option>
                    <option value="false" <?= ($_POST['hasChildren'] ?? '') === 'false' ? 'selected' : '' ?>>No</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="familyStatus" class="form-control" placeholder="Family Status" value="<?= htmlspecialchars($_POST['familyStatus'] ?? '') ?>">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>
</div>
<form method="GET" action="index.php" class="mb-4 p-4 border rounded shadow-sm bg-light">
    <div class="row mb-3">
        <div class="col">
            <input type="text" name="country" class="form-control" placeholder="Country">
        </div>
        <div class="col">
            <input type="text" name="city" class="form-control" placeholder="City">
        </div>
        <div class="col">
            <select name="isActive" class="form-control">
                <option value="">Is Active</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <input type="text" name="gender" class="form-control" placeholder="Gender">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <select name="hasChildren" class="form-control">
                <option value="">Has Children</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <input type="text" name="familyStatus" class="form-control" placeholder="Family Status">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </div>
</form>

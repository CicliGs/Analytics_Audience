<form method="GET" action="index.php" class="mb-4">
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
        <div class="col">
            <input type="date" name="birthDateStart" class="form-control" placeholder="Birth Date Start">
        </div>
        <div class="col">
            <input type="date" name="birthDateEnd" class="form-control" placeholder="Birth Date End">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <input type="number" name="salaryMin" class="form-control" placeholder="Min Salary">
        </div>
        <div class="col">
            <input type="number" name="salaryMax" class="form-control" placeholder="Max Salary">
        </div>
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
        <div class="col">
            <input type="date" name="registrationDateStart" class="form-control" placeholder="Registration Date Start">
        </div>
        <div class="col">
            <input type="date" name="registrationDateEnd" class="form-control" placeholder="Registration Date End">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </div>
</form>

<form action="./change_password.php" style='width: 50%;' method="post" onsubmit="return checkForm(this);">
    <div class="form-group">
        <label for="pwd">Old password:</label>
        <input type="password" class="form-control" name="oldpass" required="">
    </div>
    <div class="form-group">
        <label for="pwd">New Password:</label>
        <input type="number" class="form-control" name="newpass" required="">
    </div>
    <div class="form-group">
        <label for="pwd">Confirm New Password:</label>
        <input type="number" class="form-control" name="confirm_password" id="confirm_password" required="">
    </div>
    <button type="submit" class="btn btn-default">Confirm</button>
    <!--<button type="submit" class="btn btn-default">Confirm</button>-->
</form>
<script type="text/javascript">
    function checkForm(form)
    {
        if (form.newpass.value == form.confirm_password.value) {
            return true;
        } else {
            alert("Error: Please check that you've entered and confirmed your password!");
            form.newpass.focus();
            return false;
        }
    }
</script>
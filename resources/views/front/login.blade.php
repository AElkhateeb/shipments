<form method="post" action="{{ url('/account/login').'?redirect='.Request::path() }}"> @csrf
    <div class="form-group">
        <div class="input-with-icon">
            <input type="text" class="form-control" placeholder="E-mail" name="email"> <i class="ti-user"></i> </div>
    </div>
    <div class="form-group">
        <div class="input-with-icon">
            <input type="password" class="form-control" placeholder="*******" name="password"> <i class="ti-unlock"></i> </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-md full-width pop-login">Login</button>
    </div>
</form>
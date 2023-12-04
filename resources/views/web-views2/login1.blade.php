@extends('layouts.front-end.app')
@section('content')
<br>
<br>
<br>
<br>
    <main class="main-content" id="MainContent">
        <div class="page-width page-width--tiny page-content">
            <header class="section-header">
                <h1 class="section-header__title">Login</h1>
            </header>

            <div class="note note--success hide" id="ResetSuccess">
                We&#39;ve sent you an email with a link to update your password.
            </div>

            <div id="CustomerLoginForm" class="form-vertical">
                <form method="post" action="/account/login" id="customer_login" accept-charset="UTF-8"
                    data-login-with-shop-sign-in="true"><input type="hidden" name="form_type"
                        value="customer_login" /><input type="hidden" name="utf8" value="✓" />

                    <label for="CustomerEmail">Email</label>
                    <input type="email" name="customer[email]" id="CustomerEmail" class="input-full"
                        autocorrect="off" autocapitalize="off" autofocus>
                    <div class="grid">
                        <div class="grid__item one-half">
                            <label for="CustomerPassword">Password</label>
                        </div>
                        <div class="grid__item one-half text-right">
                            <small class="label-info">
                                <a href="#recover" id="RecoverPassword">
                                    Forgot password?
                                </a>
                            </small>
                        </div>
                    </div>
                    <input type="password" value="" name="customer[password]" id="CustomerPassword"
                        class="input-full">
                    <p>
                        <button type="submit" class="btn btn--full">
                            Sign In
                        </button>
                    </p>
                    <p><a href="{{route('register1')}}" id="customer_register_link">Create account</a></p><input
                        type="hidden" name="return_url" value="/account" />
                </form>
            </div>

            <div id="RecoverPasswordForm" class="hide">
                <div class="form-vertical">
                    <h2>Reset your password</h2>
                    <p>We will send you an email to reset your password.</p>
                    <form method="post" action="/account/recover" accept-charset="UTF-8"><input type="hidden"
                            name="form_type" value="recover_customer_password" /><input type="hidden"
                            name="utf8" value="✓" />
                        <label for="RecoverEmail">Email</label>
                        <input type="email" value="" name="email" id="RecoverEmail" class="input-full"
                            autocorrect="off" autocapitalize="off">

                        <p>
                            <button type="submit" class="btn">
                                Submit
                            </button>
                        </p>
                        <button type="button" id="HideRecoverPasswordLink">Cancel</button>
                    </form>
                </div>

            </div>
        </div>

    </main>
@endsection
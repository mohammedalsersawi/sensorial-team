 <!-- Background -->
 <x-adimnPart.header />

 <div class="account-pages"></div>
 <!-- Begin page -->


<div class="wrapper-page">

    <div class="card">
        <div class="card-body">

            <div class="auth-logo">
                <h3 class="text-center">
                    <a href="index.html" class="logo d-block my-4">
                        <img src="{{ asset('adminassets/images/logo-dark.png') }}" class="logo-dark mx-auto" height="30" alt="logo-dark">
                        <img src="{{ asset('adminassets/images/logo-light.png') }}" class="logo-light mx-auto" height="30" alt="logo-light">
                    </a>
                </h3>
            </div>

            <div class="p-3">
                <h4 class="text-muted font-size-18 text-center">Welcome Back !</h4>
                <p class="text-muted text-center">Sign in to continue to Agroxa.</p>
                @if ($errors->any())
                    <div class="font-medium text-red-600">
                    </div>
                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li class="Center badge bg-primary">{{ $error }}</li>
                        @endforeach
                    </ul>
            @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="email" :value="__('Email')">Email</label>
                        <input  class="form-control" id="email" type="email" name="email" :value="old('email')" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password" :value="__('Password')">Password</label>
                        <input  class="form-control" id="password"  type="password"
                        name="password"
                        required autocomplete="current-password">
                    </div>

                    <div class="mb-3 row">
                        <div class="col-6">
                            {{-- <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="customControlInline">
                                <label class="form-check-label" for="customControlInline">Remember
                                    me</label>
                            </div> --}}
                        </div>
                        <div class="col-6 text-end">
                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        {{-- <div class="col-12">
                            <a href="pages-recoverpw.html" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your
                                password?</a>
                        </div> --}}
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="text-center">
        {{-- <p class="text-white-50">Don't have an account ? <a href="pages-register.html" class="text-white"> Signup Now
            </a> </p> --}}
        <p class="text-muted">
            ©
            <script>document.write(new Date().getFullYear())</script>  Crafted with
            by<i class="mdi mdi-heart text-primary"></i>
            Hamo<i class="mdi mdi-heart text-primary"></i>
        </p>
    </div>

</div>

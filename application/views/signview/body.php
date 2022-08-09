<!-- ======= Hero Section ======= -->

<body>
    <div id="hero" class="signview">
        <h1 class="userpage" style="color: darkblue;">User LoginPage</h1>
        <div class="signviewcontainer max-w-sm sm:max-w-5xl" style="background-color: lightgray; border-radius: 10px;">
            <input id="signin" type="radio" name="tab" checked="checked" />
            <input id="register" type="radio" name="tab" />
            <div class="pages">
                <div class="page">
                    <div class="input">
                        <div class="title"><i class="material-icons">account_box</i> USERNAME</div>
                        <input class="text" type="text" id="loginemail" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="title"><i class="material-icons">lock</i> PASSWORD</div>
                        <input class="text" type="password" id="loginpassword" placeholder="" />
                    </div>
                    <div class="input">
                        <div class="flex justify-between">
                            <div class="text-sm items-center flex gap-1">
                                <label class="checkbox">
                                    <input type="checkbox" checked="">
                                    <span>Remember me</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="input">
                        <input type="button" onclick="signin()" value="ENTER" />
                    </div>
                    <div class="input text-center text-lg">
                        <div class="text-lg">Don't you have an account?</div>
                    </div>
                </div>
            </div>
            <div class="tabs">
                <label class="tab text" for="signin">
                    Sign In</label>
            </div>
        </div>
    </div>
    <div class="w-full sm:w-0"></div>
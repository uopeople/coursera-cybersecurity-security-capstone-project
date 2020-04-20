<?php
// no variables needed, static content

use lib\components\AppInfo;

?>

<div id="header" class="is-size-1">
    <!-- include directly via SVG -->
    <span class="icon is-large">
        <svg focusable="false" class="svg-inline--fa fa-comments fa-w-18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M416 192c0-88.4-93.1-160-208-160S0 103.6 0 192c0 34.3 14.1 65.9 38 92-13.4 30.2-35.5 54.2-35.8 54.5-2.2 2.3-2.8 5.7-1.5 8.7S4.8 352 8 352c36.6 0 66.9-12.3 88.7-25 32.2 15.7 70.3 25 111.3 25 114.9 0 208-71.6 208-160zm122 220c23.9-26 38-57.7 38-92 0-66.9-53.5-124.2-129.3-148.1.9 6.6 1.3 13.3 1.3 20.1 0 105.9-107.7 192-240 192-10.8 0-21.3-.8-31.7-1.9C207.8 439.6 281.8 480 368 480c41 0 79.1-9.2 111.3-25 21.8 12.7 52.1 25 88.7 25 3.2 0 6.1-1.9 7.3-4.8 1.3-2.9.7-6.3-1.5-8.7-.3-.3-22.4-24.2-35.8-54.5z"></path></svg>
    </span>
    <h1>&nbsp;Coursera Capstone Project Messaging System</h1>
</div>

<section class="section">
    <p class="content has-text-centered">
        This is the <i>Coursera Capstone Project Messaging System</i> implemented by <i>Group 8</i>.
        To start chatting, you need to <a href="<?= AppInfo::urlLoginPage() ?>">Login</a> first.
        If you don't have an account already, you can <a href="<?= AppInfo::urlRegisterPage() ?>">sign up here</a>.
    </p>
</section>

<div id="main-links">
    <p id="login">
        <a href="<?= AppInfo::urlLoginPage() ?>" class="large-font">
            <span class="icon">
                <svg focusable="false" class="svg-inline--fa fa-home fa-w-18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor"
                                                                                                                                             d="M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z"></path></svg>
            </span> Log in
        </a>
    </p>
    <p id="register">
        <a href="<?= AppInfo::urlRegisterPage() ?>" class="large-font">
            <span class="icon">
                <svg focusable="false" class="svg-inline--fa fa-user-plus fa-w-20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path
                            fill="currentColor"
                            d="M624 208h-64v-64c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v64h-64c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h64v64c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-64h64c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zm-400 48c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path></svg>
            </span> Register
        </a>
    </p>
</div>

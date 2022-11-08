<template>
    <nav class="navbar is-fixed-top is-spaced" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <p class="navbar-item">TuneUp</p>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="topNavbar">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="topNavbar" class="navbar-menu">
            <div class="navbar-start">
                <router-link to="/" class="navbar-item">Home</router-link>
            </div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <router-link to="/sign-in/" class="button is-primary"><strong>Sign In</strong></router-link>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>
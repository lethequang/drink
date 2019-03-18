<?php

if (!function_exists('partner_url')) {
    /**
     * Appends the configured partner prefix and returns
     * the URL using the standard Laravel helpers.
     *
     * @param $path
     *
     * @return string
     */
    function partner_url($path = null)
    {
        $path = !$path || (substr($path, 1, 1) == '/') ? $path : '/'.$path;

        return url('partner'.$path);
//        return url(config('partner.base.route_prefix', 'admin').$path);
    }
}

if (!function_exists('partner_guard_name')) {
    /*
     * Returns the name of the guard defined
     * by the application config
     */
    function partner_guard_name()
    {
        return 'partner'; //config('partner.base.guard', config('auth.defaults.guard'));
    }
}

if (!function_exists('partner_auth')) {
    /*
     * Returns the user instance if it exists
     * of the currently authenticated admin
     * based off the defined guard.
     */
    function partner_auth()
    {
        return \Auth::guard(partner_guard_name());
    }
}

if (!function_exists('partner_user')) {
    /*
     * Returns back a user instance without
     * the admin guard, however allows you
     * to pass in a custom guard if you like.
     */
    function partner_user()
    {
        return partner_auth()->user();
    }
}

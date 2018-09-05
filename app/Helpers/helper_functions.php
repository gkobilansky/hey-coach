<?php

if (!function_exists('get_subdomain')) {

    /**
     * Returns a human readable file size
     *
     * @param User $user_model
     * User model class
     *
     * @return subdomain for url based on user's college
     *
     * */
    function get_subdomain(App\Models\User $user_model)
    {
    	$college = $user_model->college;
    	return $college->sub_domain_name;
    }
}
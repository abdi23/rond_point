<?php

namespace App\Helpers;

use App\Models\Post;
use App\Models\Term;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Dashboard
{

    /**
     * @return array
     */
    public static function roles() {
        return User::showRoles();
    }

    /**
     * @return Builder[]|Collection
     */
    public static function getDataTaxonomy() {
        return Term::with('taxonomy')->get();
    }

    /**
     * @return mixed
     */
    public static function countPost() {
        return Posts::postCountAlt();
    }

    /**
     * @return mixed
     */
    public static function countPage() {
        return Post::ofType('page')->count();
    }

    /**
     * @return mixed
     */
    public static function countPermission() {
        return Permission::count();
    }

    /**
     * @return mixed
     */
    public static function countGallery() {
        return Post::ofType('gallery')->count();
    }

    /**
     * @return mixed
     */
    public static function countUser() {
        if (Auth::User()->hasRole('superadmin')) {
            return User::count();
        } else {
            return User::role(self::roles())->count();
        }
    }

    /**
     * @return mixed
     */
    public static function countRole() {
        if (Auth::User()->hasRole('superadmin')) {
            return Role::count();
        } else {
            return Role::whereIn('name', self::roles())->count();
        }
    }

    /**
     * @return int
     */
    public static function countCategory() {
        if ( is_null(Term::with('taxonomy')->first()) === TRUE ) {
            return 0;
        } else {
            return self::getDataTaxonomy()->first()->taxonomy->where('taxonomy','category')->count();
        }
    }

    /**
     * @return int
     */
    public static function countTag() {
        if ( is_null(Term::with('taxonomy')->first()) === TRUE ) {
            return 0;
        } else {
            return self::getDataTaxonomy()->first()->taxonomy->where('taxonomy','tag')->count();
        }
    }
}

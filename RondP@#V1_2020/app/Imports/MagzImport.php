<?php

namespace App\Imports;

use App\Imports\Sheets\AdPlacementAdvertisementSheetImport;
use App\Imports\Sheets\AdPlacementSheetImport;
use App\Imports\Sheets\AdvertisementSheetImport;
use App\Imports\Sheets\MenuItemSheetImport;
use App\Imports\Sheets\MenuSheetImport;
use App\Imports\Sheets\PermissionSheetImport;
use App\Imports\Sheets\PostSheetImport;
use App\Imports\Sheets\RoleHasPermissionSheetImport;
use App\Imports\Sheets\RoleSheetImport;
use App\Imports\Sheets\SettingSheetImport;
use App\Imports\Sheets\SocialmediaSheetImport;
use App\Imports\Sheets\TermRelationshipSheetImport;
use App\Imports\Sheets\TermSheetImport;
use App\Imports\Sheets\TermTaxonomySheetImport;
use App\Imports\Sheets\UserSheetImport;
use App\Imports\Sheets\UserSocialmediaSheetImport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MagzImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Setting'                    => new SettingSheetImport(),
            'Role'                       => new RoleSheetImport(),
            'Permission'                 => new PermissionSheetImport(),
            'Role has permissions'       => new RoleHasPermissionSheetImport(),
            'User'                       => new UserSheetImport(),
            'Socialmedia'                => new SocialmediaSheetImport(),
            'User Socialmedia'           => new UserSocialmediaSheetImport(),
            'Term'                       => new TermSheetImport(),
            'Term Taxonomy'              => new TermTaxonomySheetImport(),
            'Post'                       => new PostSheetImport(),
            'Term Relationship'          => new TermRelationshipSheetImport(),
            'Menu'                       => new MenuSheetImport(),
            'Menu Item'                  => new MenuItemSheetImport(),
            'Advertisement'              => new AdvertisementSheetImport(),
            'Ad Placement'               => new AdPlacementSheetImport(),
            'Ad Placement Advertisement' => new AdPlacementAdvertisementSheetImport(),
        ];
    }
}

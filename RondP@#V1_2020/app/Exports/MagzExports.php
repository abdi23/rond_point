<?php

namespace App\Exports;

use App\Exports\Sheets\AdPlacementAdvertisementSheet;
use App\Exports\Sheets\AdPlacementSheet;
use App\Exports\Sheets\AdvertisementSheet;
use App\Exports\Sheets\MenuItemSheet;
use App\Exports\Sheets\MenuSheet;
use App\Exports\Sheets\PermissionSheet;
use App\Exports\Sheets\PostSheet;
use App\Exports\Sheets\RoleHasPermissionSheet;
use App\Exports\Sheets\RolesSheet;
use App\Exports\Sheets\SettingSheet;
use App\Exports\Sheets\SocialMediaSheet;
use App\Exports\Sheets\TermRelationshipSheet;
use App\Exports\Sheets\TermSheet;
use App\Exports\Sheets\TermTaxonomySheet;
use App\Exports\Sheets\UserSheet;
use App\Exports\Sheets\UserSocialmediaSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MagzExports implements WithMultipleSheets
{
    use Exportable;

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new SettingSheet();
        $sheets[] = new RolesSheet();
        $sheets[] = new PermissionSheet();
        $sheets[] = new RoleHasPermissionSheet();
        $sheets[] = new UserSheet();
        $sheets[] = new SocialMediaSheet();
        $sheets[] = new UserSocialmediaSheet();
        $sheets[] = new TermSheet();
        $sheets[] = new TermTaxonomySheet();
        $sheets[] = new TermRelationshipSheet();
        $sheets[] = new PostSheet();
        $sheets[] = new MenuSheet();
        $sheets[] = new MenuItemSheet();
        $sheets[] = new AdvertisementSheet();
        $sheets[] = new AdPlacementSheet();
        $sheets[] = new AdPlacementAdvertisementSheet();

        return $sheets;
    }
}
